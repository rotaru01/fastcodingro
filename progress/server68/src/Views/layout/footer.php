<?php
// Setari cu fallback
$_s = $settings ?? [];
$_email = htmlspecialchars(setting($_s, 'contact_email', 'office@scanbox.ro'));
$_phone = htmlspecialchars(setting($_s, 'contact_phone', '0740 233 353'));
$_address = htmlspecialchars(setting($_s, 'contact_address', 'Str. Moroeni 60D, Sector 2, București'));
$_hours = htmlspecialchars(setting($_s, 'contact_working_hours', 'L-V 09:00 - 18:00'));
$_instagram = setting($_s, 'social_instagram', 'https://www.instagram.com/scanbox.ro/');
$_facebook = setting($_s, 'social_facebook', 'https://www.facebook.com/scanbox.ro');
$_tiktok = setting($_s, 'social_tiktok', 'https://www.tiktok.com/@scanbox.ro');
$_youtube = setting($_s, 'social_youtube', 'https://www.youtube.com/@scanboxintegratedvisualsol9014');
$_linkedin = setting($_s, 'social_linkedin', 'https://www.linkedin.com/company/scanbox-visual-solutions/');
?>
<!-- ===== FOOTER ===== -->
<footer class="footer" id="contact">
  <div class="container">
    <div class="footer-grid">

      <!-- Brand Column -->
      <div class="footer-brand">
        <a href="/" class="navbar-logo">
          <div class="logo-icon">S</div>
          scanbox
        </a>
        <p>Soluții vizuale profesionale care transformă modul în care clienții tăi experimentează spațiile și produsele tale. WE ARE YOUR CONTENT CREATORS.</p>
        <div class="footer-socials">
          <?php if ($_instagram): ?>
          <a href="<?= htmlspecialchars($_instagram) ?>" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($_facebook): ?>
          <a href="<?= htmlspecialchars($_facebook) ?>" target="_blank" rel="noopener" aria-label="Facebook">
            <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($_tiktok): ?>
          <a href="<?= htmlspecialchars($_tiktok) ?>" target="_blank" rel="noopener" aria-label="TikTok">
            <svg viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($_youtube): ?>
          <a href="<?= htmlspecialchars($_youtube) ?>" target="_blank" rel="noopener" aria-label="YouTube">
            <svg viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
          <?php endif; ?>
          <?php if ($_linkedin): ?>
          <a href="<?= htmlspecialchars($_linkedin) ?>" target="_blank" rel="noopener" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Servicii Column -->
      <div class="footer-col">
        <h4>Servicii</h4>
        <ul>
          <li><a href="/servicii/tur-virtual-3d">Tur Virtual 3D</a></li>
          <li><a href="/servicii/fotografie">Fotografie Profesională</a></li>
          <li><a href="/servicii/videografie-drone">Videografie & Drone</a></li>
          <li><a href="/servicii/randare-3d">Randare 3D</a></li>
          <li><a href="/servicii/social-media">Social Media</a></li>
        </ul>
      </div>

      <!-- Companie Column -->
      <div class="footer-col">
        <h4>Companie</h4>
        <ul>
          <li><a href="/despre-noi">Despre Noi</a></li>
          <li><a href="/portofoliu">Portofoliu</a></li>
          <li><a href="/blog">Blog</a></li>
          <li><a href="/contact">Contact</a></li>
          <li><a href="/legal/prelucrarea-datelor">Politica de Confidențialitate</a></li>
        </ul>
      </div>

      <!-- Contact Column -->
      <div class="footer-col">
        <h4>Contact</h4>
        <div class="footer-contact-item">
          <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6" fill="none" stroke="#04B494" stroke-width="2"/></svg>
          <span class="email-protect" data-u="office" data-d="scanbox.ro"></span>
        </div>
        <div class="footer-contact-item">
          <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
          <span><?= $_phone ?></span>
        </div>
        <div class="footer-contact-item">
          <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3" fill="none" stroke="#0D1B2A" stroke-width="2"/></svg>
          <span><?= $_address ?></span>
        </div>
        <div class="footer-contact-item">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14" fill="none" stroke="#0D1B2A" stroke-width="2"/></svg>
          <span><?= $_hours ?></span>
        </div>
      </div>

    </div>

    <div class="footer-bottom">
      <p>&copy; 2018-<?= date('Y') ?> Trivit Services SRL. Toate drepturile rezervate.</p>
      <div class="footer-bottom-links">
        <a href="/">Acasă</a>
        <a href="/contact">Contact</a>
        <a href="/legal/prelucrarea-datelor">Termeni și Condiții</a>
        <a href="/legal/politica-cookies">GDPR</a>
      </div>
    </div>
  </div>
</footer>
