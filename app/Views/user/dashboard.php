<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Dashboard - CRM Nepal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/theme.css') ?>">
<style>
body{font-family:var(--font-body);color:var(--color-text);background:var(--color-bg-alt);min-height:100vh}
.topbar{background:#fff;padding:16px 28px;border-bottom:1px solid var(--color-border);display:flex;justify-content:space-between;align-items:center}
.topbar h1{font-size:18px;color:var(--color-primary-dark)}
.topbar-right{display:flex;gap:16px;align-items:center}
.topbar-right a{font-size:14px;color:var(--color-primary-mid,#4A90D9);text-decoration:none;font-weight:500}
.topbar-right a:hover{text-decoration:underline}
.btn-logout{color:var(--color-danger)!important;font-weight:600!important}
.container{max-width:900px;margin:32px auto;padding:0 24px}
.section-title{font-size:22px;font-weight:700;color:var(--color-primary-dark);margin-bottom:20px}
.card{background:#fff;border:1px solid var(--color-border);border-radius:12px;padding:24px;margin-bottom:20px;box-shadow:0 2px 8px rgba(27,58,107,.06)}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:14px;font-weight:600;margin-bottom:6px}
.form-group input,.form-group textarea{width:100%;padding:11px 14px;border:1px solid var(--color-border);border-radius:6px;font-size:14px;font-family:var(--font-body)}
.form-group textarea{min-height:100px;resize:vertical}
.form-group input:focus,.form-group textarea:focus{outline:none;border-color:#4A90D9;box-shadow:0 0 0 3px rgba(74,144,217,.12)}
.btn{padding:12px 28px;border:none;border-radius:6px;font-weight:600;font-size:15px;cursor:pointer;transition:all .2s}
.btn-primary{background:linear-gradient(135deg,var(--color-primary),#2A5298);color:#fff}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(27,58,107,.3)}
table{width:100%;border-collapse:collapse;font-size:14px}
th,td{padding:12px 16px;text-align:left;border-bottom:1px solid var(--color-border)}
th{background:var(--color-primary-light,#E8EFF8);font-weight:600;font-size:13px;text-transform:uppercase;letter-spacing:.5px;color:var(--color-primary-dark)}
.badge{padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600}
.badge-open{background:#FFF3CD;color:#856404}
.badge-progress{background:#CCE5FF;color:#004085}
.badge-replied{background:#D4EDDA;color:#155724}
.badge-closed{background:#E2E3E5;color:#383D41}
.alert{padding:12px 16px;border-radius:6px;font-size:14px;margin-bottom:16px}
.alert-success{background:#E8F5E9;color:var(--color-success,#2E9E5B);border:1px solid #C8E6C9}
.alert-error{background:#FDECEA;color:var(--color-danger,#DC3545);border:1px solid #F5C6CB}
.empty{text-align:center;padding:40px;color:var(--color-text-muted,#5B6B6E)}
</style>
</head>
<body>
<div class="topbar">
  <h1>Welcome, <?= esc($userName) ?></h1>
  <div class="topbar-right">
    <a href="<?= site_url('/') ?>">Home</a>
    <a href="<?= site_url('user/dashboard') ?>">My Complaints</a>
    <a href="<?= site_url('user/logout') ?>" class="btn-logout">Logout</a>
  </div>
</div>

<div class="container">
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <h2 class="section-title">Submit a Complaint</h2>
  <div class="card">
    <form method="POST" action="<?= site_url('complaint/submit') ?>">
      <?= csrf_field() ?>
      <div class="form-group">
        <label>Subject</label>
        <input type="text" name="subject" placeholder="Brief description of your issue" required>
      </div>
      <div class="form-group">
        <label>Message</label>
        <textarea name="message" placeholder="Describe your complaint in detail..." required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit Complaint</button>
    </form>
  </div>

  <h2 class="section-title">My Complaints</h2>
  <?php if (empty($complaints)): ?>
    <div class="card empty">No complaints submitted yet.</div>
  <?php else: ?>
    <div class="card" style="padding:0;overflow:hidden;">
      <table>
        <thead><tr><th>Subject</th><th>Status</th><th>Reply</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach ($complaints as $c): ?>
          <tr>
            <td><strong><?= esc($c->subject) ?></strong></td>
            <td><span class="badge badge-<?= strtolower(str_replace(' ', '', $c->status)) ?>"><?= esc($c->status) ?></span></td>
            <td><?= $c->admin_reply ? esc($c->admin_reply) : '<em style="color:#999">Pending</em>' ?></td>
            <td><?= date('M d, Y', strtotime($c->created_at)) ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
