-- =============================================================================
-- Seed: Portofoliu Reels - Galerie Instagram Embeds
-- Ruleaza in phpMyAdmin pentru a adauga reels-urile in baza de date
-- =============================================================================

-- Galeria pentru pagina Portofoliu Reels
INSERT INTO `galleries` (`name`, `slug`, `page`, `description`, `sort_order`, `is_active`) VALUES
('Portofoliu Reels', 'portofoliu-reels', 'portofoliu-reels', 'Selecție din cele mai recente proiecte video în format scurt (Reels)', 6, 1);

-- Luam ID-ul galeriei tocmai inserate
SET @reels_gallery_id = LAST_INSERT_ID();

-- Reels-urile din pagina originala portofoliu-reels.html
INSERT INTO `gallery_items` (`gallery_id`, `type`, `file_path`, `thumbnail_path`, `external_url`, `title`, `alt_text`, `sort_order`, `is_active`) VALUES
(@reels_gallery_id, 'embed', NULL, NULL, 'https://www.instagram.com/reel/C1HAzZhIs_0/', 'Reel Scanbox #1', 'Reel video Scanbox.ro', 1, 1),
(@reels_gallery_id, 'embed', NULL, NULL, 'https://www.instagram.com/reel/C0gOfOgo1FM/', 'Reel Scanbox #2', 'Reel video Scanbox.ro', 2, 1),
(@reels_gallery_id, 'embed', NULL, NULL, 'https://www.instagram.com/reel/Cy5BL7Ux5ll/', 'Reel Scanbox #3', 'Reel video Scanbox.ro', 3, 1),
(@reels_gallery_id, 'embed', NULL, NULL, 'https://www.instagram.com/reel/DKwYH4ZsgCB/', 'Reel Scanbox #4', 'Reel video Scanbox.ro', 4, 1),
(@reels_gallery_id, 'embed', NULL, NULL, 'https://www.instagram.com/reel/DT4y8oeAhqR/', 'Reel Scanbox #5', 'Reel video Scanbox.ro', 5, 1),
(@reels_gallery_id, 'embed', NULL, NULL, 'https://www.instagram.com/reel/DUoBChhDIa0/', 'Reel Scanbox #6', 'Reel video Scanbox.ro', 6, 1);
