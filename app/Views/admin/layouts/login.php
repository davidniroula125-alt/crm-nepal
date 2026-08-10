<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($metaTitle ?? 'Admin Login') ?> - CRM Nepal</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --color-primary: #1B3A6B;
    --color-primary-dark: #132C52;
    --color-primary-light: #E8EFF8;
    --color-primary-mid: #4A90D9;
    --color-accent: #DC3545;
    --color-accent-dark: #B52D3A;
    --color-text: #1F2A2E;
    --color-text-muted: #5B6B6E;
    --color-bg: #FFFFFF;
    --color-bg-alt: #F4F7FB;
    --color-border: #D8E2EC;
    --color-success: #2E9E5B;
    --color-danger: #DC3545;
    --color-warning: #E0A72E;
    --font-heading: 'Poppins', 'Segoe UI', sans-serif;
    --font-body: 'Inter', 'Segoe UI', sans-serif;
    --radius-sm: 6px;
    --radius-md: 12px;
    --shadow-sm: 0 1px 3px rgba(27, 58, 107, 0.08);
    --shadow-md: 0 8px 24px rgba(27, 58, 107, 0.12);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: var(--font-body);
    color: var(--color-text);
    background: linear-gradient(135deg, #E8EFF8 0%, #F4F7FB 50%, #E0EAF6 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
  }

  .login-wrapper {
    width: 100%;
    max-width: 420px;
  }

  .login-card {
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
    padding: 40px 36px;
  }

  .login-brand {
    text-align: center;
    margin-bottom: 32px;
  }

  .login-brand img {
    height: 48px;
    margin-bottom: 8px;
  }

  .login-brand p {
    font-size: 14px;
    color: var(--color-text-muted);
    margin-top: 6px;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 6px;
  }

  .form-control {
    width: 100%;
    padding: 12px 14px;
    font-family: var(--font-body);
    font-size: 15px;
    color: var(--color-text);
    background: var(--color-bg);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    outline: none;
    transition: border-color .15s;
  }

  .form-control:focus {
    border-color: var(--color-primary-mid);
    box-shadow: 0 0 0 3px rgba(74, 144, 217, 0.15);
  }

  .form-check {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
  }

  .form-check input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: var(--color-primary);
  }

  .form-check label {
    font-size: 14px;
    color: var(--color-text-muted);
    margin: 0;
  }

  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 13px 26px;
    border-radius: var(--radius-sm);
    font-family: var(--font-body);
    font-weight: 600;
    font-size: 15px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: .2s ease;
  }

  .btn-primary {
    background: linear-gradient(135deg, #1B3A6B 0%, #2A5298 100%);
    color: #fff;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #132C52 0%, #1B3A6B 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(27, 58, 107, 0.3);
  }

  .login-links {
    text-align: center;
    margin-top: 20px;
  }

  .login-links a {
    font-size: 14px;
    color: var(--color-primary-mid);
    font-weight: 500;
  }

  .login-links a:hover {
    text-decoration: underline;
  }

  .alert {
    padding: 12px 16px;
    border-radius: var(--radius-sm);
    font-size: 14px;
    margin-bottom: 20px;
    line-height: 1.5;
  }

  .alert-error {
    background: #FDECEA;
    color: var(--color-danger);
    border: 1px solid #F5C6CB;
  }

  .alert-success {
    background: #E8F5E9;
    color: var(--color-success);
    border: 1px solid #C8E6C9;
  }

  .back-home {
    text-align: center;
    margin-top: 20px;
  }

  .back-home a {
    font-size: 13px;
    color: var(--color-text-muted);
  }

  .back-home a:hover { color: var(--color-primary); }
</style>
</head>
<body>

<div class="login-wrapper">
  <div class="login-card">
    <div class="login-brand">
      <img src="<?= site_url('assets/images/logo.png') ?>" alt="CRM Software Nepal">
      <p>Admin Panel Login</p>
    </div>
    <?= $this->renderSection('content') ?>
  </div>
  <div class="back-home">
    <a href="<?= site_url('/') ?>">&larr; Back to Homepage</a>
  </div>
</div>

</body>
</html>
