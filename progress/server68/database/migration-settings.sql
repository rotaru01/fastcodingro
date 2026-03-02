-- =============================================================================
-- Migrare: Sincronizare setari admin cu frontend
-- Ruleaza in phpMyAdmin o singura data
-- =============================================================================

-- Actualizare setari existente cu valori reale
UPDATE `settings` SET `setting_value` = 'office@scanbox.ro' WHERE `setting_key` = 'contact_email';
UPDATE `settings` SET `setting_value` = '0740 233 353' WHERE `setting_key` = 'contact_phone';
UPDATE `settings` SET `setting_value` = 'Str. Moroeni 60D, Sector 2, București' WHERE `setting_key` = 'contact_address';
UPDATE `settings` SET `setting_value` = 'București' WHERE `setting_key` = 'contact_city';

UPDATE `settings` SET `setting_value` = 'https://www.instagram.com/scanbox.ro/' WHERE `setting_key` = 'social_instagram';
UPDATE `settings` SET `setting_value` = 'https://www.facebook.com/scanbox.ro' WHERE `setting_key` = 'social_facebook';
UPDATE `settings` SET `setting_value` = 'https://www.tiktok.com/@scanbox.ro' WHERE `setting_key` = 'social_tiktok';
UPDATE `settings` SET `setting_value` = 'https://www.youtube.com/@scanboxintegratedvisualsol9014' WHERE `setting_key` = 'social_youtube';
UPDATE `settings` SET `setting_value` = 'https://www.linkedin.com/company/scanbox-visual-solutions/' WHERE `setting_key` = 'social_linkedin';

-- Adaugare setari noi (IGNORE = nu da eroare daca exista deja)
INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`, `setting_type`, `setting_group`, `description`) VALUES
('contact_working_hours', 'Luni - Vineri, 09:00 - 18:00', 'text', 'contact', 'Program de lucru'),
('stats_tours_count', '150', 'number', 'stats', 'Tururi virtuale realizate'),
('stats_projects_count', '500', 'number', 'stats', 'Numar total proiecte finalizate'),
('stats_clients_count', '150', 'number', 'stats', 'Numar clienti multumiti'),
('stats_years_experience', '7', 'number', 'stats', 'Ani de experienta'),
('stats_satisfaction_rate', '98', 'number', 'stats', 'Rata de satisfactie (procent)');
