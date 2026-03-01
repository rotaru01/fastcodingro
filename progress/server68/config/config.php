<?php
/**
 * Scanbox.ro - Configurare principala a aplicatiei
 *
 * Fisier de configurare cu constante globale pentru baza de date,
 * URL-uri, email, sesiuni si securitate.
 *
 * @package Scanbox
 * @version 1.0.0
 */

declare(strict_types=1);

/** Configurare baza de date */
define('DB_HOST', 'localhost');
define('DB_NAME', 'easyrent_scan');
define('DB_USER', 'easyrent');
define('DB_PASS', '@Ch@ng3m30@');
define('DB_CHARSET', 'utf8mb4');

/** Configurare site */
define('SITE_URL', 'https://fastcodingagency.ro');
define('BASE_URL_PATH', '');
define('SITE_NAME', 'Scanbox.ro');
define('ADMIN_EMAIL', 'office@scanbox.ro');

/** Cai pentru fisiere incarcate */
define('UPLOADS_PATH', __DIR__ . '/../public/uploads/');
define('UPLOADS_URL', SITE_URL . '/uploads/');

/** Configurare sesiuni */
define('SESSION_TIMEOUT', 1800); // 30 de minute

/** Configurare securitate - limitare incercari de autentificare */
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minute

/** Configurare fus orar Romania */
date_default_timezone_set('Europe/Bucharest');

/** Activare temporara afisare erori pentru debugging */
error_reporting(E_ALL);
ini_set('display_errors', '1');

/** Activare logare erori */
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/error.log');
