<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - CRM Nepal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--primary:#1B3A6B;--primary-dark:#132C52;--primary-mid:#4A90D9;--accent:#DC3545;--text:#1F2A2E;--muted:#5B6B6E;--bg:#fff;--bg-alt:#F4F7FB;--border:#D8E2EC;--success:#2E9E5B;--danger:#DC3545;--font:'Inter',sans-serif;--font-h:'Poppins',sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font);background:linear-gradient(135deg,var(--bg-alt) 0%,#E0EAF6 100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{width:100%;max-width:420px;background:var(--bg);border:1px solid var(--border);border-radius:12px;box-shadow:0 8px 24px rgba(27,58,107,.12);padding:40px 36px}
.brand{text-align:center;margin-bottom:28px}
.brand img{height:48px;margin-bottom:6px}
.brand p{font-size:14px;color:var(--muted)}
h2{font-family:var(--font-h);font-size:20px;text-align:center;color:var(--primary);margin-bottom:24px}
.field{margin-bottom:18px}
.field label{display:block;font-size:14px;font-weight:600;margin-bottom:6px;color:var(--text)}
.field input{width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:6px;font-size:15px;font-family:var(--font);transition:border-color .2s}
.field input:focus{outline:none;border-color:var(--primary-mid);box-shadow:0 0 0 3px rgba(74,144,217,.12)}
.btn{width:100%;padding:13px;border:none;border-radius:6px;font-weight:600;font-size:15px;font-family:var(--font);cursor:pointer;transition:all .2s}
.btn-primary{background:linear-gradient(135deg,var(--primary),#2A5298);color:#fff}
.btn-primary:hover{background:linear-gradient(135deg,var(--primary-dark),var(--primary));transform:translateY(-1px);box-shadow:0 4px 12px rgba(27,58,107,.3)}
.alert{padding:12px 16px;border-radius:6px;font-size:14px;margin-bottom:18px}
.alert-error{background:#FDECEA;color:var(--danger);border:1px solid #F5C6CB}
.alert-success{background:#E8F5E9;color:var(--success);border:1px solid #C8E6C9}
.links{text-align:center;margin-top:20px;font-size:14px;color:var(--muted)}
.links a{color:var(--primary-mid);font-weight:500;text-decoration:none}
.links a:hover{text-decoration:underline}
.back{text-align:center;margin-top:16px}
.back a{font-size:13px;color:var(--muted);text-decoration:none}
.back a:hover{color:var(--primary)}
</style>
</head>
<body>
<div class="card">
  <div class="brand">
    <img src="<?= site_url('assets/images/logo.png') ?>" alt="CRM Software Nepal">
    <p>Log in to your account</p>
  </div>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <form method="POST" action="<?= site_url('user/login') ?>">
    <?= csrf_field() ?>
    <div class="field">
      <label>Email</label>
      <input type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="your@email.com" required autofocus>
    </div>
    <div class="field">
      <label>Password</label>
      <input type="password" name="password" placeholder="Your password" required>
    </div>
    <button type="submit" class="btn btn-primary">Log In</button>
  </form>
  <div class="links">Don't have an account? <a href="<?= site_url('user/signup') ?>">Sign Up</a></div>
  <div class="links" style="margin-top:8px;"><a href="<?= site_url('/') ?>">Back to Homepage</a></div>
</div>
</body>
</html>
