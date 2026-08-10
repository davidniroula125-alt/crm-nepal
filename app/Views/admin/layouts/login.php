<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc($metaTitle ?? 'Admin Login') ?> - CRM Nepal</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--primary:#1B3A6B;--primary-dark:#132C52;--primary-mid:#4A90D9;--accent:#DC3545;--text:#1F2A2E;--muted:#5B6B6E;--bg:#fff;--border:#D8E2EC;--success:#2E9E5B;--danger:#DC3545;--font:'Inter',sans-serif;--font-h:'Poppins',sans-serif}
*,*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font);color:var(--text);min-height:100vh;display:flex}

.login-left{flex:1;background:linear-gradient(135deg,#0f2444 0%,#1a3560 50%,#1B3A6B 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px;color:#fff;position:relative;overflow:hidden}
.login-left::before{content:'';position:absolute;top:-30%;left:-20%;width:70%;height:70%;background:radial-gradient(ellipse,rgba(74,144,217,.2) 0%,transparent 70%);pointer-events:none}
.login-left::after{content:'';position:absolute;bottom:-20%;right:-10%;width:50%;height:60%;background:radial-gradient(ellipse,rgba(15,110,99,.15) 0%,transparent 70%);pointer-events:none}
.login-left-content{position:relative;z-index:1;text-align:center;max-width:380px}
.login-left-content img{height:56px;margin-bottom:28px;filter:brightness(1.2)}
.login-left h2{font-family:var(--font-h);font-size:1.6rem;margin-bottom:12px;font-weight:700;line-height:1.3}
.login-left p{opacity:.8;font-size:.95rem;line-height:1.6;margin-bottom:32px}
.login-features{display:flex;flex-direction:column;gap:14px;text-align:left}
.login-feature{display:flex;align-items:center;gap:12px;font-size:.88rem;opacity:.85}
.login-feature-icon{width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.12);display:flex;align-items:center;justify-content:center;font-size:.9rem;flex-shrink:0}

.login-right{flex:1;display:flex;align-items:center;justify-content:center;padding:40px;background:var(--bg)}
.login-card{width:100%;max-width:400px}
.login-brand-mobile{display:none;text-align:center;margin-bottom:32px}
.login-brand-mobile img{height:44px;margin-bottom:8px}
.login-brand-mobile p{font-size:13px;color:var(--muted)}
.login-title{font-family:var(--font-h);font-size:1.3rem;font-weight:700;color:var(--text);margin-bottom:6px}
.login-subtitle{font-size:.9rem;color:var(--muted);margin-bottom:28px}
.form-group{margin-bottom:18px}
.form-group label{display:block;font-size:.85rem;font-weight:600;color:var(--text);margin-bottom:6px}
.form-control{width:100%;padding:12px 14px;font-family:var(--font);font-size:.95rem;color:var(--text);background:var(--bg);border:1px solid var(--border);border-radius:8px;outline:none;transition:border-color .2s,box-shadow .2s}
.form-control:focus{border-color:var(--primary-mid);box-shadow:0 0 0 3px rgba(74,144,217,.12)}
.form-check{display:flex;align-items:center;gap:8px;margin-bottom:20px}
.form-check input[type="checkbox"]{width:16px;height:16px;accent-color:var(--primary)}
.form-check label{font-size:.88rem;color:var(--muted);margin:0}
.btn{display:inline-flex;align-items:center;justify-content:center;width:100%;padding:13px;border-radius:8px;font-family:var(--font);font-weight:600;font-size:.95rem;border:none;cursor:pointer;transition:all .2s}
.btn-primary{background:linear-gradient(135deg,var(--primary),#2A5298);color:#fff}
.btn-primary:hover{background:linear-gradient(135deg,var(--primary-dark),var(--primary));transform:translateY(-1px);box-shadow:0 4px 16px rgba(27,58,107,.3)}
.login-links{text-align:center;margin-top:20px}
.login-links a{font-size:.88rem;color:var(--primary-mid);font-weight:500;text-decoration:none}
.login-links a:hover{text-decoration:underline}
.back-home{text-align:center;margin-top:20px}
.back-home a{font-size:.82rem;color:var(--muted);text-decoration:none}
.back-home a:hover{color:var(--primary)}
.alert{padding:12px 16px;border-radius:8px;font-size:.88rem;margin-bottom:18px;line-height:1.5}
.alert-error{background:#FDECEA;color:var(--danger);border:1px solid #F5C6CB}
.alert-success{background:#E8F5E9;color:var(--success);border:1px solid #C8E6C9}

@media(max-width:768px){
  body{flex-direction:column}
  .login-left{padding:32px 24px;min-height:auto}
  .login-left h2{font-size:1.2rem}
  .login-features{display:none}
  .login-brand-mobile{display:block}
  .login-right{padding:32px 24px}
}
</style>
</head>
<body>

<div class="login-left">
  <div class="login-left-content">
    <a href="/"><img src="/assets/images/logo.png" alt="CRM Software Nepal"></a>
    <h2>Admin Control Panel</h2>
    <p>Manage your CRM, track leads, monitor payments, and oversee your entire business from one powerful dashboard.</p>
    <div class="login-features">
      <div class="login-feature">
        <span class="login-feature-icon">&#128200;</span>
        Real-time analytics and reporting
      </div>
      <div class="login-feature">
        <span class="login-feature-icon">&#128101;</span>
        Lead and client management
      </div>
      <div class="login-feature">
        <span class="login-feature-icon">&#128176;</span>
        Payment and subscription tracking
      </div>
      <div class="login-feature">
        <span class="login-feature-icon">&#128172;</span>
        Support ticket management
      </div>
    </div>
  </div>
</div>

<div class="login-right">
  <div class="login-card">
    <div class="login-brand-mobile">
      <a href="/"><img src="/assets/images/logo.png" alt="CRM Software Nepal"></a>
      <p>Admin Panel Login</p>
    </div>

    <h2 class="login-title">Welcome Back</h2>
    <p class="login-subtitle">Sign in to your admin account</p>

    <?= $this->renderSection('content') ?>

    <div class="login-links">
      <a href="<?= site_url('admin/forgot-password') ?>">Forgot your password?</a>
    </div>
    <div class="back-home">
      <a href="<?= site_url('/') ?>">&larr; Back to Homepage</a>
    </div>
  </div>
</div>

</body>
</html>
