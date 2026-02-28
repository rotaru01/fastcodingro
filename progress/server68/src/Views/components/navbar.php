<?php
/**
 * Componenta Navbar
 *
 * Variabile disponibile:
 * @var string $activePage  - pagina activa curenta (ex: 'home', 'servicii', 'portofoliu', 'blog', 'contact')
 */
$activePage = $activePage ?? '';
$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
?>

<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar">
  <a href="/" class="navbar-logo">
    <div class="logo-icon">S</div>
    scanbox
  </a>
  <div class="navbar-links">
    <a href="/"<?= $currentUri === '/' ? ' class="active"' : '' ?>>Acasă</a>
    <div class="nav-dropdown">
      <a class="nav-dropdown-toggle<?= str_starts_with($currentUri, '/servicii') ? ' active' : '' ?>">
        Servicii
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
      </a>
      <div class="nav-dropdown-menu">
        <a href="/servicii/tur-virtual-3d">Tur Virtual 3D</a>
        <a href="/servicii/fotografie">Servicii Foto</a>
        <a href="/servicii/videografie-drone">Servicii Video</a>
        <a href="/sport-content">Sport Content</a>
        <a href="/servicii/social-media">Social Media</a>
        <a href="/servicii/randare-3d">Randare 3D</a>
      </div>
    </div>
    <a href="/portofoliu"<?= str_starts_with($currentUri, '/portofoliu') ? ' class="active"' : '' ?>>Portofoliu</a>
    <a href="/blog"<?= str_starts_with($currentUri, '/blog') ? ' class="active"' : '' ?>>Blog</a>
    <a href="/contact"<?= $currentUri === '/contact' ? ' class="active"' : '' ?>>Contact</a>
    <a href="/contact" class="navbar-cta">Cere Ofertă</a>
  </div>
  <button class="hamburger" id="hamburger" aria-label="Menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
  <a href="/">Acasă</a>
  <a href="/servicii/tur-virtual-3d">Tur Virtual 3D</a>
  <a href="/servicii/fotografie">Servicii Foto</a>
  <a href="/servicii/videografie-drone">Servicii Video</a>
  <a href="/sport-content">Sport Content</a>
  <a href="/servicii/social-media">Social Media</a>
  <a href="/servicii/randare-3d">Randare 3D</a>
  <a href="/portofoliu">Portofoliu</a>
  <a href="/blog">Blog</a>
  <a href="/contact">Contact</a>
  <a href="/contact" class="navbar-cta">Cere Ofertă</a>
</div>
