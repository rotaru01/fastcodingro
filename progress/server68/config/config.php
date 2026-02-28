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
define('DB_NAME', 'scanbox_db');
define('DB_USER', 'scanbox_user');
define('DB_PASS', 'CHANGE_ME_STRONG_PASSWORD');
define('DB_CHARSET', 'utf8mb4');

/** Configurare site */
define('SITE_URL', 'https://scanbox.ro');
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

/** Dezactivare afisare erori in productie */
error_reporting(0);
ini_set('display_errors', '0');

/** Activare logare erori */
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/error.log');
