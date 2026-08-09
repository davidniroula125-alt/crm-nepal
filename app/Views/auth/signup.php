<?= view('layout/auth', ['title' => 'Signup']) ?>

<div class="auth-form-container">
    <h2 class="auth-title">Create Account</h2>
    <p class="auth-subtitle">Start your CRM journey with CRM Nepal.</p>
    
    <?php if (!empty($error)): ?>
    <div class="alert alert-error">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <?= esc($error) ?>
    </div>
    <?php endif; ?>
    
    <form method="POST" action="/signup" class="auth-form">
        <div class="form-group">
            <label for="name">Full Name</label>
            <div class="input-wrapper">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <input type="text" id="name" name="name" required placeholder="Your full name">
            </div>
        </div>
        
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <div class="input-wrapper">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/></svg>
                <input type="text" id="company_name" name="company_name" required placeholder="Your company name">
            </div>
        </div>
        
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
                <input type="password" id="password" name="password" required minlength="6" placeholder="Create a password">
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary btn-full">
            Create Account
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
    </form>
    
    <div class="auth-footer">
        <p>Already have an account? <a href="/login">Sign in</a></p>
    </div>
</div>

<?= view('layout/auth_footer') ?>
