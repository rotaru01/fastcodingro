<?php
/**
 * API: Trimitere formular de contact
 * POST /api/contact-submit
 *
 * Parametri POST:
 *   - csrf_token: token CSRF
 *   - name: numele expeditorului
 *   - email: adresa de email
 *   - phone: (opțional) telefon
 *   - service: (opțional) serviciul selectat
 *   - message: textul mesajului
 *   - website_url: câmp honeypot (trebuie gol)
 *
 * Returnează JSON cu rezultatul operației
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

session_start();

// Verificare metodă
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metoda nu este permisă.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Citire date
$input = $_POST;
$isJsonRequest = false;
if (empty($input)) {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
    $isJsonRequest = true;
}

// Verificare CSRF (skip pentru JSON AJAX - CORS protejează cross-origin)
if (!$isJsonRequest) {
    $csrfToken = $input['csrf_token'] ?? '';
    if (empty($csrfToken) || !isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Token de securitate invalid. Vă rugăm să reîncărcați pagina.',
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    unset($_SESSION['csrf_token']);
}

// Verificare honeypot (anti-spam)
$honeypot = $input['website_url'] ?? '';
if (!empty($honeypot)) {
    echo json_encode([
        'success' => true,
        'message' => 'Mesajul a fost trimis cu succes.',
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// Sanitizare
function sanitizeInput(string $value): string
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    return $value;
}

$name    = sanitizeInput($input['name'] ?? '');
$email   = sanitizeInput($input['email'] ?? '');
$phone   = sanitizeInput($input['phone'] ?? '');
$service = sanitizeInput($input['service'] ?? '');
$message = sanitizeInput($input['message'] ?? '');

// Validare
$errors = [];

if (empty($name)) {
    $errors[] = 'Numele este obligatoriu.';
} elseif (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
    $errors[] = 'Numele trebuie să aibă între 2 și 100 de caractere.';
}

if (empty($email)) {
    $errors[] = 'Adresa de email este obligatorie.';
} elseif (!filter_var(html_entity_decode($email), FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Adresa de email nu este validă.';
}

if (empty($message)) {
    $errors[] = 'Mesajul este obligatoriu.';
} elseif (mb_strlen($message) < 10) {
    $errors[] = 'Mesajul trebuie să aibă cel puțin 10 caractere.';
} elseif (mb_strlen($message) > 5000) {
    $errors[] = 'Mesajul nu poate depăși 5000 de caractere.';
}

if (!empty($phone) && !preg_match('/^[\+]?[0-9\s\-\(\)]{7,20}$/', html_entity_decode($phone))) {
    $errors[] = 'Numărul de telefon nu este valid.';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Vă rugăm să corectați erorile.',
        'errors'  => $errors,
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../config/constants.php';
    require_once __DIR__ . '/../src/Core/Database.php';
    require_once __DIR__ . '/../src/Models/Message.php';

    $messageModel = new \Scanbox\Models\Message();

    $messageData = [
        'name'       => $name,
        'email'      => $email,
        'phone'      => $phone,
        'service_interest' => $service,
        'message'    => $message,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        'user_agent' => mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
        'status'     => 'new',
    ];

    $messageId = $messageModel->create($messageData);

    // Trimitere notificare email
    $adminEmail = defined('ADMIN_EMAIL') ? ADMIN_EMAIL : 'office@scanbox.ro';
    $subject = 'Mesaj nou de contact - ' . ($service ?: 'Fără subiect') . ' - Scanbox.ro';

    $emailBody = "Mesaj nou de contact pe Scanbox.ro\n\n";
    $emailBody .= "Nume: {$name}\n";
    $emailBody .= "Email: {$email}\n";
    $emailBody .= "Telefon: {$phone}\n";
    $emailBody .= "Serviciu: {$service}\n";
    $emailBody .= "Mesaj: {$message}\n\n";
    $emailBody .= "Data: " . date('d.m.Y H:i') . "\n";
    $emailBody .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'N/A') . "\n";

    $headers = [
        'From: noreply@scanbox.ro',
        'Reply-To: ' . html_entity_decode($email),
        'Content-Type: text/plain; charset=UTF-8',
    ];

    @mail($adminEmail, $subject, $emailBody, implode("\r\n", $headers));

    echo json_encode([
        'success' => true,
        'message' => 'Mesajul a fost trimis cu succes. Vă vom contacta în cel mai scurt timp.',
    ], JSON_UNESCAPED_UNICODE);

} catch (\Throwable $e) {
    error_log('Eroare API contact-submit: ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'A apărut o eroare. Vă rugăm să încercați din nou mai târziu.',
    ], JSON_UNESCAPED_UNICODE);
}
