<?php
/**
 * Pagina Despre Noi
 *
 * Variabile disponibile (din PageController::despreNoi):
 * @var array $settings     - setarile site-ului
 * @var array $testimonials - testimonialele active
 * @var array $clientLogos  - logo-urile clientilor
 */
?>

<?php
$heroBadge = 'Despre Noi';
$heroBadgeIcon = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>';
$heroTitle = 'Despre Scanbox';
$heroSubtitle = 'Soluții vizuale profesionale care transformă modul în care clienții experimentează spațiile și produsele.';
include __DIR__ . '/../components/hero.php';
?>

<!-- ===== STORY SECTION ===== -->
<section style="padding: 80px 0;">
  <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center;">
      <div>
        <span style="display: inline-block; padding: 6px 16px; background: rgba(4,180,148,0.1); border-radius: 20px; font-size: 13px; font-weight: 600; color: #04B494; margin-bottom: 16px;">Povestea Noastră</span>
        <h2 style="font-size: 36px; font-weight: 800; margin-bottom: 20px; line-height: 1.2;">Reseller Oficial Matterport<br>România & Republica Moldova</h2>
        <p style="color: #94A3B8; line-height: 1.8; margin-bottom: 16px;">Cu o experiență de peste 5 ani în domeniul soluțiilor vizuale profesionale, Scanbox s-a impus ca lider pe piața din România pentru tururi virtuale 3D Matterport.</p>
        <p style="color: #94A3B8; line-height: 1.8; margin-bottom: 16px;">Suntem singurii Reseller Oficial Matterport pentru România și Republica Moldova, oferind clienților noștri acces la cele mai avansate tehnologii de scanare 3D disponibile pe piață.</p>
        <p style="color: #94A3B8; line-height: 1.8;">Echipa noastră de profesioniști combină expertiza tehnică cu creativitatea artistică pentru a livra soluții vizuale care depășesc așteptările clienților noștri din domenii precum imobiliare, HoReCa, retail și turism.</p>
      </div>
      <div style="padding: 40px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 24px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
          <div style="text-align: center; padding: 24px;">
            <div style="font-size: 42px; font-weight: 800; color: #04B494; margin-bottom: 8px;">150+</div>
            <div style="font-size: 14px; color: #94A3B8;">Tururi Virtuale</div>
          </div>
          <div style="text-align: center; padding: 24px;">
            <div style="font-size: 42px; font-weight: 800; color: #04B494; margin-bottom: 8px;">500+</div>
            <div style="font-size: 14px; color: #94A3B8;">Proiecte Finalizate</div>
          </div>
          <div style="text-align: center; padding: 24px;">
            <div style="font-size: 42px; font-weight: 800; color: #04B494; margin-bottom: 8px;">50+</div>
            <div style="font-size: 14px; color: #94A3B8;">Clienți Mulțumiți</div>
          </div>
          <div style="text-align: center; padding: 24px;">
            <div style="font-size: 42px; font-weight: 800; color: #04B494; margin-bottom: 8px;">5+</div>
            <div style="font-size: 14px; color: #94A3B8;">Ani Experiență</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== VALUES ===== -->
<section style="padding: 80px 0; background: rgba(255,255,255,0.02);">
  <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
    <div class="section-header" style="text-align: center; margin-bottom: 48px;">
      <span style="display: inline-block; padding: 6px 16px; background: rgba(4,180,148,0.1); border-radius: 20px; font-size: 13px; font-weight: 600; color: #04B494; margin-bottom: 16px;">Ce Ne Definește</span>
      <h2 style="font-size: 32px; font-weight: 700;">Valorile Noastre</h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
      <div style="padding: 32px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px; text-align: center;">
        <div style="width: 60px; height: 60px; background: rgba(4,180,148,0.12); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
        </div>
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px;">Calitate Premium</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Folosim echipamente de ultimă generație și cele mai avansate tehnici de procesare pentru a livra rezultate excepționale.</p>
      </div>
      <div style="padding: 32px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px; text-align: center;">
        <div style="width: 60px; height: 60px; background: rgba(4,180,148,0.12); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px;">Livrare Rapidă</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Înțelegem importanța timpului în afaceri. Livrăm proiectele în termenele agreate, fără compromisuri la calitate.</p>
      </div>
      <div style="padding: 32px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px; text-align: center;">
        <div style="width: 60px; height: 60px; background: rgba(4,180,148,0.12); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#04B494" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 12px;">Parteneriat Real</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Nu suntem doar furnizori, ci parteneri. Înțelegem nevoile fiecărui client și oferim soluții personalizate.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== SERVICES ===== -->
<section style="padding: 80px 0;">
  <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
    <div class="section-header" style="text-align: center; margin-bottom: 48px;">
      <span style="display: inline-block; padding: 6px 16px; background: rgba(4,180,148,0.1); border-radius: 20px; font-size: 13px; font-weight: 600; color: #04B494; margin-bottom: 16px;">Servicii Complete</span>
      <h2 style="font-size: 32px; font-weight: 700;">Ce Oferim</h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;">
      <div style="padding: 28px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #04B494;">Tur Virtual 3D Matterport</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Digitizare completă a spațiilor cu tehnologie Matterport Pro 2 și Pro 3.</p>
      </div>
      <div style="padding: 28px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #04B494;">Fotografie Profesională</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Corporate, comercială, culinară și imobiliară cu echipament premium.</p>
      </div>
      <div style="padding: 28px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #04B494;">Videografie & Drone</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Filmări 4K, aeriene cu dronă, editare cinematică profesională.</p>
      </div>
      <div style="padding: 28px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #04B494;">Randare 3D</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Vizualizări fotorealiste pentru proiecte de arhitectură și design interior.</p>
      </div>
      <div style="padding: 28px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #04B494;">Social Media Content</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Conținut vizual profesional și strategie de social media pentru branduri.</p>
      </div>
      <div style="padding: 28px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;">
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 8px; color: #04B494;">Sport Content</h3>
        <p style="color: #94A3B8; font-size: 14px; line-height: 1.7;">Fotografie sport, Product in Action și Reels pentru evenimente sportive.</p>
      </div>
    </div>
  </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<?php if (!empty($testimonials)): ?>
<?php include __DIR__ . '/../components/testimonial-slider.php'; ?>
<?php endif; ?>

<!-- ===== CLIENT LOGOS ===== -->
<?php if (!empty($clientLogos)): ?>
<?php $logos = $clientLogos; include __DIR__ . '/../components/client-carousel.php'; ?>
<?php endif; ?>

<style>
@media (max-width: 768px) {
  .container > div[style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
  div[style*="grid-template-columns: repeat(3"] { grid-template-columns: 1fr !important; }
}
</style>
