<?php
/**
 * Componenta Navbar - identica cu index.html original
 */
$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
?>

<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar">
  <a href="/" class="navbar-logo">
    <img src="/assets/images/logo-scanbox.png" alt="Scanbox.ro — Integrated Visual Solutions" class="logo-img" width="133" height="36">
  </a>
  <div class="navbar-links">
    <a href="/"<?= $currentUri === '/' ? ' class="active"' : '' ?>>Acasă</a>
    <div class="nav-dropdown">
      <a href="#servicii">
        Servicii
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
      </a>
      <div class="nav-dropdown-menu">
        <a href="/servicii/tur-virtual-3d">
          <svg viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
          Tur Virtual 3D
        </a>
        <a href="/servicii/fotografie">
          <svg viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          Servicii Foto
        </a>
        <a href="/servicii/videografie-drone">
          <svg viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
          Servicii Video
        </a>
        <a href="/sport-content">
          <svg viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
          Sport Content
        </a>
        <a href="/servicii/social-media">
          <svg viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
          Social Media
        </a>
        <a href="/servicii/randare-3d">
          <svg viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          Randare 3D
        </a>
      </div>
    </div>
    <a href="/portofoliu"<?= str_starts_with($currentUri, '/portofoliu') ? ' class="active"' : '' ?>>Portofoliu</a>
    <a href="/blog"<?= str_starts_with($currentUri, '/blog') ? ' class="active"' : '' ?>>Blog</a>
    <a href="#contact">Contact</a>
    <a href="#cta" class="navbar-cta">Cere Ofertă</a>
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
  <div class="mobile-dropdown-label" id="mobileDropdownToggle">
    Servicii
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
  </div>
  <div class="mobile-dropdown-items" id="mobileDropdownItems">
    <a href="/servicii/tur-virtual-3d">Tur Virtual 3D</a>
    <a href="/servicii/fotografie">Servicii Foto</a>
    <a href="/servicii/videografie-drone">Servicii Video</a>
    <a href="/sport-content">Sport Content</a>
    <a href="/servicii/social-media">Social Media</a>
    <a href="/servicii/randare-3d">Randare 3D</a>
  </div>
  <a href="/portofoliu">Portofoliu</a>
  <a href="/blog">Blog</a>
  <a href="#contact">Contact</a>
  <a href="#cta" class="navbar-cta">Cere Ofertă</a>
</div>
