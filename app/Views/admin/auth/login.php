<?= $this->extend('admin/layouts/login') ?>

<?= $this->section('content') ?>

<div class="login-brand">
  <h1>CRM <span>Nepal</span></h1>
  <p>Admin Panel Login</p>
</div>

<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form method="POST" action="<?= site_url('admin/login') ?>">
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

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password"
           id="password"
           name="password"
           class="form-control"
           placeholder="Enter your password"
           required>
  </div>

  <div class="form-check">
    <input type="checkbox" id="remember" name="remember" value="1">
    <label for="remember">Remember me</label>
  </div>

  <button type="submit" class="btn btn-primary">Log In</button>
</form>

<div class="login-links">
  <a href="<?= site_url('admin/forgot-password') ?>">Forgot your password?</a>
</div>

<?= $this->endSection() ?>
