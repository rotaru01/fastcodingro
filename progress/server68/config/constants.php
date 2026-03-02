<?php
/**
 * Scanbox.ro - Constante ale aplicatiei
 *
 * Defineste rutele aplicatiei, tipurile de fisiere permise,
 * dimensiunile maxime si alte constante globale.
 *
 * @package Scanbox
 * @version 1.0.0
 */

declare(strict_types=1);

/**
 * Maparea rutelor catre controllere si metode
 *
 * Format: 'pattern' => ['controller', 'metoda', 'metoda_http']
 * Parametrii dinamici sunt marcati cu {param}
 */
define('ROUTES', [
    /** Pagini publice */
    'GET|/'                          => ['PageController', 'home'],
    'GET|/servicii/tur-virtual-3d'   => ['PageController', 'servicii', ['tur-virtual-3d']],
    'GET|/servicii/fotografie'       => ['PageController', 'servicii', ['fotografie']],
    'GET|/servicii/videografie-drone' => ['PageController', 'servicii', ['videografie-drone']],
    'GET|/servicii/randare-3d'       => ['PageController', 'servicii', ['randare-3d']],
    'GET|/servicii/social-media'     => ['PageController', 'servicii', ['social-media']],
    'GET|/sport-content'             => ['PageController', 'sportContent'],
    'GET|/portofoliu'                => ['PageController', 'portofoliu'],
    'GET|/portofoliu-reels'          => ['PageController', 'portofoliuReels'],
    'GET|/blog'                      => ['BlogController', 'index'],
    'GET|/blog/categorie/{slug}'     => ['BlogController', 'category'],
    'GET|/blog/{slug}'               => ['BlogController', 'show'],
    'GET|/contact'                   => ['PageController', 'contact'],
    'POST|/contact'                  => ['ContactController', 'submit'],
    'GET|/despre-noi'                => ['PageController', 'despreNoi'],

    /** Administrare */
    'GET|/admin'                     => ['AdminController', 'dashboard'],
    'GET|/admin/login'               => ['AuthController', 'loginForm'],
    'POST|/admin/login'              => ['AuthController', 'login'],
    'GET|/admin/logout'              => ['AuthController', 'logout'],
    'GET|/admin/blog'                => ['AdminController', 'blog'],
    'GET|/admin/blog/new'            => ['AdminController', 'blogNew'],
    'POST|/admin/blog/new'           => ['AdminController', 'blogNew'],
    'GET|/admin/blog/edit/{id}'      => ['AdminController', 'blogEdit'],
    'POST|/admin/blog/edit/{id}'     => ['AdminController', 'blogEdit'],
    'POST|/admin/blog/delete/{id}'   => ['AdminController', 'blogDelete'],
    'GET|/admin/gallery'             => ['AdminController', 'gallery'],
    'POST|/admin/gallery'            => ['AdminController', 'gallery'],
    'GET|/admin/portfolio'           => ['AdminController', 'portfolio'],
    'POST|/admin/portfolio'          => ['AdminController', 'portfolio'],
    'GET|/admin/testimonials'        => ['AdminController', 'testimonials'],
    'POST|/admin/testimonials'       => ['AdminController', 'testimonials'],
    'GET|/admin/clients'             => ['AdminController', 'clients'],
    'POST|/admin/clients'            => ['AdminController', 'clients'],
    'GET|/admin/messages'            => ['AdminController', 'messages'],
    'POST|/admin/messages'           => ['AdminController', 'messages'],
    'GET|/admin/settings'            => ['AdminController', 'settings'],
    'POST|/admin/settings'           => ['AdminController', 'settings'],
    'GET|/admin/pricing'             => ['AdminController', 'pricing'],
    'POST|/admin/pricing'            => ['AdminController', 'pricing'],
]);

/**
 * Tipuri de fisiere permise pentru incarcare
 *
 * Mapare extensie => tip MIME
 */
define('ALLOWED_FILE_TYPES', [
    'image' => [
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp',
        'gif'  => 'image/gif',
    ],
    'video' => [
        'mp4'  => 'video/mp4',
        'webm' => 'video/webm',
        'mov'  => 'video/quicktime',
    ],
    'document' => [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ],
]);

/** Dimensiune maxima fisier imagine - 5 MB */
define('MAX_IMAGE_SIZE', 5 * 1024 * 1024);

/** Dimensiune maxima fisier video - 100 MB */
define('MAX_VIDEO_SIZE', 100 * 1024 * 1024);

/** Dimensiune maxima fisier document - 10 MB */
define('MAX_DOCUMENT_SIZE', 10 * 1024 * 1024);

/** Dimensiuni imagine */
define('IMAGE_MAX_WIDTH', 1920);
define('IMAGE_MAX_HEIGHT', 1080);
define('THUMBNAIL_WIDTH', 400);
define('THUMBNAIL_HEIGHT', 300);

/** Paginare */
define('ITEMS_PER_PAGE', 12);
define('BLOG_POSTS_PER_PAGE', 9);
define('ADMIN_ITEMS_PER_PAGE', 20);

/** Stari articole blog */
define('POST_STATUS_DRAFT', 'draft');
define('POST_STATUS_PUBLISHED', 'published');
define('POST_STATUS_ARCHIVED', 'archived');

/** Stari mesaje contact */
define('MESSAGE_STATUS_NEW', 'new');
define('MESSAGE_STATUS_READ', 'read');
define('MESSAGE_STATUS_REPLIED', 'replied');
define('MESSAGE_STATUS_ARCHIVED', 'archived');

/** Tipuri elemente galerie */
define('GALLERY_TYPE_IMAGE', 'image');
define('GALLERY_TYPE_VIDEO', 'video');
define('GALLERY_TYPE_EMBED', 'embed');

/** Tipuri logo-uri clienti */
define('CLIENT_TYPE_CLIENT', 'client');
define('CLIENT_TYPE_PARTNER', 'partner');

/** Tipuri setari */
define('SETTING_TYPE_TEXT', 'text');
define('SETTING_TYPE_TEXTAREA', 'textarea');
define('SETTING_TYPE_NUMBER', 'number');
define('SETTING_TYPE_BOOLEAN', 'boolean');
define('SETTING_TYPE_JSON', 'json');
define('SETTING_TYPE_IMAGE', 'image');

/** Roluri administrator */
define('ROLE_SUPER_ADMIN', 'super_admin');
define('ROLE_ADMIN', 'admin');
define('ROLE_EDITOR', 'editor');

/** Directoare pentru incarcari - relative la UPLOADS_PATH */
define('UPLOAD_DIRS', [
    'blog'         => 'blog/',
    'portfolio'    => 'portfolio/',
    'gallery'      => 'gallery/',
    'testimonials' => 'testimonials/',
    'clients'      => 'clients/',
    'settings'     => 'settings/',
]);

/** Durata cache in secunde */
define('CACHE_TTL_SHORT', 300);       // 5 minute
define('CACHE_TTL_MEDIUM', 1800);     // 30 minute
define('CACHE_TTL_LONG', 3600);       // 1 ora
define('CACHE_TTL_DAY', 86400);       // 24 ore

/** Versiune aplicatie */
define('APP_VERSION', '1.0.0');

/** Servicii disponibile - slug-uri valide */
define('VALID_SERVICE_SLUGS', [
    'tur-virtual-3d',
    'fotografie',
    'videografie-drone',
    'randare-3d',
    'social-media',
]);
