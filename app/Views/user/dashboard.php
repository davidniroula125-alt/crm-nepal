<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Dashboard - CRM Nepal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--primary:#1B3A6B;--primary-dark:#132C52;--primary-mid:#4A90D9;--accent:#DC3545;--text:#1F2A2E;--muted:#5B6B6E;--bg:#F4F7FB;--white:#fff;--border:#D8E2EC;--success:#2E9E5B;--warning:#E0A72E;--info:#17a2b8;--font:'Inter',sans-serif;--font-h:'Poppins',sans-serif}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font);color:var(--text);background:var(--bg);min-height:100vh}

.topbar{background:var(--primary-dark);padding:14px 28px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 8px rgba(0,0,0,.15)}
.topbar h1{font-size:18px;color:#fff;font-family:var(--font-h)}
.topbar-right{display:flex;gap:16px;align-items:center}
.topbar-right a{font-size:14px;color:rgba(255,255,255,.8);text-decoration:none;font-weight:500}
.topbar-right a:hover{color:#fff}
.topbar-right .btn-logout{background:var(--accent);color:#fff!important;padding:6px 16px;border-radius:6px;font-weight:600}

.container{max-width:1100px;margin:24px auto;padding:0 24px}

.welcome{background:linear-gradient(135deg,var(--primary),#2A5298);border-radius:12px;padding:32px;color:#fff;margin-bottom:24px}
.welcome h2{font-family:var(--font-h);font-size:24px;margin-bottom:6px}
.welcome p{opacity:.85;font-size:15px}

.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px}
.stat-card{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:20px;text-align:center;box-shadow:0 2px 6px rgba(27,58,107,.06);transition:transform .2s}
.stat-card:hover{transform:translateY(-2px)}
.stat-number{font-size:32px;font-weight:700;font-family:var(--font-h);margin-bottom:4px}
.stat-label{font-size:13px;color:var(--muted);font-weight:500;text-transform:uppercase;letter-spacing:.5px}
.stat-open .stat-number{color:var(--warning)}
.stat-replied .stat-number{color:var(--info)}
.stat-closed .stat-number{color:var(--success)}
.stat-total .stat-number{color:var(--primary)}

.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:24px}
@media(max-width:768px){.grid-2{grid-template-columns:1fr}}

.card{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:24px;box-shadow:0 2px 6px rgba(27,58,107,.06)}
.card h3{font-family:var(--font-h);font-size:17px;margin-bottom:16px;color:var(--primary-dark)}

.form-group{margin-bottom:14px}
.form-group label{display:block;font-size:14px;font-weight:600;margin-bottom:5px}
.form-group input,.form-group textarea{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:6px;font-size:14px;font-family:var(--font);transition:border-color .2s}
.form-group textarea{min-height:90px;resize:vertical}
.form-group input:focus,.form-group textarea:focus{outline:none;border-color:var(--primary-mid);box-shadow:0 0 0 3px rgba(74,144,217,.12)}

.btn{padding:11px 24px;border:none;border-radius:6px;font-weight:600;font-size:14px;cursor:pointer;transition:all .2s;font-family:var(--font)}
.btn-primary{background:linear-gradient(135deg,var(--primary),#2A5298);color:#fff}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(27,58,107,.3)}
.btn-sm{padding:6px 14px;font-size:12px}
.btn-outline{background:transparent;border:1px solid var(--border);color:var(--text)}
.btn-outline:hover{background:var(--bg)}

.badge{padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;display:inline-block}
.badge-open{background:#FFF3CD;color:#856404}
.badge-progress{background:#CCE5FF;color:#004085}
.badge-replied{background:#D4EDDA;color:#155724}
.badge-closed{background:#E2E3E5;color:#383D41}

table{width:100%;border-collapse:collapse;font-size:13px}
th,td{padding:10px 12px;text-align:left;border-bottom:1px solid var(--border)}
th{font-weight:600;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--muted)}

.alert{padding:12px 16px;border-radius:6px;font-size:14px;margin-bottom:16px}
.alert-success{background:#E8F5E9;color:var(--success);border:1px solid #C8E6C9}
.alert-error{background:#FDECEA;color:var(--accent);border:1px solid #F5C6CB}

.empty{text-align:center;padding:24px;color:var(--muted);font-size:14px}
</style>
</head>
<body>

<div class="topbar">
  <h1>CRM Software Nepal</h1>
  <div class="topbar-right">
    <a href="<?= site_url('/') ?>">Home</a>
    <a href="<?= site_url('user/dashboard') ?>">Dashboard</a>
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

  <div class="welcome">
    <h2>Welcome back, <?= esc($userName) ?>!</h2>
    <p><?= esc($userEmail) ?> &mdash; Here's your account overview.</p>
  </div>

  <div class="stats-grid">
    <div class="stat-card stat-total">
      <div class="stat-number"><?= $totalComplaints ?></div>
      <div class="stat-label">Total Complaints</div>
    </div>
    <div class="stat-card stat-open">
      <div class="stat-number"><?= $openComplaints ?></div>
      <div class="stat-label">Open</div>
    </div>
    <div class="stat-card stat-replied">
      <div class="stat-number"><?= $repliedComplaints ?></div>
      <div class="stat-label">Replied</div>
    </div>
    <div class="stat-card stat-closed">
      <div class="stat-number"><?= $closedComplaints ?></div>
      <div class="stat-label">Closed</div>
    </div>
  </div>

  <div class="grid-2">
    <div class="card">
      <h3>Submit a Complaint</h3>
      <form method="POST" action="<?= site_url('complaint/submit') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
          <label>Subject</label>
          <input type="text" name="subject" placeholder="Brief description" required>
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea name="message" placeholder="Describe your issue..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Complaint</button>
      </form>
    </div>

    <div class="card">
      <h3>Recent Complaints</h3>
      <?php if (empty($recentComplaints)): ?>
        <div class="empty">No complaints yet.</div>
      <?php else: ?>
        <table>
          <thead><tr><th>Subject</th><th>Status</th><th>Date</th></tr></thead>
          <tbody>
          <?php foreach ($recentComplaints as $c): ?>
            <tr>
              <td><strong><?= esc($c->subject) ?></strong></td>
              <td>
                <?php
                $cls = 'badge-closed';
                if ($c->status === 'Open') $cls = 'badge-open';
                elseif ($c->status === 'In Progress') $cls = 'badge-progress';
                elseif ($c->status === 'Replied') $cls = 'badge-replied';
                ?>
                <span class="badge <?= $cls ?>"><?= esc($c->status) ?></span>
              </td>
              <td><?= date('M d', strtotime($c->created_at)) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
