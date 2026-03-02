-- =============================================================================
-- Seed: Proiecte portofoliu Scanbox.ro
-- Ruleaza in phpMyAdmin pentru a popula portofoliul cu date initiale
-- =============================================================================

INSERT INTO `portfolio_projects` (`slug`, `title`, `category_id`, `city`, `address`, `lat`, `lng`, `matterport_url`, `thumbnail`, `description`, `completion_date`, `is_featured`, `is_active`, `sort_order`) VALUES

-- Tur Virtual 3D (category_id = 1)
('apartament-luxury-herastrau', 'Apartament Luxury - Herăstrău', 1, 'București', 'Bd. Nordului, Sector 1', 44.4850, 26.0780, 'https://my.matterport.com/show/?m=xHGo1iZ1VLC', NULL, 'Tur virtual 3D Matterport pentru un apartament de lux cu 4 camere în zona Herăstrău. Scanare completă cu tehnologie Matterport Pro2, incluzând toate camerele, terasele și spațiile comune.', '2025-06-15', 1, 1, 1),

('hotel-boutique-brasov', 'Hotel Boutique - Brașov', 1, 'Brașov', 'Str. Republicii 15', 45.6427, 25.5887, 'https://my.matterport.com/show/?m=JHRbJYEuqpw', NULL, 'Tur virtual complet pentru un hotel boutique din centrul istoric al Brașovului. 12 camere scanate, lobby, restaurant și zona spa.', '2025-05-20', 1, 1, 2),

('showroom-auto-pipera', 'Showroom Auto - Pipera', 1, 'București', 'Bd. Pipera 200', 44.4900, 26.1100, 'https://my.matterport.com/show/?m=oFEwKWR6yPk', NULL, 'Digitalizare completă a unui showroom auto premium. Tur virtual interactiv cu hotspot-uri informative pe fiecare vehicul expus.', '2025-04-10', 0, 1, 3),

('vila-snagov', 'Vilă Exclusivistă - Snagov', 1, 'Snagov', 'Str. Lacului 25', 44.6900, 26.1500, 'https://my.matterport.com/show/?m=SxQL3iGyvPk', NULL, 'Tur virtual pentru o vilă de lux cu acces la lac. 350mp, 6 camere, piscină, grădină și ponton privat.', '2025-07-01', 1, 1, 4),

-- Fotografie (category_id = 2)
('fotografie-restaurant-centru', 'Restaurant Fine Dining - Centru Vechi', 2, 'București', 'Str. Stavropoleos 5', 44.4315, 26.1010, 'https://my.matterport.com/show/?m=Zh14WDtkjdB', NULL, 'Sesiune foto profesională de interior și food photography pentru un restaurant din centrul istoric. Fotografie HDR, imagini culinare și atmosferă.', '2025-03-15', 0, 1, 5),

('fotografie-birouri-it', 'Birouri Corporate IT', 2, 'Cluj-Napoca', 'Str. Memorandumului 10', 46.7712, 23.6236, 'https://my.matterport.com/show/?m=wEBm99MGs1Q', NULL, 'Fotografie corporate pentru sediul unei companii IT. Portrete echipă, spații de lucru, săli de conferință și zone de relaxare.', '2025-05-01', 1, 1, 6),

('fotografie-imobiliara-penthouse', 'Penthouse Aviatorilor', 2, 'București', 'Bd. Aviatorilor 45', 44.4600, 26.0850, 'https://my.matterport.com/show/?m=2DRg9qGbQ7G', NULL, 'Fotografie imobiliară HDR pentru un penthouse premium. Imagini de interior, exterior, twilight și aeriene cu drona.', '2025-06-20', 0, 1, 7),

-- Videografie (category_id = 3)
('video-dezvoltare-imobiliara-baneasa', 'Dezvoltare Imobiliară - Băneasa', 3, 'București', 'Șos. Băneasa 50', 44.5000, 26.0700, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 'Videografie cu drona 4K pentru un ansamblu rezidențial nou. Filmare aeriană, imagini interioare model și video de prezentare completă.', '2025-04-20', 1, 1, 8),

('video-eveniment-corporate', 'Eveniment Corporate - Gala Premiilor', 3, 'București', 'Palatul Parlamentului', 44.4275, 26.0870, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 'Filmare profesională multi-cameră pentru un eveniment corporate cu 500 de invitați. Highlights, interviuri și after-movie.', '2025-02-15', 0, 1, 9),

('video-turism-sibiu', 'Promovare Turistică - Sibiu', 3, 'Sibiu', 'Piața Mare', 45.7983, 24.1256, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', NULL, 'Video de promovare turistică pentru orașul Sibiu. Filmare cu drona, time-lapse și cinematografie urbană pentru campanie de marketing.', '2025-05-10', 0, 1, 10),

-- Randare 3D (category_id = 4)
('randare-ansamblu-rezidential', 'Ansamblu Rezidențial Green Park', 4, 'Iași', 'Bd. Tudor Vladimirescu', 47.1585, 27.6014, 'https://my.matterport.com/show/?m=h5KD4gAxEjj', NULL, 'Randări 3D fotorealistice pentru un ansamblu rezidențial cu 120 de apartamente. Vizualizări exterioare de zi și noapte, amenajare peisagistică și interioare model.', '2025-01-20', 1, 1, 11),

('randare-interior-showroom', 'Design Interior - Showroom Mobilă', 4, 'Timișoara', 'Str. Iosif Bulbuca 10', 45.7489, 21.2087, 'https://my.matterport.com/show/?m=JHRbJYEuqpw', NULL, 'Randare 3D fotorealistică pentru un showroom de mobilă premium. 5 scene de interior cu materiale și texturi personalizate.', '2025-03-01', 0, 1, 12),

-- Social Media (category_id = 5)
('social-media-hotel-mamaia', 'Campanie Social Media - Hotel Mamaia', 5, 'Constanța', 'Bd. Mamaia 300', 44.2500, 28.6400, 'https://www.instagram.com/scanbox.ro/', NULL, 'Pachet complet de content pentru social media: 20 Reels, 30 Stories, sesiune foto lifestyle și strategie de conținut pentru sezonul estival.', '2025-07-01', 0, 1, 13),

('social-media-restaurant-bucuresti', 'Content Vizual - Restaurant Fine Dining', 5, 'București', 'Str. Franceza 12', 44.4310, 26.1050, 'https://www.instagram.com/scanbox.ro/', NULL, 'Producție completă de conținut vizual: food photography, video Reels, behind the scenes și material pentru campanii de promovare.', '2025-04-15', 0, 1, 14);
