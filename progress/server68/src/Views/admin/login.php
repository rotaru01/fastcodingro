<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare — Scanbox Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0D1B2A;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 48px;
            max-width: 420px;
            width: 100%;
            text-align: center;
        }
        .login-logo {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #04B494, #039B7E);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            margin: 0 auto 24px;
        }
        .login-box h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
        }
        .login-box p {
            color: #94A3B8;
            font-size: 14px;
            margin-bottom: 32px;
        }
        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #94A3B8;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            color: #fff;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
        }
        .form-group input:focus {
            outline: none;
            border-color: rgba(4,180,148,0.5);
        }
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #04B494, #039B7E);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(4,180,148,0.3);
        }
        .error-message {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.2);
            color: #ef4444;
            font-size: 13px;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            text-align: left;
        }
        .back-link {
            display: inline-block;
            margin-top: 24px;
            color: #94A3B8;
            font-size: 13px;
            text-decoration: none;
        }
        .back-link:hover {
            color: #04B494;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-logo">S</div>
        <h1>Scanbox Admin</h1>
        <p>Introdu datele de autentificare pentru a accesa panoul de administrare</p>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" autocomplete="on">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Adresa de email"
                       value="" autofocus required>
            </div>

            <div class="form-group">
                <label for="password">Parolă</label>
                <input type="password" id="password" name="password" placeholder="Parola" required>
            </div>

            <button type="submit" class="login-btn">Autentificare</button>
        </form>

        <a href="/" class="back-link">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" fill="none" stroke-width="2" style="vertical-align:middle;margin-right:4px"><polyline points="15 18 9 12 15 6"/></svg>
            Înapoi la site
        </a>
    </div>
</body>
</html>
