<?php

declare(strict_types=1);

namespace Scanbox\Controllers;

use Scanbox\Models\Message;
use Scanbox\Core\Email;

class ContactController
{
    private Message $messageModel;

    public function __construct()
    {
        $this->messageModel = new Message();
    }

    /**
     * Procesare formular de contact (POST)
     */
    public function submit(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode([
                'success' => false,
                'message' => 'Metoda nu este permisă.',
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Validare token CSRF
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (empty($csrfToken) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'message' => 'Token de securitate invalid. Vă rugăm să reîncărcați pagina.',
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Invalidare token CSRF dupa utilizare
        unset($_SESSION['csrf_token']);

        // Verificare honeypot (anti-spam)
        $honeypot = $_POST['website_url'] ?? '';
        if (!empty($honeypot)) {
            // Bot detectat - returnam succes fals pentru a nu dezvalui mecanismul
            echo json_encode([
                'success' => true,
                'message' => 'Mesajul a fost trimis cu succes!',
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Preluare si sanitizare date
        $name = $this->sanitize($_POST['name'] ?? '');
        $email = $this->sanitize($_POST['email'] ?? '');
        $phone = $this->sanitize($_POST['phone'] ?? '');
        $subject = $this->sanitize($_POST['subject'] ?? '');
        $messageText = $this->sanitize($_POST['message'] ?? '');

        // Validare campuri obligatorii
        $errors = [];

        if (empty($name)) {
            $errors[] = 'Numele este obligatoriu.';
        } elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
            $errors[] = 'Numele trebuie să aibă între 2 și 100 de caractere.';
        }

        if (empty($email)) {
            $errors[] = 'Adresa de email este obligatorie.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Adresa de email nu este validă.';
        }

        if (empty($messageText)) {
            $errors[] = 'Mesajul este obligatoriu.';
        } elseif (mb_strlen($messageText) < 10) {
            $errors[] = 'Mesajul trebuie să aibă cel puțin 10 caractere.';
        } elseif (mb_strlen($messageText) > 5000) {
            $errors[] = 'Mesajul nu poate depăși 5000 de caractere.';
        }

        if (!empty($phone) && !preg_match('/^[\+]?[0-9\s\-\(\)]{7,20}$/', $phone)) {
            $errors[] = 'Numărul de telefon nu este valid.';
        }

        if (!empty($errors)) {
            http_response_code(422);
            echo json_encode([
                'success' => false,
                'message' => 'Vă rugăm să corectați erorile.',
                'errors' => $errors,
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        // Salvare mesaj in baza de date
        try {
            $messageData = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $messageText,
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'status' => 'new',
            ];

            $messageId = $this->messageModel->create($messageData);

            // Trimitere email notificare catre administrator
            $emailService = new Email();
            $emailBody = $this->buildNotificationEmail($name, $email, $phone, $subject, $messageText);

            $emailService->send(
                ADMIN_EMAIL,
                'Mesaj nou de contact - ' . ($subject ?: 'Fără subiect') . ' - Scanbox.ro',
                $emailBody
            );

            echo json_encode([
                'success' => true,
                'message' => 'Mesajul a fost trimis cu succes! Vă vom contacta în cel mai scurt timp.',
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            error_log('Eroare trimitere mesaj contact: ' . $e->getMessage());

            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'A apărut o eroare. Vă rugăm să încercați din nou mai târziu.',
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Sanitizare input utilizator
     */
    private function sanitize(string $input): string
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input;
    }

    /**
     * Construire email de notificare
     */
    private function buildNotificationEmail(
        string $name,
        string $email,
        string $phone,
        string $subject,
        string $message
    ): string {
        $date = date('d.m.Y H:i');

        return <<<HTML
        <!DOCTYPE html>
        <html lang="ro">
        <head><meta charset="UTF-8"></head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
            <h2 style="color: #1a1a2e;">Mesaj nou de contact - Scanbox.ro</h2>
            <hr style="border: 1px solid #eee;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; font-weight: bold; width: 120px;">Nume:</td>
                    <td style="padding: 8px;">{$name}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Email:</td>
                    <td style="padding: 8px;"><a href="mailto:{$email}">{$email}</a></td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Telefon:</td>
                    <td style="padding: 8px;">{$phone}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Subiect:</td>
                    <td style="padding: 8px;">{$subject}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold; vertical-align: top;">Mesaj:</td>
                    <td style="padding: 8px;">{$message}</td>
                </tr>
            </table>
            <hr style="border: 1px solid #eee;">
            <p style="font-size: 12px; color: #999;">
                Primit la: {$date} | IP: {$_SERVER['REMOTE_ADDR']}
            </p>
        </body>
        </html>
        HTML;
    }
}
