<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>My Dashboard - CRM Nepal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--primary:#1B3A6B;--primary-dark:#132C52;--primary-mid:#4A90D9;--accent:#DC3545;--text:#1F2A2E;--muted:#5B6B6E;--bg:#F4F7FB;--white:#fff;--border:#D8E2EC;--success:#2E9E5B;--warning:#E0A72E;--info:#17a2b8;--purple:#6F42C1;--font:'Inter',sans-serif;--font-h:'Poppins',sans-serif;--shadow:0 2px 12px rgba(27,58,107,.08);--radius:12px}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--font);color:var(--text);background:var(--bg);min-height:100vh}

.topbar{background:linear-gradient(135deg,var(--primary-dark),var(--primary));padding:0 28px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 12px rgba(0,0,0,.15);height:60px;position:sticky;top:0;z-index:100}
.topbar h1{font-size:18px;color:#fff;font-family:var(--font-h);display:flex;align-items:center;gap:10px}
.topbar h1 span{font-size:12px;background:rgba(255,255,255,.2);padding:3px 10px;border-radius:20px;font-weight:500}
.topbar-right{display:flex;gap:16px;align-items:center}
.topbar-right a{font-size:14px;color:rgba(255,255,255,.8);text-decoration:none;font-weight:500;transition:color .2s}
.topbar-right a:hover{color:#fff}
.topbar-right .btn-logout{background:var(--accent);color:#fff!important;padding:8px 20px;border-radius:8px;font-weight:600;font-size:13px}

.container{max-width:1100px;margin:24px auto;padding:0 24px}

.welcome{background:linear-gradient(135deg,var(--primary),#2A5298);border-radius:var(--radius);padding:32px;color:#fff;margin-bottom:24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px}
.welcome h2{font-family:var(--font-h);font-size:22px;margin-bottom:4px}
.welcome p{opacity:.85;font-size:14px}
.welcome-badge{background:rgba(255,255,255,.15);padding:8px 20px;border-radius:20px;font-size:13px;font-weight:500}

.stats-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:24px}
@media(max-width:768px){.stats-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:480px){.stats-grid{grid-template-columns:1fr}}

.stat-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:20px;text-align:center;box-shadow:var(--shadow);transition:transform .2s,box-shadow .2s;position:relative;overflow:hidden}
.stat-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(27,58,107,.1)}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
.stat-total::before{background:var(--primary)}
.stat-open::before{background:var(--warning)}
.stat-progress::before{background:var(--info)}
.stat-replied::before{background:var(--purple)}
.stat-closed::before{background:var(--success)}
.stat-number{font-size:28px;font-weight:700;font-family:var(--font-h);margin-bottom:4px}
.stat-total .stat-number{color:var(--primary)}
.stat-open .stat-number{color:var(--warning)}
.stat-progress .stat-number{color:var(--info)}
.stat-replied .stat-number{color:var(--purple)}
.stat-closed .stat-number{color:var(--success)}
.stat-label{font-size:12px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px}

.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:24px}
@media(max-width:768px){.grid-2{grid-template-columns:1fr}}

.card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:24px;box-shadow:var(--shadow)}
.card h3{font-family:var(--font-h);font-size:16px;margin-bottom:16px;color:var(--primary-dark);display:flex;align-items:center;gap:8px}

.form-group{margin-bottom:14px}
.form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:5px;color:#555}
.form-group input,.form-group textarea{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:8px;font-size:14px;font-family:var(--font);transition:border-color .2s,box-shadow .2s}
.form-group textarea{min-height:100px;resize:vertical}
.form-group input:focus,.form-group textarea:focus{outline:none;border-color:var(--primary-mid);box-shadow:0 0 0 3px rgba(74,144,217,.12)}

.btn{padding:10px 24px;border:none;border-radius:8px;font-weight:600;font-size:14px;cursor:pointer;transition:all .2s;font-family:var(--font)}
.btn-primary{background:linear-gradient(135deg,var(--primary),#2A5298);color:#fff}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(27,58,107,.3)}

.badge{padding:4px 12px;border-radius:20px;font-size:11px;font-weight:700;display:inline-block;text-transform:uppercase;letter-spacing:.3px}
.badge-open{background:#FFF3CD;color:#856404}
.badge-progress{background:#CCE5FF;color:#004085}
.badge-replied{background:#E8DAEF;color:#6C3483}
.badge-closed{background:#D5F5E3;color:#1E8449}

.empty{text-align:center;padding:40px 24px;color:var(--muted);font-size:14px}

.reply-box{background:linear-gradient(135deg,#F0F4FF,#E8F0FE);border-left:3px solid var(--primary-mid);padding:14px 18px;border-radius:0 10px 10px 0;margin-top:10px}
.reply-box .reply-header{font-size:11px;font-weight:700;color:var(--primary-mid);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px}
.reply-box .reply-text{font-size:13px;color:var(--text);line-height:1.6}
.reply-box .reply-date{font-size:11px;color:var(--muted);margin-top:6px}

.no-reply{font-size:12px;color:var(--muted);font-style:italic;padding:8px 0}

.complaint-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:16px;box-shadow:var(--shadow);transition:transform .2s}
.complaint-card:hover{transform:translateY(-2px)}
.complaint-header{display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:8px}
.complaint-header h4{font-size:15px;font-weight:600;color:var(--text);margin:0}
.complaint-meta{font-size:12px;color:var(--muted);margin-bottom:8px}
.complaint-message{font-size:13px;color:#666;line-height:1.6;margin-bottom:10px}

.quick-actions{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:16px}
.quick-action{display:flex;align-items:center;gap:10px;padding:14px;border:1px solid var(--border);border-radius:10px;text-decoration:none;color:var(--text);font-size:13px;font-weight:500;transition:all .2s}
.quick-action:hover{border-color:var(--primary-mid);background:#F8FAFF;transform:translateY(-1px)}
.quick-action-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.quick-action-icon.blue{background:#EBF5FF;color:#3B82F6}
.quick-action-icon.green{background:#E8F8EF;color:var(--success)}
.quick-action-icon.purple{background:#F3EEFF;color:var(--purple)}
</style>
</head>
<body>

<div class="topbar">
  <h1>CRM Software Nepal <span>My Account</span></h1>
  <div class="topbar-right">
    <a href="<?= site_url('/') ?>">Home</a>
    <a href="<?= site_url('user/dashboard') ?>">Dashboard</a>
    <a href="<?= site_url('user/logout') ?>" class="btn-logout">Logout</a>
  </div>
</div>

<div class="container">
  <?php if (session()->getFlashdata('success')): ?>
    <div style="background:#D5F5E3;color:#1E8449;padding:12px 18px;border-radius:8px;margin-bottom:16px;font-size:14px;border:1px solid #C8E6C9;">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div style="background:#FDECEA;color:var(--accent);padding:12px 18px;border-radius:8px;margin-bottom:16px;font-size:14px;border:1px solid #F5C6CB;">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <div class="welcome">
    <div>
      <h2>Welcome back, <?= esc($userName) ?>! &#128075;</h2>
      <p><?= esc($userEmail) ?> — Here's your account overview.</p>
    </div>
    <div class="welcome-badge"><?= date('l, M d, Y') ?></div>
  </div>

  <div class="stats-grid">
    <div class="stat-card stat-total">
      <div class="stat-number"><?= $totalComplaints ?></div>
      <div class="stat-label">Total</div>
    </div>
    <div class="stat-card stat-open">
      <div class="stat-number"><?= $openComplaints ?></div>
      <div class="stat-label">Open</div>
    </div>
    <div class="stat-card stat-progress">
      <div class="stat-number"><?= $inProgressComplaints ?></div>
      <div class="stat-label">In Progress</div>
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
      <h3>&#128221; Submit a Complaint</h3>
      <form method="POST" action="<?= site_url('complaint/submit') ?>">
        <?= csrf_field() ?>
        <div class="form-group">
          <label>Subject</label>
          <input type="text" name="subject" placeholder="Brief description of your issue" required>
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea name="message" placeholder="Describe your issue in detail..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Complaint</button>
      </form>

      <div class="quick-actions">
        <a href="<?= site_url('contact-us') ?>" class="quick-action">
          <div class="quick-action-icon blue">&#9993;</div>
          <span>Contact Support</span>
        </a>
        <a href="<?= site_url('faq') ?>" class="quick-action">
          <div class="quick-action-icon green">&#10067;</div>
          <span>FAQ</span>
        </a>
        <a href="<?= site_url('features') ?>" class="quick-action">
          <div class="quick-action-icon purple">&#128161;</div>
          <span>Features</span>
        </a>
      </div>
    </div>

    <div class="card">
      <h3>&#128203; My Complaints</h3>
      <?php if (empty($allComplaints)): ?>
        <div class="empty">
          <div style="font-size:32px;margin-bottom:12px;">&#128196;</div>
          No complaints yet.<br>Submit one using the form.
        </div>
      <?php else: ?>
        <?php foreach ($allComplaints as $c): ?>
          <div class="complaint-card">
            <div class="complaint-header">
              <h4><?= esc($c->subject) ?></h4>
              <?php
              $cls = 'badge-closed';
              if ($c->status === 'Open') $cls = 'badge-open';
              elseif ($c->status === 'In Progress') $cls = 'badge-progress';
              elseif ($c->status === 'Replied') $cls = 'badge-replied';
              ?>
              <span class="badge <?= $cls ?>"><?= esc($c->status) ?></span>
            </div>
            <div class="complaint-meta">
              Submitted <?= date('M d, Y \a\t g:i A', strtotime($c->created_at)) ?>
            </div>
            <?php if (!empty($c->message)): ?>
              <div class="complaint-message"><?= nl2br(esc($c->message)) ?></div>
            <?php endif; ?>
            <?php if (!empty($c->admin_reply)): ?>
              <div class="reply-box">
                <div class="reply-header">&#128172; Admin Reply</div>
                <div class="reply-text"><?= nl2br(esc($c->admin_reply)) ?></div>
                <?php if (!empty($c->replied_at)): ?>
                  <div class="reply-date">Replied <?= date('M d, Y \a\t g:i A', strtotime($c->replied_at)) ?></div>
                <?php endif; ?>
              </div>
            <?php else: ?>
              <div class="no-reply">&#8987; Awaiting admin response...</div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
