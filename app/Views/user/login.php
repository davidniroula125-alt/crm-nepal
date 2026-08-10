<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - CRM Nepal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--primary:#1B3A6B;--primary-dark:#132C52;--primary-mid:#4A90D9;--accent:#DC3545;--text:#1F2A2E;--muted:#5B6B6E;--bg:#fff;--border:#D8E2EC;--success:#2E9E5B;--danger:#DC3545;--font:'Inter',sans-serif;--font-h:'Poppins',sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
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
.field{margin-bottom:18px}
.field label{display:block;font-size:.85rem;font-weight:600;margin-bottom:6px;color:var(--text)}
.field input{width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:8px;font-size:.95rem;font-family:var(--font);transition:border-color .2s,box-shadow .2s;background:var(--bg);color:var(--text)}
.field input:focus{outline:none;border-color:var(--primary-mid);box-shadow:0 0 0 3px rgba(74,144,217,.12)}
.btn{width:100%;padding:13px;border:none;border-radius:8px;font-weight:600;font-size:.95rem;font-family:var(--font);cursor:pointer;transition:all .2s}
.btn-primary{background:linear-gradient(135deg,var(--primary),#2A5298);color:#fff}
.btn-primary:hover{background:linear-gradient(135deg,var(--primary-dark),var(--primary));transform:translateY(-1px);box-shadow:0 4px 16px rgba(27,58,107,.3)}
.alert{padding:12px 16px;border-radius:8px;font-size:.88rem;margin-bottom:18px}
.alert-error{background:#FDECEA;color:var(--danger);border:1px solid #F5C6CB}
.alert-success{background:#E8F5E9;color:var(--success);border:1px solid #C8E6C9}
.links{text-align:center;margin-top:20px;font-size:.88rem;color:var(--muted)}
.links a{color:var(--primary-mid);font-weight:500;text-decoration:none}
.links a:hover{text-decoration:underline}

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
    <a href="<?= site_url('/') ?>"><img src="<?= site_url('assets/images/logo.png') ?>" alt="CRM Software Nepal"></a>
    <h2>Grow Your Travel Business</h2>
    <p>Access your CRM dashboard to manage leads, track payments, and grow your travel agency.</p>
    <div class="login-features">
      <div class="login-feature">
        <span class="login-feature-icon">&#128200;</span>
        Track your leads and conversions
      </div>
      <div class="login-feature">
        <span class="login-feature-icon">&#128197;</span>
        Manage follow-ups and bookings
      </div>
      <div class="login-feature">
        <span class="login-feature-icon">&#128176;</span>
        View payment history and status
      </div>
    </div>
  </div>
</div>

<div class="login-right">
  <div class="login-card">
    <div class="login-brand-mobile">
      <a href="<?= site_url('/') ?>"><img src="<?= site_url('assets/images/logo.png') ?>" alt="CRM Software Nepal"></a>
      <p>Log in to your account</p>
    </div>

    <h2 class="login-title">Welcome Back</h2>
    <p class="login-subtitle">Sign in to your account</p>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= site_url('user/login') ?>">
      <?= csrf_field() ?>
      <div class="field">
        <label>Email Address</label>
        <input type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="your@email.com" required autofocus>
      </div>
      <div class="field">
        <label>Password</label>
        <input type="password" name="password" placeholder="Your password" required>
      </div>
      <button type="submit" class="btn btn-primary">Sign In</button>
    </form>

    <div class="links">Don't have an account? <a href="<?= site_url('user/signup') ?>">Sign Up Free</a></div>
    <div class="links" style="margin-top:12px;"><a href="<?= site_url('/') ?>">&larr; Back to Homepage</a></div>
  </div>
</div>

</body>
</html>
