<?php
/**
 * Pagina Servicii Foto B2B
 *
 * Variabile disponibile (din PageController::servicii):
 * @var string $title        - titlul paginii
 * @var array  $service      - datele serviciului din DB
 * @var array  $gallery      - galeria asociata
 * @var array  $galleryItems - elementele galeriei
 * @var array  $pricing      - pachetele de pret
 * @var array  $settings     - setarile site-ului
 */
$metaDescription = 'Scanbox.ro oferă servicii foto profesionale B2B în București: fotografie corporate, comercială, culinară și imobiliară HDR. Pachete de la 100 euro, livrare rapidă în 24-48h. Imagini care susțin brandul pe termen lung, realizate cu echipament profesional.';
?>

<?php
$heroType = 'page';
$heroBadge = 'Fotografie Profesională B2B';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>';
$heroTitle = 'Servicii Foto B2B';
$heroSubtitle = 'Fiecare fotografie realizată de noi devine un instrument puternic de comunicare vizuală.';
include __DIR__ . '/../../components/hero.php';
?>

<!-- ===== GENERAL INTRO ===== -->
<section class="content-section" lang="ro" style="background: linear-gradient(180deg, #152540 0%, #1A2B4A 100%);">
  <div class="container">
    <p style="border-left: 3px solid #04B494; padding-left: 16px; color: #CBD5E1; font-size: 15px; line-height: 1.8; margin: 24px 0;">
      Scanbox.ro oferă servicii foto profesionale B2B in București: fotografie corporate, comercială, culinară și imobiliară. Cu pachete de la 100 euro si livrare rapidă in 24-48h, echipa realizează imagini de calitate superioară care susțin brandul pe termen lung.
    </p>
    <div class="section-header">
      <span class="section-tag">De ce noi</span>
      <h2 class="section-title">Fotografie care vorbește pentru brandul tău</h2>
    </div>
    <div style="max-width: 820px; margin: 0 auto; text-align: center;">
      <p style="font-size: 17px; color: #94A3B8; line-height: 1.8; margin-bottom: 24px;">
        Fie că vorbești despre brand-ul tău, despre echipa din spatele afacerii sau despre produsele oferite, imaginile noastre vor fi remarcate de publicul tău țintă. Pentru noi, fiecare proiect este o colaborare benefică ambelor părți. Discutăm deschis despre buget, priorități și obiective, astfel încât să găsim formula potrivită pentru compania ta.
      </p>
      <p style="font-size: 17px; color: #E2E8F0; line-height: 1.8; font-weight: 500;">
        Nu promitem „cel mai mic preț". Promitem consistență, execuție impecabilă și imagini care susțin brandul pe termen lung.
      </p>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 1: Fotografie Corporate & Brand ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #1d3155 100%);">
  <div class="container">
    <div class="content-grid">
      <div class="content-text">
        <h3>Fotografie Corporate & Brand</h3>
        <h2>Profesionalism vizual la cel mai înalt nivel</h2>
        <p>
          Construim imagini care reflectă profesionalismul, cultura și identitatea companiei tale. De la portrete ale membrilor echipei și imagini cu sediul, la procese interne, detalii de brand sau lifestyle profesional — fiecare fotografie este gândită strategic.
        </p>
        <ul>
          <li>Portrete corporate pentru echipă și management</li>
          <li>Fotografie de brand și identitate vizuală</li>
          <li>Imagini cu sediul și spațiul de lucru</li>
          <li>Lifestyle profesional și behind the scenes</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <div class="gallery-grid" style="padding: 16px; gap: 12px;">
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Fotografie corporate</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Portret echipă</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Brand identity</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Lifestyle profesional</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 2: Fotografie Comercială & Industrială ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1d3155 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="content-grid reversed">
      <div class="content-text">
        <h3>Fotografie Comercială & Industrială</h3>
        <h2>Documentare vizuală pentru businessul tău</h2>
        <p>
          Documentăm vizual procesele, echipamentele și oamenii care susțin performanța businessului tău. Imortalizăm spații de producție, depozite, șantiere sau zone logistice — totul într-un mod profesional, sigur și organizat.
        </p>
        <ul>
          <li>Fotografie industrială și de producție</li>
          <li>Documentare vizuală a proceselor interne</li>
          <li>Imagini pentru rapoarte anuale și materiale corporative</li>
          <li>Fotografie de echipamente și infrastructură</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <div class="gallery-grid" style="padding: 16px; gap: 12px;">
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Spațiu de producție</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Echipamente industriale</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Logistică și depozit</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Procese interne</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 3: Fotografie Culinară & Produs ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #1d3155 100%);">
  <div class="container">
    <div class="content-grid">
      <div class="content-text">
        <h3>Fotografie Culinară & Produs</h3>
        <h2>Imagini care atrag, conving și diferențiază</h2>
        <p>
          Punem în valoare produsele tale prin imagini care atrag, conving și diferențiază. Realizăm fotografii de produs pentru e-commerce, cataloage și campanii vizuale — fiecare imagine fiind optimizată pentru impactul dorit.
        </p>
        <ul>
          <li>Food photography pentru restaurante și HoReCa</li>
          <li>Fotografie de produs pentru e-commerce</li>
          <li>Imagini pentru cataloage și materiale de marketing</li>
          <li>Stilizare și aranjare produse (styling)</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <div class="gallery-grid" style="padding: 16px; gap: 12px;">
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Food photography</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Fotografie de produs</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Catalog vizual</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Styling & aranjare</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORY 4: Fotografie Imobiliară și de Arhitectură ===== -->
<section class="content-section" style="background: linear-gradient(180deg, #1d3155 0%, #1A2B4A 100%);">
  <div class="container">
    <div class="content-grid reversed">
      <div class="content-text">
        <h3>Fotografie Imobiliară și de Arhitectură</h3>
        <h2>Imaginile potrivite fac orice spațiu memorabil</h2>
        <p>
          Imaginile potrivite fac orice spațiu să fie memorabil! Realizăm fotografie imobiliară pentru proprietăți rezidențiale, comerciale sau proiecte în dezvoltare — fiecare cadru fiind ales pentru a pune în evidență potențialul spațiului.
        </p>
        <ul>
          <li>Fotografie imobiliară rezidențială și comercială</li>
          <li>Fotografie de arhitectură și design interior</li>
          <li>Imagini pentru dezvoltatori și agenții imobiliare</li>
          <li>Fotografie de exterior și peisagistică</li>
        </ul>
        <a href="/contact" class="btn-primary btn-sm">
          Solicită ofertă
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="content-visual">
        <div class="gallery-grid" style="padding: 16px; gap: 12px;">
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Proprietate rezidențială</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Design interior</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Spațiu comercial</div>
          <div class="gallery-item" style="background: linear-gradient(135deg, #1A2B4A, #2D4A7A); display: flex; align-items: center; justify-content: center; font-size: 14px; color: #64748B;">Arhitectură exterioară</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== BENEFITS ===== -->
<section class="stats-section" style="background: linear-gradient(180deg, #1A2B4A 0%, #152540 100%);">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Beneficii</span>
      <h2 class="section-title">O sesiune foto profesională bine realizată</h2>
      <p class="section-subtitle">Investiția în imagini profesionale aduce rezultate măsurabile pentru afacerea ta.</p>
    </div>
    <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
      <div class="stat-item">
        <div style="font-size: 40px; margin-bottom: 16px;">
          <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
        </div>
        <div class="stat-label" style="font-size: 16px; color: #E2E8F0; font-weight: 600; margin-bottom: 8px;">Sporește credibilitatea brandului</div>
        <div class="stat-label">Imaginile profesionale transmit încredere și seriozitate partenerilor și clienților tăi.</div>
      </div>
      <div class="stat-item">
        <div style="font-size: 40px; margin-bottom: 16px;">
          <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
        </div>
        <div class="stat-label" style="font-size: 16px; color: #E2E8F0; font-weight: 600; margin-bottom: 8px;">Influențează decizia de cumpărare</div>
        <div class="stat-label">Fotografiile de calitate cresc rata de conversie și ajută clienții să ia decizii informate.</div>
      </div>
      <div class="stat-item">
        <div style="font-size: 40px; margin-bottom: 16px;">
          <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
        </div>
        <div class="stat-label" style="font-size: 16px; color: #E2E8F0; font-weight: 600; margin-bottom: 8px;">Poziționează compania superior</div>
        <div class="stat-label">Poziționează compania la un nivel superior în piață, diferențiind-o de concurență.</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CTA BANNER ===== -->
<section class="cta-section" style="background: linear-gradient(180deg, #152540 0%, #152540 100%);">
  <div class="container">
    <div class="cta-banner">
      <h2>Ai o idee de proiect vizual?</h2>
      <p>Contactează-ne și hai să discutăm cum putem transforma viziunea ta în imagini profesionale.</p>
      <a href="/contact" class="btn-white">
        Contactează-ne
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>
</section>

<!-- ===== FAQ ===== -->
<section class="content-section" lang="ro" style="background: linear-gradient(180deg, #152540 0%, #152540 100%); padding: 80px 0;">
  <div class="container" style="max-width: 800px;">
    <div class="section-header">
      <span class="section-tag">FAQ</span>
      <h2 class="section-title">Întrebări Frecvente</h2>
    </div>
    <div itemscope itemtype="https://schema.org/FAQPage">
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Ce tipuri de fotografie oferă Scanbox?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            4 categorii: corporate (evenimente, portrete business), comercială (produse, e-commerce), culinară (meniuri, food styling) și imobiliară (HDR, twilight, aeriene).
          </div>
        </div>
      </div>
      <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
        <button class="faq-toggle">
          <span itemprop="name">Cât costă o ședință foto?</span>
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </button>
        <div class="faq-answer" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
          <div itemprop="text" style="padding: 0 24px 20px; color: #94A3B8; font-size: 15px; line-height: 1.8;">
            Basic: 15 fotografii, de la 100&euro;. Standard: 30 fotografii HDR + aeriene, de la 200&euro;. Premium: 50+ fotografii, twilight, livrare 24h, de la 350&euro;.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
