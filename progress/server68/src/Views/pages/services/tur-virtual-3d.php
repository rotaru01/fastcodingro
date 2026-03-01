<?php
/**
 * Pagina Tur Virtual 3D Matterport
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = 'Tur virtual 3D Matterport profesional pentru imobiliare, hoteluri, restaurante, showroom-uri și spații comerciale. Reseller oficial Matterport România.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Reseller Oficial Matterport România';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><path d="M8 21h8"/><path d="M12 17v4"/></svg>';
$heroTitle = 'Tur Virtual 3D Matterport';
$heroSubtitle = 'Transformăm orice spațiu fizic într-o experiență digitală imersivă la 360° — scanare profesională cu echipament Matterport Pro 2 și Pro 3, livrare în 48h.';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== GEO: Citation Block ===== -->
<section class="content-section" lang="ro" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 100%);">
  <div class="container">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 24px 0;">
      Scanbox.ro realizează tururi virtuale 3D Matterport profesionale în București, România și Republica Moldova. Ca singurul Reseller Oficial Matterport din România, folosim camere Pro 2 și Pro 3 pentru a crea digital twins navigabili la 360°. Prețuri de la 150 euro+TVA pentru apartamente, 300 euro+TVA pentru vile și 500 euro+TVA pentru spații comerciale, cu livrare în 48 de ore. Peste 150 tururi virtuale finalizate.
    </p>
    <div class="section-header">
      <span class="section-tag">Scanare 3D Profesională</span>
      <h2 class="section-title">Tehnologie Matterport de ultimă generație</h2>
    </div>
    <div style="max-width: 820px; margin: 0 auto; text-align: center;">
      <p style="font-size: 17px; color: #94A3B8; line-height: 1.8; margin-bottom: 24px;">
        Un tur virtual 3D Matterport permite vizitatorilor să exploreze un spațiu fizic de pe orice dispozitiv, ca și cum ar fi acolo. Folosim cele mai avansate camere de scanare 3D — Matterport Pro 2 și Pro 3 — pentru a captura fiecare detaliu cu precizie de ±20mm.
      </p>
      <p style="font-size: 17px; color: #E2E8F0; line-height: 1.8; font-weight: 500;">
        Rezultatul? Un „digital twin" complet al spațiului tău — navigabil, partajabil și integrabil pe orice website.
      </p>
    </div>
    <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-top: 48px;">
      <div class="stat-item">
        <div class="stat-number">150+</div>
        <div class="stat-label">Tururi Virtuale</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">500+</div>
        <div class="stat-label">Proiecte Finalizate</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">48h</div>
        <div class="stat-label">Livrare Standard</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">±20mm</div>
        <div class="stat-label">Precizie Scanare</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== MATTERPORT DEMO EMBED ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #1d3155 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Demo Interactiv</span>
      <h2 class="section-title">Explorează un tur virtual Matterport</h2>
      <p class="section-subtitle">Navighează prin spațiu la 360°, explorează Dollhouse View și Floor Plan — direct din browser.</p>
    </div>
    <div style="position: relative; width: 100%; padding-bottom: 56.25%; border-radius: 20px; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
      <iframe
        src="https://my.matterport.com/show/?m=SxQL3iGyoDo&play=1"
        title="Tur Virtual 3D Matterport — Demo Scanbox.ro"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
        allow="fullscreen; vr"
        allowfullscreen>
      </iframe>
    </div>
    <p style="text-align: center; margin-top: 16px; font-size: 14px; color: #64748B;">Folosește mouse-ul sau touchscreen-ul pentru a naviga. Apasă pe cercurile de pe podea pentru a te deplasa.</p>
  </div>
</section>

<!-- ===== ECHIPAMENT ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1d3155 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="content-grid">
      <div class="content-text">
        <h3>Echipament Profesional</h3>
        <h2>Camere Matterport Pro 2 & Pro 3</h2>
        <p>
          Ca Reseller Oficial Matterport pentru România și Republica Moldova, avem acces direct la cele mai recente modele de camere și actualizări software. Camera Pro 3 oferă rezoluție superioară, viteză de scanare dublă față de Pro 2 și cea mai bună precizie din industrie.
        </p>
        <ul>
          <li>Matterport Pro 2 — standard de industrie, 134 megapixeli per scanare</li>
          <li>Matterport Pro 3 — ultimul model, 2x mai rapid, rezoluție 4K+</li>
          <li>Precizie de ±20mm — ideală pentru măsurători tehnice</li>
          <li>Compatibil cu toate platformele Matterport Cloud</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual" style="flex-direction: column; gap: 0;">
        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px;">
          <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.4; margin-bottom: 20px;">
            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><path d="M8 21h8"/><path d="M12 17v4"/><circle cx="12" cy="10" r="3"/>
          </svg>
          <p style="font-size: 16px; color: #94A3B8; text-align: center; line-height: 1.6;">Scanare 3D profesională cu camere Matterport Pro 2 și Pro 3 — cele mai avansate din industrie.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== LIVRABILE ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #1d3155 100%);">
  <div class="container">
    <div class="content-grid reversed">
      <div class="content-text">
        <h3>Ce primești</h3>
        <h2>Livrabile incluse în fiecare proiect</h2>
        <p>
          Fiecare tur virtual Matterport vine cu un pachet complet de livrabile digitale care te ajută să promovezi spațiul pe toate canalele — de la website la social media.
        </p>
        <ul>
          <li>Tur virtual 3D interactiv — navigabil din browser</li>
          <li>Link partajabil pe WhatsApp, social media, e-mail</li>
          <li>Cod embed (iframe) pentru integrare pe website</li>
          <li>Fotografii HDR 4K extrase automat din scanare</li>
          <li>Planimetrie 2D (floor plan) — disponibilă la cerere</li>
          <li>Dollhouse View — vizualizare 3D a întregului spațiu</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual" style="flex-direction: column; gap: 0;">
        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px;">
          <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.4; margin-bottom: 20px;">
            <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
          </svg>
          <p style="font-size: 16px; color: #94A3B8; text-align: center; line-height: 1.6;">Tur virtual 3D complet — navigare 360°, Dollhouse View, Floor Plan și fotografii HDR 4K incluse.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== DOMENII DE UTILIZARE ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1d3155 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">8 Industrii</span>
      <h2 class="section-title">Pentru cine sunt tururile virtuale 3D?</h2>
      <p class="section-subtitle">Tururile virtuale Matterport sunt utilizate cu succes în 8 domenii principale — de la imobiliare la muzee.</p>
    </div>
    <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px;">
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        </div>
        <h3 class="service-title">Imobiliare</h3>
        <p class="service-desc">Apartamente, case, vile — proprietățile cu tur virtual primesc 2x mai multe vizualizări online.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5h4v5m-4 0h4"/></svg>
        </div>
        <h3 class="service-title">Hoteluri & Hospitality</h3>
        <p class="service-desc">Camere, lobby, facilități — oaspeții pot „vizita" hotelul înainte de rezervare.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 010 8h-1"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
        </div>
        <h3 class="service-title">Restaurante & Cafenele</h3>
        <p class="service-desc">Atmosferă, design interior, terase — clienții văd ambianța înainte de a face o rezervare.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="2" ry="2"/><path d="M16 8h2a2 2 0 012 2v7a2 2 0 01-2 2H8a2 2 0 01-2-2v-2"/></svg>
        </div>
        <h3 class="service-title">Showroom-uri & Retail</h3>
        <p class="service-desc">Showroom-uri auto, magazine, spații de expunere — experiența de showroom, fără deplasare.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/></svg>
        </div>
        <h3 class="service-title">Muzee & Galerii</h3>
        <p class="service-desc">Expoziții permanente, galerii de artă — accesibilitate globală prin tururi virtuale.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
        </div>
        <h3 class="service-title">Birouri & Coworking</h3>
        <p class="service-desc">Spații de lucru, săli de ședință — prezentare virtuală pentru chiriași și angajați.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20h20"/><path d="M5 20V8l7-5 7 5v12"/><path d="M9 20v-4h6v4"/></svg>
        </div>
        <h3 class="service-title">Construcții & Dezvoltări</h3>
        <p class="service-desc">Monitorizare progres construcție, documentare șantier, prezentare pre-vânzare.</p>
      </div>
      <div class="service-card">
        <div class="service-icon">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
        </div>
        <h3 class="service-title">Arhitectură & Design</h3>
        <p class="service-desc">As-built documentation, scanare pentru renovări, comparații before/after.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== PROCESUL DE LUCRU ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #152540 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Proces simplu</span>
      <h2 class="section-title">Cum funcționează?</h2>
      <p class="section-subtitle">De la primul contact până la turul virtual finalizat — 4 pași simpli.</p>
    </div>
    <div class="services-grid" style="grid-template-columns: repeat(4, 1fr); gap: 24px;">
      <div class="service-card" style="text-align: center; position: relative;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(4,180,148,0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 20px; font-weight: 700; color: #04B494;">1</div>
        <h3 class="service-title">Contactează-ne</h3>
        <p class="service-desc">Descrie-ne spațiul și cerințele tale. Pregătim o ofertă personalizată în 24h.</p>
      </div>
      <div class="service-card" style="text-align: center;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(4,180,148,0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 20px; font-weight: 700; color: #04B494;">2</div>
        <h3 class="service-title">Scanare la fața locului</h3>
        <p class="service-desc">Echipa noastră vine cu echipamentul Matterport. Scanarea durează 1-3 ore.</p>
      </div>
      <div class="service-card" style="text-align: center;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(4,180,148,0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 20px; font-weight: 700; color: #04B494;">3</div>
        <h3 class="service-title">Procesare Cloud</h3>
        <p class="service-desc">Datele sunt procesate în cloud-ul Matterport și transformate în model 3D navigabil.</p>
      </div>
      <div class="service-card" style="text-align: center;">
        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(4,180,148,0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 20px; font-weight: 700; color: #04B494;">4</div>
        <h3 class="service-title">Livrare în 48h</h3>
        <p class="service-desc">Primești turul virtual, link partajabil, cod embed și fotografii HDR 4K.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== PREȚURI ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Prețuri transparente</span>
      <h2 class="section-title">Pachete Tur Virtual 3D Matterport</h2>
      <p class="section-subtitle">Toate pachetele includ: scanare completă, procesare cloud, tur virtual interactiv, link partajabil și livrare în 48h.</p>
    </div>
    <div class="services-grid" style="grid-template-columns: repeat(3, 1fr); gap: 32px;">
      <!-- Pachet 1 -->
      <div class="service-card" style="text-align: center; padding: 40px 32px;">
        <h3 style="font-size: 14px; font-weight: 600; color: #04B494; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Apartament</h3>
        <div style="font-size: 48px; font-weight: 800; color: #fff; margin-bottom: 4px;">150<span style="font-size: 20px; font-weight: 400; color: #94A3B8;">€</span></div>
        <p style="color: #64748B; font-size: 14px; margin-bottom: 24px;">+TVA · până la 100mp</p>
        <ul style="text-align: left; list-style: none; padding: 0; margin-bottom: 32px;">
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Tur virtual 3D complet</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Link partajabil</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Cod embed pentru website</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Fotografii HDR 4K</li>
          <li style="padding: 8px 0; color: #CBD5E1; font-size: 14px;">✓ Livrare în 48h</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm" style="width: 100%; justify-content: center;">Solicită Ofertă</a>
      </div>
      <!-- Pachet 2 -->
      <div class="service-card" style="text-align: center; padding: 40px 32px; border-color: rgba(4,180,148,0.3);">
        <div style="position: absolute; top: -1px; left: 50%; transform: translateX(-50%); background: #04B494; color: #0D1B2A; font-size: 12px; font-weight: 700; padding: 4px 16px; border-radius: 0 0 8px 8px; text-transform: uppercase; letter-spacing: 0.5px;">Popular</div>
        <h3 style="font-size: 14px; font-weight: 600; color: #04B494; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Vilă / Casă</h3>
        <div style="font-size: 48px; font-weight: 800; color: #fff; margin-bottom: 4px;">300<span style="font-size: 20px; font-weight: 400; color: #94A3B8;">€</span></div>
        <p style="color: #64748B; font-size: 14px; margin-bottom: 24px;">+TVA · 100-300mp</p>
        <ul style="text-align: left; list-style: none; padding: 0; margin-bottom: 32px;">
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Totul din pachetul Apartament</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Scanare multi-etaj</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Dollhouse View 3D</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Floor Plan 2D</li>
          <li style="padding: 8px 0; color: #CBD5E1; font-size: 14px;">✓ Livrare în 48h</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm" style="width: 100%; justify-content: center;">Solicită Ofertă</a>
      </div>
      <!-- Pachet 3 -->
      <div class="service-card" style="text-align: center; padding: 40px 32px;">
        <h3 style="font-size: 14px; font-weight: 600; color: #04B494; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Spațiu Comercial</h3>
        <div style="font-size: 48px; font-weight: 800; color: #fff; margin-bottom: 4px;">500<span style="font-size: 20px; font-weight: 400; color: #94A3B8;">€</span></div>
        <p style="color: #64748B; font-size: 14px; margin-bottom: 24px;">+TVA · peste 300mp</p>
        <ul style="text-align: left; list-style: none; padding: 0; margin-bottom: 32px;">
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Totul din pachetul Vilă</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Mattertags personalizate</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Măsurători integrale</li>
          <li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.06); color: #CBD5E1; font-size: 14px;">✓ Branding personalizat</li>
          <li style="padding: 8px 0; color: #CBD5E1; font-size: 14px;">✓ Livrare prioritară</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm" style="width: 100%; justify-content: center;">Solicită Ofertă</a>
      </div>
    </div>
  </div>
</section>

<!-- ===== FAQ SECTION — GEO Optimized ===== -->
<section class="content-section" itemscope itemtype="https://schema.org/FAQPage" style="background: linear-gradient(180deg, #1A2B4A 0%, #152540 100%);">
  <div class="container" style="max-width: 900px;">
    <div class="section-header">
      <span class="section-tag">FAQ</span>
      <h2 class="section-title">Întrebări Frecvente despre Tur Virtual 3D</h2>
      <p class="section-subtitle">Răspunsuri la cele mai comune întrebări despre serviciile noastre de tur virtual Matterport.</p>
    </div>

    <div class="faq-list">
      <!-- FAQ 1 -->
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Ce este un tur virtual 3D Matterport?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Un tur virtual 3D Matterport este o experiență digitală imersivă care permite vizitatorilor să exploreze un spațiu fizic la 360° dintr-un browser web, fără a instala software. Folosind camere specializate Matterport Pro 2 și Pro 3, spațiul este scanat și transformat într-un model 3D navigabil — un „digital twin" al locației reale. Scanbox.ro este Reseller Oficial Matterport pentru România și Republica Moldova.
          </div>
        </div>
      </div>

      <!-- FAQ 2 -->
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Cât costă un tur virtual 3D Matterport?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Prețurile pentru un tur virtual 3D Matterport la Scanbox.ro încep de la 150&euro;+TVA pentru un apartament de până la 100mp. O vilă sau casă (100-300mp) costă de la 300&euro;+TVA, iar spațiile comerciale (peste 300mp) de la 500&euro;+TVA. Prețul include scanarea completă, procesarea în cloud, turul virtual interactiv, link partajabil și livrarea în 48 de ore.
          </div>
        </div>
      </div>

      <!-- FAQ 3 -->
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Cât durează realizarea unui tur virtual Matterport?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Procesul de scanare durează între 1-3 ore, în funcție de dimensiunea spațiului. Procesarea în cloud Matterport și livrarea finală se realizează în 48 de ore. Pentru spații foarte mari (peste 500mp) sau proiecte complexe cu mai multe etaje, timpul poate fi ușor mai lung. Scanbox oferă și opțiuni de livrare expresă la cerere.
          </div>
        </div>
      </div>

      <!-- FAQ 4 -->
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Ce echipament folosește Scanbox pentru tururi virtuale?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Scanbox folosește exclusiv camere Matterport Pro 2 și Matterport Pro 3 — cele mai avansate echipamente de scanare 3D de pe piață. Camera Pro 3 oferă rezoluție superioară, viteză de scanare dublă față de Pro 2 și precizie de ±20mm. Ca Reseller Oficial Matterport, avem acces la cele mai recente modele și actualizări software.
          </div>
        </div>
      </div>

      <!-- FAQ 5 -->
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Pentru ce tipuri de spații este util un tur virtual 3D?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Tururile virtuale 3D Matterport sunt utilizate în 8 domenii principale: imobiliare (apartamente, case, vile), hoteluri și hospitality, restaurante și cafenele, showroom-uri auto și retail, muzee și galerii de artă, spații comerciale și birouri, construcții și dezvoltări imobiliare, arhitectură și design interior. Proprietățile cu tur virtual primesc de 2x mai multe vizualizări online.
          </div>
        </div>
      </div>

      <!-- FAQ 6 -->
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Cum pot integra un tur virtual pe site-ul meu?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Turul virtual Matterport poate fi integrat pe orice site web prin cod embed (iframe) furnizat de Scanbox. Funcționează pe desktop, tabletă și telefon fără instalare de software. De asemenea, primești un link direct partajabil pe social media, WhatsApp sau e-mail. Turul include și fotografii HDR 4K extrase automat și planimetrie 2D.
          </div>
        </div>
      </div>

      <!-- FAQ 7 -->
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Scanbox oferă servicii de tur virtual în afara Bucureștiului?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Da, Scanbox oferă servicii de scanare 3D și tur virtual Matterport în toată România și Republica Moldova. Avem experiență cu proiecte în București, Brașov, Cluj-Napoca, Timișoara, Constanța, Sinaia și alte orașe. Pentru deplasări în afara Bucureștiului se adaugă costuri de transport calculate în funcție de distanță.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CTA BANNER ===== -->
<section class="content-section" style="background: linear-gradient(135deg, #04B494 0%, #039B7E 100%); padding: 80px 0;">
  <div class="container" style="text-align: center;">
    <h2 style="font-size: 32px; font-weight: 800; color: #fff; margin-bottom: 16px;">Pregătit să-ți digitalizezi spațiul?</h2>
    <p style="font-size: 18px; color: rgba(255,255,255,0.85); margin-bottom: 32px; max-width: 600px; margin-left: auto; margin-right: auto;">
      Contactează-ne pentru o ofertă personalizată. Scanarea durează 1-3 ore, iar turul virtual este gata în 48h.
    </p>
    <a href="/contact" class="btn-primary" style="background: #0D1B2A; color: #fff; padding: 16px 40px; font-size: 16px;">
      Solicită Ofertă Gratuită
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>
  </div>
</section>
