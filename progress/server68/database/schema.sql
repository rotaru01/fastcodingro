-- =============================================================================
-- Scanbox.ro - Schema completa a bazei de date MySQL
--
-- Versiune: 1.0.0
-- Motor: InnoDB cu charset utf8mb4_unicode_ci
-- Compatibil: MySQL 8.0+ / MariaDB 10.5+
--
-- Acest fisier creeaza toate tabelele necesare aplicatiei,
-- inclusiv relatiile (chei straine), indexii si datele initiale.
-- =============================================================================

-- Cream baza de date daca nu exista
CREATE DATABASE IF NOT EXISTS `scanbox_db`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `scanbox_db`;

-- Dezactivam verificarile de chei straine pe durata importului
SET FOREIGN_KEY_CHECKS = 0;

-- =============================================================================
-- Tabel: admins - Administratori si editori
-- =============================================================================
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL COMMENT 'Hash Argon2id al parolei',
    `name` VARCHAR(100) NOT NULL COMMENT 'Numele complet afisat',
    `role` ENUM('super_admin', 'admin', 'editor') NOT NULL DEFAULT 'editor',
    `last_login` DATETIME NULL DEFAULT NULL COMMENT 'Data ultimei autentificari',
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_admins_username` (`username`),
    UNIQUE KEY `uk_admins_email` (`email`),
    KEY `idx_admins_role` (`role`),
    KEY `idx_admins_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Administratori si editori ai platformei';

-- =============================================================================
-- Tabel: services - Servicii oferite
-- =============================================================================
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(100) NOT NULL COMMENT 'Identificator URL-friendly',
    `title_ro` VARCHAR(200) NOT NULL COMMENT 'Titlu in limba romana',
    `title_en` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Titlu in limba engleza',
    `subtitle_ro` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Subtitlu in limba romana',
    `subtitle_en` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Subtitlu in limba engleza',
    `description_ro` TEXT NULL DEFAULT NULL COMMENT 'Descriere completa in romana',
    `description_en` TEXT NULL DEFAULT NULL COMMENT 'Descriere completa in engleza',
    `icon_svg` TEXT NULL DEFAULT NULL COMMENT 'Cod SVG pentru iconita serviciului',
    `hero_image` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Calea catre imaginea hero',
    `meta_title` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Titlu SEO',
    `meta_description` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Descriere SEO',
    `meta_keywords` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Cuvinte cheie SEO',
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Ordinea de afisare',
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_services_slug` (`slug`),
    KEY `idx_services_sort_order` (`sort_order`),
    KEY `idx_services_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Serviciile oferite de Scanbox';

-- =============================================================================
-- Tabel: portfolio_categories - Categorii portofoliu
-- =============================================================================
DROP TABLE IF EXISTS `portfolio_categories`;
CREATE TABLE `portfolio_categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name_ro` VARCHAR(100) NOT NULL COMMENT 'Nume categorie in romana',
    `name_en` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Nume categorie in engleza',
    `slug` VARCHAR(100) NOT NULL COMMENT 'Identificator URL-friendly',
    `description_ro` TEXT NULL DEFAULT NULL COMMENT 'Descriere in romana',
    `description_en` TEXT NULL DEFAULT NULL COMMENT 'Descriere in engleza',
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_portfolio_categories_slug` (`slug`),
    KEY `idx_portfolio_categories_sort` (`sort_order`),
    KEY `idx_portfolio_categories_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Categorii pentru proiectele din portofoliu';

-- =============================================================================
-- Tabel: portfolio_projects - Proiecte din portofoliu
-- =============================================================================
DROP TABLE IF EXISTS `portfolio_projects`;
CREATE TABLE `portfolio_projects` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(200) NOT NULL COMMENT 'Identificator URL-friendly',
    `title` VARCHAR(300) NOT NULL COMMENT 'Titlul proiectului',
    `category_id` INT UNSIGNED NULL DEFAULT NULL COMMENT 'FK catre portfolio_categories',
    `city` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Orasul proiectului',
    `address` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Adresa completa',
    `lat` DECIMAL(10, 8) NULL DEFAULT NULL COMMENT 'Latitudine GPS',
    `lng` DECIMAL(11, 8) NULL DEFAULT NULL COMMENT 'Longitudine GPS',
    `matterport_url` VARCHAR(500) NULL DEFAULT NULL COMMENT 'URL embed Matterport',
    `thumbnail` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Calea catre thumbnail',
    `description` TEXT NULL DEFAULT NULL COMMENT 'Descriere proiect',
    `completion_date` DATE NULL DEFAULT NULL COMMENT 'Data finalizarii',
    `is_featured` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Proiect promovat pe homepage',
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `views_count` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Numar de vizualizari',
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_portfolio_projects_slug` (`slug`),
    KEY `idx_portfolio_projects_category` (`category_id`),
    KEY `idx_portfolio_projects_featured` (`is_featured`),
    KEY `idx_portfolio_projects_active` (`is_active`),
    KEY `idx_portfolio_projects_sort` (`sort_order`),
    KEY `idx_portfolio_projects_city` (`city`),
    CONSTRAINT `fk_portfolio_projects_category` FOREIGN KEY (`category_id`)
        REFERENCES `portfolio_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Proiecte din portofoliul Scanbox';

-- =============================================================================
-- Tabel: blog_categories - Categorii articole blog
-- =============================================================================
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL COMMENT 'Numele categoriei',
    `slug` VARCHAR(100) NOT NULL COMMENT 'Identificator URL-friendly',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_blog_categories_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Categorii pentru articolele de blog';

-- =============================================================================
-- Tabel: blog_posts - Articole blog
-- =============================================================================
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE `blog_posts` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `slug` VARCHAR(300) NOT NULL COMMENT 'Identificator URL-friendly',
    `title` VARCHAR(300) NOT NULL COMMENT 'Titlul articolului',
    `excerpt` TEXT NULL DEFAULT NULL COMMENT 'Rezumat scurt pentru listare',
    `content` LONGTEXT NOT NULL COMMENT 'Continutul complet al articolului',
    `featured_image` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Imaginea principala',
    `author_id` INT UNSIGNED NULL DEFAULT NULL COMMENT 'FK catre admins',
    `category_id` INT UNSIGNED NULL DEFAULT NULL COMMENT 'FK catre blog_categories',
    `tags` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Tag-uri separate prin virgula',
    `meta_title` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Titlu SEO',
    `meta_description` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Descriere SEO',
    `status` ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft' COMMENT 'Starea articolului',
    `published_at` DATETIME NULL DEFAULT NULL COMMENT 'Data publicarii',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_blog_posts_slug` (`slug`),
    KEY `idx_blog_posts_status` (`status`),
    KEY `idx_blog_posts_published_at` (`published_at`),
    KEY `idx_blog_posts_author` (`author_id`),
    KEY `idx_blog_posts_category` (`category_id`),
    CONSTRAINT `fk_blog_posts_author` FOREIGN KEY (`author_id`)
        REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_blog_posts_category` FOREIGN KEY (`category_id`)
        REFERENCES `blog_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Articole de blog';

-- =============================================================================
-- Tabel: galleries - Galerii foto/video
-- =============================================================================
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(200) NOT NULL COMMENT 'Numele galeriei',
    `slug` VARCHAR(200) NOT NULL COMMENT 'Identificator URL-friendly',
    `page` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Pagina unde este afisata galeria',
    `description` TEXT NULL DEFAULT NULL COMMENT 'Descrierea galeriei',
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_galleries_slug` (`slug`),
    KEY `idx_galleries_page` (`page`),
    KEY `idx_galleries_sort` (`sort_order`),
    KEY `idx_galleries_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Galerii foto si video';

-- =============================================================================
-- Tabel: gallery_items - Elemente din galerii
-- =============================================================================
DROP TABLE IF EXISTS `gallery_items`;
CREATE TABLE `gallery_items` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `gallery_id` INT UNSIGNED NOT NULL COMMENT 'FK catre galleries',
    `type` ENUM('image', 'video', 'embed') NOT NULL DEFAULT 'image' COMMENT 'Tipul elementului',
    `file_path` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Calea catre fisier',
    `thumbnail_path` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Calea catre thumbnail',
    `external_url` VARCHAR(500) NULL DEFAULT NULL COMMENT 'URL extern (YouTube, Vimeo)',
    `title` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Titlul elementului',
    `alt_text` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Text alternativ pentru imagini',
    `caption` TEXT NULL DEFAULT NULL COMMENT 'Legenda/descriere',
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_gallery_items_gallery` (`gallery_id`),
    KEY `idx_gallery_items_type` (`type`),
    KEY `idx_gallery_items_sort` (`sort_order`),
    KEY `idx_gallery_items_active` (`is_active`),
    CONSTRAINT `fk_gallery_items_gallery` FOREIGN KEY (`gallery_id`)
        REFERENCES `galleries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Elementele individuale din galerii';

-- =============================================================================
-- Tabel: messages - Mesaje de contact
-- =============================================================================
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL COMMENT 'Numele persoanei de contact',
    `email` VARCHAR(255) NOT NULL COMMENT 'Adresa email',
    `phone` VARCHAR(30) NULL DEFAULT NULL COMMENT 'Numar de telefon',
    `service_interest` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Serviciul de interes',
    `message` TEXT NOT NULL COMMENT 'Continutul mesajului',
    `ip_address` VARCHAR(45) NOT NULL COMMENT 'Adresa IP a expeditorului',
    `user_agent` VARCHAR(500) NULL DEFAULT NULL COMMENT 'User Agent al browserului',
    `status` ENUM('new', 'read', 'replied', 'archived') NOT NULL DEFAULT 'new' COMMENT 'Starea mesajului',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `read_at` DATETIME NULL DEFAULT NULL COMMENT 'Data cand a fost citit',
    `replied_at` DATETIME NULL DEFAULT NULL COMMENT 'Data cand s-a raspuns',
    PRIMARY KEY (`id`),
    KEY `idx_messages_status` (`status`),
    KEY `idx_messages_created_at` (`created_at`),
    KEY `idx_messages_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Mesaje primite prin formularul de contact';

-- =============================================================================
-- Tabel: testimonials - Recenzii clienti
-- =============================================================================
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `author_name` VARCHAR(100) NOT NULL COMMENT 'Numele autorului recenziei',
    `author_role` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Functia autorului',
    `author_company` VARCHAR(150) NULL DEFAULT NULL COMMENT 'Compania autorului',
    `author_photo` VARCHAR(500) NULL DEFAULT NULL COMMENT 'Calea catre fotografia autorului',
    `quote` TEXT NOT NULL COMMENT 'Textul recenziei',
    `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5 COMMENT 'Nota (1-5 stele)',
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_testimonials_active` (`is_active`),
    KEY `idx_testimonials_sort` (`sort_order`),
    KEY `idx_testimonials_rating` (`rating`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Recenzii si testimoniale de la clienti';

-- =============================================================================
-- Tabel: client_logos - Logo-uri clienti si parteneri
-- =============================================================================
DROP TABLE IF EXISTS `client_logos`;
CREATE TABLE `client_logos` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NOT NULL COMMENT 'Numele clientului/partenerului',
    `logo_path` VARCHAR(500) NOT NULL COMMENT 'Calea catre logo',
    `website_url` VARCHAR(500) NULL DEFAULT NULL COMMENT 'URL-ul website-ului',
    `type` ENUM('client', 'partner') NOT NULL DEFAULT 'client' COMMENT 'Tipul: client sau partener',
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_client_logos_type` (`type`),
    KEY `idx_client_logos_active` (`is_active`),
    KEY `idx_client_logos_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Logo-uri clienti si parteneri';

-- =============================================================================
-- Tabel: settings - Setari configurabile ale site-ului
-- =============================================================================
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `setting_key` VARCHAR(100) NOT NULL COMMENT 'Cheia unica a setarii',
    `setting_value` TEXT NULL DEFAULT NULL COMMENT 'Valoarea setarii',
    `setting_type` ENUM('text', 'textarea', 'number', 'boolean', 'json', 'image') NOT NULL DEFAULT 'text' COMMENT 'Tipul valorii',
    `setting_group` VARCHAR(50) NOT NULL DEFAULT 'general' COMMENT 'Grupul setarii',
    `description` VARCHAR(300) NULL DEFAULT NULL COMMENT 'Descrierea setarii',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_settings_key` (`setting_key`),
    KEY `idx_settings_group` (`setting_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Setari configurabile ale platformei';

-- =============================================================================
-- Tabel: pricing_packages - Pachete de pret
-- =============================================================================
DROP TABLE IF EXISTS `pricing_packages`;
CREATE TABLE `pricing_packages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `service_page` VARCHAR(100) NOT NULL COMMENT 'Pagina serviciului aferent',
    `name` VARCHAR(100) NOT NULL COMMENT 'Numele pachetului',
    `price` DECIMAL(10, 2) NOT NULL COMMENT 'Pretul pachetului',
    `currency` VARCHAR(3) NOT NULL DEFAULT 'EUR' COMMENT 'Moneda (EUR, RON)',
    `price_note` VARCHAR(200) NULL DEFAULT NULL COMMENT 'Nota pret (ex: de la, /luna)',
    `features_json` JSON NOT NULL COMMENT 'Lista functionalitati ca JSON',
    `is_featured` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Pachet recomandat',
    `is_active` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
    `sort_order` INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_pricing_service` (`service_page`),
    KEY `idx_pricing_featured` (`is_featured`),
    KEY `idx_pricing_active` (`is_active`),
    KEY `idx_pricing_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Pachete de pret pentru servicii';

-- =============================================================================
-- Tabel: activity_log - Jurnal de activitate
-- =============================================================================
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `admin_id` INT UNSIGNED NULL DEFAULT NULL COMMENT 'FK catre admins',
    `action` VARCHAR(50) NOT NULL COMMENT 'Actiunea efectuata',
    `entity_type` VARCHAR(50) NOT NULL COMMENT 'Tipul entitatii afectate',
    `entity_id` INT UNSIGNED NULL DEFAULT NULL COMMENT 'ID-ul entitatii afectate',
    `details` TEXT NULL DEFAULT NULL COMMENT 'Detalii suplimentare',
    `ip_address` VARCHAR(45) NOT NULL COMMENT 'Adresa IP',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_activity_admin` (`admin_id`),
    KEY `idx_activity_action` (`action`),
    KEY `idx_activity_entity` (`entity_type`, `entity_id`),
    KEY `idx_activity_created` (`created_at`),
    CONSTRAINT `fk_activity_log_admin` FOREIGN KEY (`admin_id`)
        REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Jurnal de activitate al administratorilor';

-- Reactivam verificarile de chei straine
SET FOREIGN_KEY_CHECKS = 1;

-- =============================================================================
-- DATE INITIALE
-- =============================================================================

-- -----------------------------------------------------------------------------
-- Administrator implicit
-- Parola: ScanboxAdmin2024! (hash Argon2id)
-- IMPORTANT: Schimbati parola dupa prima autentificare!
-- -----------------------------------------------------------------------------
INSERT INTO `admins` (`username`, `email`, `password_hash`, `name`, `role`, `is_active`) VALUES
('admin', 'office@scanbox.ro', '$argon2id$v=19$m=65536,t=4,p=3$Y1pHb3RXcGhKSzRQdjRDTQ$J9q6VbzQS8g6rdfU7VL5WGiH1UuCvxuN2kR4bGzM0Ys', 'Administrator Scanbox', 'super_admin', 1);

-- -----------------------------------------------------------------------------
-- Servicii implicite
-- -----------------------------------------------------------------------------
INSERT INTO `services` (`slug`, `title_ro`, `title_en`, `subtitle_ro`, `subtitle_en`, `description_ro`, `meta_title`, `meta_description`, `sort_order`, `is_active`) VALUES
('tur-virtual-3d', 'Tur Virtual 3D', '3D Virtual Tour', 'Experimenteaza spatiul ca si cum ai fi acolo', 'Experience the space as if you were there', 'Oferim servicii profesionale de scanare 3D si tur virtual pentru proprietati imobiliare, hoteluri, restaurante, showroom-uri si spatii comerciale. Tehnologia Matterport permite vizitatorilor sa exploreze spatiul in detaliu, din orice colt al lumii.', 'Tur Virtual 3D Matterport | Scanbox.ro', 'Servicii profesionale de tur virtual 3D cu tehnologie Matterport. Scanare 3D pentru imobiliare, hoteluri, restaurante si spatii comerciale.', 1, 1),
('fotografie', 'Fotografie Profesionala', 'Professional Photography', 'Imagini care spun povesti', 'Images that tell stories', 'Fotografie profesionala de interior si exterior pentru proprietati imobiliare, arhitectura, evenimente corporate si produse. Echipament de ultima generatie si post-procesare profesionala.', 'Fotografie Profesionala | Scanbox.ro', 'Servicii de fotografie profesionala pentru imobiliare, arhitectura, evenimente si produse. Echipament premium si post-procesare de calitate.', 2, 1),
('videografie-drone', 'Videografie si Drone', 'Videography & Drone', 'Perspective aeriene impresionante', 'Impressive aerial perspectives', 'Servicii de videografie profesionala si filmare cu drona pentru prezentari imobiliare, evenimente, constructii si turism. Filmare 4K, editare profesionala si livrare rapida.', 'Videografie Drone | Scanbox.ro', 'Videografie profesionala si filmare cu drona 4K. Prezentari imobiliare, evenimente, constructii si turism cu perspective aeriene.', 3, 1),
('randare-3d', 'Randare 3D', '3D Rendering', 'Vizualizeaza proiectul inainte de constructie', 'Visualize the project before construction', 'Servicii de randare 3D fotorealista pentru proiecte de arhitectura, design interior si dezvoltari imobiliare. Transformam planurile tehnice in imagini vizuale impresionante.', 'Randare 3D Fotorealista | Scanbox.ro', 'Randare 3D fotorealista pentru arhitectura si design interior. Vizualizari exterioare si interioare, tur virtual pe baza de proiect.', 4, 1),
('social-media', 'Social Media Content', 'Social Media Content', 'Continut vizual pentru prezenta online', 'Visual content for online presence', 'Creem continut vizual profesional pentru retelele sociale: fotografie, video, Reels, Stories si campanii vizuale. Strategie de continut personalizata pentru branduri din imobiliare si HoReCa.', 'Social Media Content | Scanbox.ro', 'Continut vizual profesional pentru social media. Foto, video, Reels si Stories pentru branduri din imobiliare si HoReCa.', 5, 1);

-- -----------------------------------------------------------------------------
-- Categorii portofoliu implicite
-- -----------------------------------------------------------------------------
INSERT INTO `portfolio_categories` (`name_ro`, `name_en`, `slug`, `description_ro`, `sort_order`, `is_active`) VALUES
('Tur Virtual 3D', '3D Virtual Tour', 'tur-virtual-3d', 'Proiecte de tur virtual 3D realizate cu tehnologie Matterport', 1, 1),
('Fotografie', 'Photography', 'fotografie', 'Proiecte de fotografie profesionala imobiliara si de arhitectura', 2, 1),
('Videografie', 'Videography', 'videografie', 'Proiecte de videografie si filmare cu drona', 3, 1),
('Randare 3D', '3D Rendering', 'randare-3d', 'Proiecte de randare 3D fotorealista', 4, 1),
('Social Media', 'Social Media', 'social-media', 'Proiecte de continut pentru social media', 5, 1);

-- -----------------------------------------------------------------------------
-- Categorii blog implicite
-- -----------------------------------------------------------------------------
INSERT INTO `blog_categories` (`name`, `slug`) VALUES
('Tur Virtual', 'tur-virtual'),
('Fotografie', 'fotografie'),
('Videografie', 'videografie'),
('Randare 3D', 'randare-3d'),
('Social Media', 'social-media'),
('Stiri', 'stiri'),
('Sfaturi', 'sfaturi');

-- -----------------------------------------------------------------------------
-- Setari implicite ale site-ului
-- -----------------------------------------------------------------------------
INSERT INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `setting_group`, `description`) VALUES
-- General
('site_name', 'Scanbox.ro', 'text', 'general', 'Numele site-ului'),
('site_url', 'https://scanbox.ro', 'text', 'general', 'URL-ul site-ului'),
('site_description', 'Servicii profesionale de tur virtual 3D, fotografie, videografie drone si randare 3D', 'textarea', 'general', 'Descrierea site-ului pentru SEO'),
('site_logo', NULL, 'image', 'general', 'Logo-ul site-ului'),
('site_favicon', NULL, 'image', 'general', 'Favicon-ul site-ului'),

-- Contact
('contact_email', 'office@scanbox.ro', 'text', 'contact', 'Adresa de email pentru contact'),
('contact_phone', '0740 233 353', 'text', 'contact', 'Numar de telefon principal'),
('contact_phone_secondary', NULL, 'text', 'contact', 'Numar de telefon secundar'),
('contact_address', 'Str. Moroeni 60D, Sector 2, București', 'textarea', 'contact', 'Adresa fizica'),
('contact_city', 'București', 'text', 'contact', 'Orasul sediului'),
('contact_working_hours', 'Luni - Vineri, 09:00 - 18:00', 'text', 'contact', 'Program de lucru'),
('contact_map_lat', '44.4268', 'text', 'contact', 'Latitudine GPS pentru harta'),
('contact_map_lng', '26.1025', 'text', 'contact', 'Longitudine GPS pentru harta'),

-- Social media
('social_facebook', 'https://www.facebook.com/scanbox.ro', 'text', 'social', 'URL pagina Facebook'),
('social_instagram', 'https://www.instagram.com/scanbox.ro/', 'text', 'social', 'URL profil Instagram'),
('social_youtube', 'https://www.youtube.com/@scanboxintegratedvisualsol9014', 'text', 'social', 'URL canal YouTube'),
('social_linkedin', 'https://www.linkedin.com/company/scanbox-visual-solutions/', 'text', 'social', 'URL profil LinkedIn'),
('social_tiktok', 'https://www.tiktok.com/@scanbox.ro', 'text', 'social', 'URL profil TikTok'),

-- Analytics
('google_analytics_id', NULL, 'text', 'analytics', 'ID Google Analytics (GA4)'),
('google_tag_manager_id', NULL, 'text', 'analytics', 'ID Google Tag Manager'),

-- SEO
('seo_default_title', 'Scanbox.ro - Tur Virtual 3D, Fotografie, Videografie Drone', 'text', 'seo', 'Titlu SEO implicit'),
('seo_default_description', 'Servicii profesionale de tur virtual 3D Matterport, fotografie imobiliara, videografie drone si randare 3D in Romania.', 'textarea', 'seo', 'Descriere SEO implicita'),
('seo_og_image', NULL, 'image', 'seo', 'Imagine Open Graph implicita'),

-- Homepage
('homepage_hero_title', 'Prezentam proprietati in cea mai buna lumina', 'text', 'homepage', 'Titlu hero pe homepage'),
('homepage_hero_subtitle', 'Tur Virtual 3D | Fotografie | Videografie Drone | Randare 3D', 'text', 'homepage', 'Subtitlu hero pe homepage'),
('homepage_hero_video', NULL, 'text', 'homepage', 'URL video hero pe homepage'),
('homepage_stats_projects', '150+', 'text', 'homepage', 'Numar proiecte finalizate (afisat pe homepage)'),
('homepage_stats_clients', '80+', 'text', 'homepage', 'Numar clienti multumiti (afisat pe homepage)'),
('homepage_stats_cities', '15+', 'text', 'homepage', 'Numar orase acoperite (afisat pe homepage)'),

-- Statistici (contoare homepage)
('stats_projects_count', '500', 'number', 'stats', 'Numar total proiecte finalizate'),
('stats_clients_count', '150', 'number', 'stats', 'Numar clienti multumiti'),
('stats_years_experience', '7', 'number', 'stats', 'Ani de experienta'),
('stats_satisfaction_rate', '98', 'number', 'stats', 'Rata de satisfactie (procent)'),
('stats_tours_count', '150', 'number', 'stats', 'Tururi virtuale realizate'),

-- Configurare
('maintenance_mode', '0', 'boolean', 'config', 'Modul de intretinere activ'),
('items_per_page', '12', 'number', 'config', 'Numar de elemente pe pagina'),
('blog_posts_per_page', '9', 'number', 'config', 'Numar de articole blog pe pagina');

-- -----------------------------------------------------------------------------
-- Galerii implicite
-- -----------------------------------------------------------------------------
INSERT INTO `galleries` (`name`, `slug`, `page`, `description`, `sort_order`, `is_active`) VALUES
('Galerie Homepage', 'galerie-homepage', 'home', 'Galeria principala afisata pe pagina de start', 1, 1),
('Galerie Fotografie', 'galerie-fotografie', 'fotografie', 'Galeria serviciului de fotografie', 2, 1),
('Galerie Videografie', 'galerie-videografie', 'videografie-drone', 'Galeria serviciului de videografie si drone', 3, 1),
('Galerie Randari 3D', 'galerie-randari', 'randare-3d', 'Galeria serviciului de randare 3D', 4, 1),
('Galerie Social Media', 'galerie-social-media', 'social-media', 'Galeria serviciului de social media content', 5, 1);

-- -----------------------------------------------------------------------------
-- Pachete de pret implicite - Tur Virtual 3D
-- -----------------------------------------------------------------------------
INSERT INTO `pricing_packages` (`service_page`, `name`, `price`, `currency`, `price_note`, `features_json`, `is_featured`, `is_active`, `sort_order`) VALUES
('tur-virtual-3d', 'Apartament', 150.00, 'EUR', 'de la', '["Scanare Matterport 3D","Tur virtual interactiv","Link partajabil","Livrare 48h","Pana la 100mp"]', 0, 1, 1),
('tur-virtual-3d', 'Vila / Casa', 300.00, 'EUR', 'de la', '["Scanare Matterport 3D","Tur virtual interactiv","Link partajabil","Planimetrie 2D","Livrare 48h","100-300mp"]', 1, 1, 2),
('tur-virtual-3d', 'Comercial', 500.00, 'EUR', 'de la', '["Scanare Matterport 3D","Tur virtual interactiv","Link partajabil","Planimetrie 2D","Masuratori precise","Livrare 48h","300mp+"]', 0, 1, 3);

-- -----------------------------------------------------------------------------
-- Pachete de pret implicite - Fotografie
-- -----------------------------------------------------------------------------
INSERT INTO `pricing_packages` (`service_page`, `name`, `price`, `currency`, `price_note`, `features_json`, `is_featured`, `is_active`, `sort_order`) VALUES
('fotografie', 'Basic', 100.00, 'EUR', 'de la', '["15 fotografii profesionale","Editare si retusare","Livrare 48h","Pana la 80mp"]', 0, 1, 1),
('fotografie', 'Standard', 200.00, 'EUR', 'de la', '["30 fotografii profesionale","Editare si retusare HDR","Fotografii aeriene","Livrare 48h","80-200mp"]', 1, 1, 2),
('fotografie', 'Premium', 350.00, 'EUR', 'de la', '["50+ fotografii profesionale","Editare premium HDR","Fotografii aeriene","Twilight photography","Livrare 24h","200mp+"]', 0, 1, 3);

-- -----------------------------------------------------------------------------
-- Pachete de pret implicite - Videografie Drone
-- -----------------------------------------------------------------------------
INSERT INTO `pricing_packages` (`service_page`, `name`, `price`, `currency`, `price_note`, `features_json`, `is_featured`, `is_active`, `sort_order`) VALUES
('videografie-drone', 'Clip Scurt', 200.00, 'EUR', 'de la', '["Video 30-60 secunde","Filmare 4K","Filmare drona","Muzica licentiata","Editare profesionala"]', 0, 1, 1),
('videografie-drone', 'Prezentare', 400.00, 'EUR', 'de la', '["Video 1-2 minute","Filmare 4K","Filmare drona","Muzica licentiata","Editare profesionala","Color grading"]', 1, 1, 2),
('videografie-drone', 'Cinematic', 700.00, 'EUR', 'de la', '["Video 2-3 minute","Filmare 4K/6K","Filmare drona avansata","Muzica licentiata","Editare cinematica","Color grading avansat","2 revisii"]', 0, 1, 3);
