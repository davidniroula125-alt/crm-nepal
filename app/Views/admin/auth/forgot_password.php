<?= $this->extend('admin/layouts/login') ?>

<?= $this->section('content') ?>

<div class="login-brand">
  <h1>CRM <span>Nepal</span></h1>
  <p>Reset Your Password</p>
</div>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<p style="font-size: 14px; color: var(--color-text-muted); margin-bottom: 20px; text-align: center;">
  Enter your email address and we'll send you a link to reset your password.
</p>

<form method="POST" action="<?= site_url('admin/forgot-password') ?>">
  <?= csrf_field() ?>

  <div class="form-group">
    <label for="email">Email Address</label>
    <input type="email"
           id="email"
           name="email"
           class="form-control"
           value="<?= esc(old('email')) ?>"
           placeholder="admin@crmsoftwarenepal.com"
           required
           autofocus>
  </div>

  <button type="submit" class="btn btn-primary">Send Reset Link</button>
</form>

<div class="login-links">
  <a href="<?= site_url('admin/login') ?>">&larr; Back to Login</a>
</div>

<?= $this->endSection() ?>
