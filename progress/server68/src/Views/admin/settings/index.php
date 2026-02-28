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
        <div class="form-group">
            <label for="admin_email">Email administrator</label>
            <input type="email" id="admin_email" name="settings[admin_email]"
                   value="<?= htmlspecialchars($settings['admin_email']['value'] ?? 'office@scanbox.ro') ?>">
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
            <label for="phone">Telefon</label>
            <input type="text" id="phone" name="settings[phone]"
                   value="<?= htmlspecialchars($settings['phone']['value'] ?? '') ?>"
                   placeholder="+40 7XX XXX XXX">
        </div>
        <div class="form-group">
            <label for="address">Adresă</label>
            <textarea id="address" name="settings[address]" rows="2" placeholder="Adresa companiei"><?= htmlspecialchars($settings['address']['value'] ?? '') ?></textarea>
        </div>
        <div class="form-group">
            <label for="working_hours">Program de lucru</label>
            <input type="text" id="working_hours" name="settings[working_hours]"
                   value="<?= htmlspecialchars($settings['working_hours']['value'] ?? '') ?>"
                   placeholder="Luni - Vineri: 09:00 - 18:00">
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
                <label for="instagram_url">Instagram</label>
                <input type="url" id="instagram_url" name="settings[instagram_url]"
                       value="<?= htmlspecialchars($settings['instagram_url']['value'] ?? '') ?>"
                       placeholder="https://instagram.com/...">
            </div>
            <div class="form-group">
                <label for="facebook_url">Facebook</label>
                <input type="url" id="facebook_url" name="settings[facebook_url]"
                       value="<?= htmlspecialchars($settings['facebook_url']['value'] ?? '') ?>"
                       placeholder="https://facebook.com/...">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="tiktok_url">TikTok</label>
                <input type="url" id="tiktok_url" name="settings[tiktok_url]"
                       value="<?= htmlspecialchars($settings['tiktok_url']['value'] ?? '') ?>"
                       placeholder="https://tiktok.com/@...">
            </div>
            <div class="form-group">
                <label for="youtube_url">YouTube</label>
                <input type="url" id="youtube_url" name="settings[youtube_url]"
                       value="<?= htmlspecialchars($settings['youtube_url']['value'] ?? '') ?>"
                       placeholder="https://youtube.com/@...">
            </div>
        </div>
        <div class="form-group">
            <label for="linkedin_url">LinkedIn</label>
            <input type="url" id="linkedin_url" name="settings[linkedin_url]"
                   value="<?= htmlspecialchars($settings['linkedin_url']['value'] ?? '') ?>"
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
            <label for="default_meta_title">Meta Title implicit</label>
            <input type="text" id="default_meta_title" name="settings[default_meta_title]"
                   value="<?= htmlspecialchars($settings['default_meta_title']['value'] ?? '') ?>"
                   placeholder="Scanbox.ro - Servicii Profesionale de Scanare 3D" maxlength="70">
            <span class="char-count" data-for="default_meta_title">0/70</span>
        </div>
        <div class="form-group">
            <label for="default_meta_description">Meta Description implicită</label>
            <textarea id="default_meta_description" name="settings[default_meta_description]" rows="3"
                      placeholder="Descrierea site-ului pentru motoarele de căutare" maxlength="160"><?= htmlspecialchars($settings['default_meta_description']['value'] ?? '') ?></textarea>
            <span class="char-count" data-for="default_meta_description">0/160</span>
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
                <label for="stats_tours_count">Tururi virtuale realizate</label>
                <input type="number" id="stats_tours_count" name="settings[stats_tours_count]"
                       value="<?= htmlspecialchars($settings['stats_tours_count']['value'] ?? '0') ?>" min="0">
            </div>
            <div class="form-group">
                <label for="stats_projects_count">Proiecte finalizate</label>
                <input type="number" id="stats_projects_count" name="settings[stats_projects_count]"
                       value="<?= htmlspecialchars($settings['stats_projects_count']['value'] ?? '0') ?>" min="0">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="stats_clients_count">Clienți mulțumiți</label>
                <input type="number" id="stats_clients_count" name="settings[stats_clients_count]"
                       value="<?= htmlspecialchars($settings['stats_clients_count']['value'] ?? '0') ?>" min="0">
            </div>
            <div class="form-group">
                <label for="stats_years_experience">Ani de experiență</label>
                <input type="number" id="stats_years_experience" name="settings[stats_years_experience]"
                       value="<?= htmlspecialchars($settings['stats_years_experience']['value'] ?? '0') ?>" min="0">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvează contoarele</button>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout/admin-layout.php';
?>
