<?= view('layout/auth', ['title' => 'Login']) ?>

<div class="auth-form-container">
    <h2 class="auth-title">Sign In</h2>
    <p class="auth-subtitle">Welcome back! Please enter your credentials.</p>
    
    <?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <?= esc($error) ?>
    </div>
    <?php endif; ?>
    
    <form method="POST" action="/login" class="auth-form">
        <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-wrapper">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input type="email" id="email" name="email" required placeholder="you@example.com">
            </div>
        </div>
        
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary btn-full">
            Sign In
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
    </form>
    
    <div class="auth-footer">
        <p>Don't have an account? <a href="/signup">Create one</a></p>
    </div>
</div>

<?= view('layout/auth_footer') ?>
