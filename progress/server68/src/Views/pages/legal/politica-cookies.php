<?php
/**
 * Politica de Cookies
 */
?>

<?php
$heroBadge = 'Legal';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>';
$heroTitle = 'Politica de Cookies';
$heroSubtitle = 'Informații despre utilizarea cookie-urilor pe site-ul nostru';
include __DIR__ . '/../../components/hero.php';
?>

<section style="padding: 80px 0;">
  <div class="container" style="max-width: 900px; margin: 0 auto; padding: 0 24px;">
    <div style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 24px; padding: 48px;">
      <div style="color: #CBD5E1; font-size: 15px; line-height: 1.9;">

        <h2 style="font-size: 24px; font-weight: 700; color: #fff; margin-bottom: 24px;">1. Ce sunt Cookie-urile?</h2>
        <p>Cookie-urile sunt fișiere text de mici dimensiuni stocate pe dispozitivul dumneavoastră (calculator, telefon, tabletă) atunci când vizitați un site web. Acestea permit site-ului să vă recunoască dispozitivul și să rețină anumite informații despre vizita dumneavoastră.</p>

        <h2 style="font-size: 24px; font-weight: 700; color: #fff; margin: 32px 0 24px;">2. Tipuri de Cookie-uri Utilizate</h2>

        <div style="margin-bottom: 24px; padding: 20px; background: rgba(4,180,148,0.06); border: 1px solid rgba(4,180,148,0.15); border-radius: 16px;">
          <h3 style="font-size: 16px; font-weight: 700; color: #04B494; margin-bottom: 8px;">Cookie-uri Esențiale</h3>
          <p>Necesare pentru funcționarea site-ului. Includ cookie-urile de sesiune și preferințele de confidențialitate. Nu pot fi dezactivate.</p>
          <p style="margin-top: 8px; font-size: 13px; color: #64748B;">Exemplu: PHPSESSID, cookie_consent</p>
        </div>

        <div style="margin-bottom: 24px; padding: 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px;">
          <h3 style="font-size: 16px; font-weight: 700; color: #E2E8F0; margin-bottom: 8px;">Cookie-uri de Performanță</h3>
          <p>Colectează informații anonime despre modul în care vizitatorii utilizează site-ul, pentru a ne ajuta să îmbunătățim experiența de navigare.</p>
          <p style="margin-top: 8px; font-size: 13px; color: #64748B;">Exemplu: Google Analytics (_ga, _gid, _gat)</p>
        </div>

        <div style="margin-bottom: 24px; padding: 20px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px;">
          <h3 style="font-size: 16px; font-weight: 700; color: #E2E8F0; margin-bottom: 8px;">Cookie-uri de Marketing</h3>
          <p>Utilizate pentru a afișa reclame relevante și pentru a măsura eficiența campaniilor publicitare. Sunt setate de partenerii noștri de publicitate.</p>
          <p style="margin-top: 8px; font-size: 13px; color: #64748B;">Exemplu: Facebook Pixel, Google Ads</p>
        </div>

        <h2 style="font-size: 24px; font-weight: 700; color: #fff; margin: 32px 0 24px;">3. Durata Cookie-urilor</h2>
        <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
          <thead>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.1);">
              <th style="text-align: left; padding: 12px; color: #E2E8F0; font-size: 14px;">Cookie</th>
              <th style="text-align: left; padding: 12px; color: #E2E8F0; font-size: 14px;">Tip</th>
              <th style="text-align: left; padding: 12px; color: #E2E8F0; font-size: 14px;">Durată</th>
            </tr>
          </thead>
          <tbody>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
              <td style="padding: 12px; font-size: 14px;">PHPSESSID</td>
              <td style="padding: 12px; font-size: 14px;">Esențial</td>
              <td style="padding: 12px; font-size: 14px;">Sesiune</td>
            </tr>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
              <td style="padding: 12px; font-size: 14px;">cookie_consent</td>
              <td style="padding: 12px; font-size: 14px;">Esențial</td>
              <td style="padding: 12px; font-size: 14px;">1 an</td>
            </tr>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
              <td style="padding: 12px; font-size: 14px;">_ga</td>
              <td style="padding: 12px; font-size: 14px;">Performanță</td>
              <td style="padding: 12px; font-size: 14px;">2 ani</td>
            </tr>
            <tr style="border-bottom: 1px solid rgba(255,255,255,0.04);">
              <td style="padding: 12px; font-size: 14px;">_gid</td>
              <td style="padding: 12px; font-size: 14px;">Performanță</td>
              <td style="padding: 12px; font-size: 14px;">24 ore</td>
            </tr>
          </tbody>
        </table>

        <h2 style="font-size: 24px; font-weight: 700; color: #fff; margin: 32px 0 24px;">4. Gestionarea Cookie-urilor</h2>
        <p>Puteți controla și gestiona cookie-urile în mai multe moduri:</p>
        <ul style="margin: 16px 0; padding-left: 24px;">
          <li style="margin-bottom: 8px;"><strong style="color: #E2E8F0;">Setările browser-ului</strong> — majoritatea browserelor vă permit să blocați sau să ștergeți cookie-urile</li>
          <li style="margin-bottom: 8px;"><strong style="color: #E2E8F0;">Banner-ul de cookie-uri</strong> — la prima vizită, puteți alege ce tipuri de cookie-uri acceptați</li>
          <li style="margin-bottom: 8px;"><strong style="color: #E2E8F0;">Google Analytics opt-out</strong> — puteți instala <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener" style="color: #04B494;">extensia de browser</a> pentru dezactivarea Google Analytics</li>
        </ul>
        <p>Dezactivarea cookie-urilor poate afecta funcționalitatea site-ului.</p>

        <h2 style="font-size: 24px; font-weight: 700; color: #fff; margin: 32px 0 24px;">5. Contact</h2>
        <p>Pentru întrebări despre politica de cookies, contactați-ne la <strong style="color: #04B494;">office@scanbox.ro</strong>.</p>

        <p style="margin-top: 32px; font-size: 13px; color: #64748B;">Ultima actualizare: Februarie 2026</p>
      </div>
    </div>
  </div>
</section>
