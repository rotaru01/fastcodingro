<?php
$current_admin_page = 'settings';
$page_title = 'Setări';

ob_start();
?>

<h1>Setări</h1>
<p class="subtitle">Configurează setările generale ale site-ului</p>

<!-- General -->
<div class="card settings-section" style="margin-bottom:24px">
    <h3 class="settings-section-title">General</h3>
    <form method="POST" action="/admin/settings">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="group" value="general">

        <div class="form-group">
            <label for="site_name">Nume site</label>
            <input type="text" id="site_name" name="settings[site_name]"
                   value="<?= htmlspecialchars($settings['site_name']['value'] ?? 'Scanbox.ro') ?>">
        </div>
        <div class="form-group">
            <label for="site_url">URL site</label>
            <input type="url" id="site_url" name="settings[site_url]"
                   value="<?= htmlspecialchars($settings['site_url']['value'] ?? 'https://scanbox.ro') ?>">
        </div>

        <button type="submit" class="btn btn-primary">Salvează setările generale</button>
    </form>
</div>

<!-- Contact -->
<div class="card settings-section" style="margin-bottom:24px">
    <h3 class="settings-section-title">Contact</h3>
    <form method="POST" action="/admin/settings">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="group" value="contact">

        <div class="form-group">
            <label for="contact_email">Email contact</label>
            <input type="email" id="contact_email" name="settings[contact_email]"
                   value="<?= htmlspecialchars($settings['contact_email']['value'] ?? 'office@scanbox.ro') ?>"
                   placeholder="office@scanbox.ro">
        </div>
        <div class="form-group">
            <label for="contact_phone">Telefon</label>
            <input type="text" id="contact_phone" name="settings[contact_phone]"
                   value="<?= htmlspecialchars($settings['contact_phone']['value'] ?? '') ?>"
                   placeholder="0740 233 353">
        </div>
        <div class="form-group">
            <label for="contact_address">Adresă</label>
            <textarea id="contact_address" name="settings[contact_address]" rows="2" placeholder="Adresa companiei"><?= htmlspecialchars($settings['contact_address']['value'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="contact_working_hours">Program de lucru</label>
            <input type="text" id="contact_working_hours" name="settings[contact_working_hours]"
                   value="<?= htmlspecialchars($settings['contact_working_hours']['value'] ?? '') ?>"
                   placeholder="Luni - Vineri, 09:00 - 18:00">
        </div>

        <button type="submit" class="btn btn-primary">Salvează datele de contact</button>
    </form>
</div>

<!-- Social Media -->
<div class="card settings-section" style="margin-bottom:24px">
    <h3 class="settings-section-title">Social Media</h3>
    <form method="POST" action="/admin/settings">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="group" value="social">

        <div class="form-row">
            <div class="form-group">
                <label for="social_instagram">Instagram</label>
                <input type="url" id="social_instagram" name="settings[social_instagram]"
                       value="<?= htmlspecialchars($settings['social_instagram']['value'] ?? '') ?>"
                       placeholder="https://instagram.com/...">
            </div>
            <div class="form-group">
                <label for="social_facebook">Facebook</label>
                <input type="url" id="social_facebook" name="settings[social_facebook]"
                       value="<?= htmlspecialchars($settings['social_facebook']['value'] ?? '') ?>"
                       placeholder="https://facebook.com/...">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="social_tiktok">TikTok</label>
                <input type="url" id="social_tiktok" name="settings[social_tiktok]"
                       value="<?= htmlspecialchars($settings['social_tiktok']['value'] ?? '') ?>"
                       placeholder="https://tiktok.com/@...">
            </div>
            <div class="form-group">
                <label for="social_youtube">YouTube</label>
                <input type="url" id="social_youtube" name="settings[social_youtube]"
                       value="<?= htmlspecialchars($settings['social_youtube']['value'] ?? '') ?>"
                       placeholder="https://youtube.com/@...">
            </div>
        </div>
        <div class="form-group">
            <label for="social_linkedin">LinkedIn</label>
            <input type="url" id="social_linkedin" name="settings[social_linkedin]"
                   value="<?= htmlspecialchars($settings['social_linkedin']['value'] ?? '') ?>"
                   placeholder="https://linkedin.com/company/...">
        </div>

        <button type="submit" class="btn btn-primary">Salvează rețelele sociale</button>
    </form>
</div>

<!-- SEO -->
<div class="card settings-section" style="margin-bottom:24px">
    <h3 class="settings-section-title">SEO</h3>
    <form method="POST" action="/admin/settings">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="group" value="seo">

        <div class="form-group">
            <label for="seo_default_title">Meta Title implicit</label>
            <input type="text" id="seo_default_title" name="settings[seo_default_title]"
                   value="<?= htmlspecialchars($settings['seo_default_title']['value'] ?? '') ?>"
                   placeholder="Scanbox.ro - Servicii Profesionale de Scanare 3D" maxlength="70">
            <span class="char-count" data-for="seo_default_title">0/70</span>
        </div>
        <div class="form-group">
            <label for="seo_default_description">Meta Description implicită</label>
            <textarea id="seo_default_description" name="settings[seo_default_description]" rows="3"
                      placeholder="Descrierea site-ului pentru motoarele de căutare" maxlength="160"><?= htmlspecialchars($settings['seo_default_description']['value'] ?? '') ?></textarea>
            <span class="char-count" data-for="seo_default_description">0/160</span>
        </div>

        <button type="submit" class="btn btn-primary">Salvează setările SEO</button>
    </form>
</div>

<!-- Statistici -->
<div class="card settings-section" style="margin-bottom:24px">
    <h3 class="settings-section-title">Contoare statistici</h3>
    <p class="form-hint" style="margin-bottom:16px">Valorile afișate în secțiunea de statistici de pe pagina principală</p>
    <form method="POST" action="/admin/settings">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
        <input type="hidden" name="group" value="stats">

        <div class="form-row">
            <div class="form-group">
                <label for="stats_projects_count">Proiecte finalizate</label>
                <input type="number" id="stats_projects_count" name="settings[stats_projects_count]"
                       value="<?= htmlspecialchars((string)($settings['stats_projects_count']['value'] ?? '0')) ?>" min="0">
            </div>
            <div class="form-group">
                <label for="stats_clients_count">Clienți mulțumiți</label>
                <input type="number" id="stats_clients_count" name="settings[stats_clients_count]"
                       value="<?= htmlspecialchars((string)($settings['stats_clients_count']['value'] ?? '0')) ?>" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="stats_years_experience">Ani de experiență</label>
                <input type="number" id="stats_years_experience" name="settings[stats_years_experience]"
                       value="<?= htmlspecialchars((string)($settings['stats_years_experience']['value'] ?? '0')) ?>" min="0">
            </div>
            <div class="form-group">
                <label for="stats_satisfaction_rate">Rată de satisfacție (%)</label>
                <input type="number" id="stats_satisfaction_rate" name="settings[stats_satisfaction_rate]"
                       value="<?= htmlspecialchars((string)($settings['stats_satisfaction_rate']['value'] ?? '98')) ?>" min="0" max="100">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvează contoarele</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
