<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Core\Auth;
use Scanbox\Core\Database;
use Scanbox\Models\Message;

class MessageController
{
    private Message $messageModel;

    public function __construct()
    {
        if (!Auth::check()) {
            header('Location: /admin/login');
            exit;
        }

        $this->messageModel = new Message();
    }

    /**
     * Lista toate mesajele cu filtrare pe status
     */
    public function index(): void
    {
        $status = $_GET['status'] ?? null;
        $validStatuses = ['new', 'read', 'replied', 'archived'];

        if ($status !== null && in_array($status, $validStatuses, true)) {
            $messages = $this->messageModel->getByStatus($status);
        } else {
            $messages = $this->messageModel->getAll();
            $status = null;
        }

        // Numar mesaje pe fiecare status pentru badge-uri
        $statusCounts = [];
        foreach ($validStatuses as $s) {
            $statusCounts[$s] = $this->messageModel->countByStatus($s);
        }

        view('admin/messages/list', [
            'title' => 'Mesaje - Admin Scanbox.ro',
            'messages' => $messages,
            'currentStatus' => $status,
            'statusCounts' => $statusCounts,
        ]);
    }

    /**
     * Vizualizare mesaj individual - marcare ca citit
     */
    public function view(int $id): void
    {
        $message = $this->messageModel->getById($id);

        if ($message === null) {
            $_SESSION['flash_error'] = 'Mesajul nu a fost găsit.';
            header('Location: /admin/messages');
            exit;
        }

        // Marcare automata ca citit daca este nou
        if ($message['status'] === 'new') {
            $this->messageModel->updateStatus($id, 'read');
            $message['status'] = 'read';
        }

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;

        view('admin/messages/view', [
            'title' => 'Mesaj de la ' . htmlspecialchars($message['name']) . ' - Admin Scanbox.ro',
            'message' => $message,
            'csrfToken' => $csrfToken,
        ]);
    }

    /**
     * Marcare mesaj ca raspuns trimis (POST)
     */
    public function reply(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/messages/view/{$id}");
            exit;
        }

        $this->validateCsrf();

        $message = $this->messageModel->getById($id);
        if ($message === null) {
            $_SESSION['flash_error'] = 'Mesajul nu a fost găsit.';
            header('Location: /admin/messages');
            exit;
        }

        $replyNote = trim($_POST['reply_note'] ?? '');

        $this->messageModel->updateStatus($id, 'replied');

        // Salvare nota de raspuns daca exista
        if (!empty($replyNote)) {
            $this->messageModel->addNote($id, $replyNote, (int) $_SESSION['user_id']);
        }

        $this->logActivity('message_reply', "Răspuns la mesajul de la {$message['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Mesajul a fost marcat ca răspuns trimis.';
        header('Location: /admin/messages');
        exit;
    }

    /**
     * Arhivare mesaj (POST)
     */
    public function archive(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/messages/view/{$id}");
            exit;
        }

        $this->validateCsrf();

        $message = $this->messageModel->getById($id);
        if ($message === null) {
            $_SESSION['flash_error'] = 'Mesajul nu a fost găsit.';
            header('Location: /admin/messages');
            exit;
        }

        $this->messageModel->updateStatus($id, 'archived');
        $this->logActivity('message_archive', "Mesaj arhivat de la {$message['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Mesajul a fost arhivat.';
        header('Location: /admin/messages');
        exit;
    }

    /**
     * Stergere mesaj (POST)
     */
    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/messages/view/{$id}");
            exit;
        }

        $this->validateCsrf();

        $message = $this->messageModel->getById($id);
        if ($message === null) {
            $_SESSION['flash_error'] = 'Mesajul nu a fost găsit.';
            header('Location: /admin/messages');
            exit;
        }

        $this->messageModel->delete($id);
        $this->logActivity('message_delete', "Mesaj șters de la {$message['name']} (ID: {$id})");

        $_SESSION['flash_success'] = 'Mesajul a fost șters definitiv.';
        header('Location: /admin/messages');
        exit;
    }

    /**
     * Validare token CSRF
     */
    private function validateCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($token) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            $_SESSION['flash_error'] = 'Token de securitate invalid.';
            header('Location: /admin/messages');
            exit;
        }
    }

    /**
     * Inregistrare activitate in log
     */
    private function logActivity(string $action, string $description): void
    {
        try {
            $db = Database::getInstance();
            $db->insert('activity_log', [
                'user_id' => $_SESSION['user_id'],
                'action' => $action,
                'description' => $description,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            error_log('Eroare logare activitate: ' . $e->getMessage());
        }
    }
}
