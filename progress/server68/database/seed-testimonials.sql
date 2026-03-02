-- =============================================================================
-- Seed: Testimoniale initiale
-- Ruleaza in phpMyAdmin o singura data
-- =============================================================================

INSERT INTO `testimonials` (`author_name`, `author_role`, `author_company`, `quote`, `rating`, `is_active`, `sort_order`) VALUES
('Ana Maria Cioclei', 'Director Marketing', 'Park 20 by Cordia',
 'Colaborarea cu Scanbox a fost impecabilă. Turul virtual 3D realizat pentru proiectul nostru rezidențial a crescut semnificativ rata de conversie a vizitelor online în vizionări reale. Recomand cu încredere!',
 5, 1, 1),
('Mihai Popescu', 'Manager Evenimente Sportive', NULL,
 'Echipa Scanbox a livrat un conținut video excepțional pentru evenimentele noastre sportive. Profesionalismul și atenția la detalii ne-au impresionat de fiecare dată. Partenerul ideal pentru sport content!',
 5, 1, 2),
('Elena Dumitrescu', 'CEO', 'Boutique Hotel București',
 'De când colaborăm cu Scanbox pentru social media, engagement-ul pe paginile noastre a crescut cu peste 200%. Strategia lor e bine gândită și conținutul vizual e mereu de calitate superioară.',
 5, 1, 3);
