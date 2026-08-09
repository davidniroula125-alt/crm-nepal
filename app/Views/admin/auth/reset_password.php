<?= $this->extend('admin/layouts/login') ?>

<?= $this->section('content') ?>

<div class="login-brand">
  <h1>CRM <span>Nepal</span></h1>
  <p>Set New Password</p>
</div>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="POST" action="<?= site_url('admin/reset-password') ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">

  <div class="form-group">
    <label for="password">New Password</label>
    <input type="password"
           id="password"
           name="password"
           class="form-control"
           placeholder="Minimum 8 characters"
           required
           autofocus
           minlength="8">
  </div>

  <div class="form-group">
    <label for="password_confirm">Confirm Password</label>
    <input type="password"
           id="password_confirm"
           name="password_confirm"
           class="form-control"
           placeholder="Re-enter your new password"
           required
           minlength="8">
  </div>

  <button type="submit" class="btn btn-primary">Reset Password</button>
</form>

<div class="login-links">
  <a href="<?= site_url('admin/login') ?>">&larr; Back to Login</a>
</div>

<?= $this->endSection() ?>
