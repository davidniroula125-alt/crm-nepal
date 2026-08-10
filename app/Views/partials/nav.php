<header class="site-header">
    <div class="navbar">
        <a href="<?= site_url('/') ?>" class="navbar__logo">
            <img src="/assets/images/logo.png" alt="CRM Software Nepal" height="44">
        </a>
        <nav class="navbar__links" id="navLinks">
            <a href="<?= site_url('/') ?>">Home</a>
            <a href="<?= site_url('about-us') ?>">About Us</a>
            <a href="<?= site_url('features') ?>">Features</a>
            <a href="<?= site_url('solutions') ?>">Solutions</a>
            <a href="<?= site_url('pricing') ?>">Pricing</a>
            <a href="<?= site_url('blog') ?>">Blog</a>
            <a href="<?= site_url('contact-us') ?>">Contact Us</a>
            <?php if (session()->get('user_id')): ?>
                <?php if (in_array(session()->get('user_role'), ['admin', 'editor'])): ?>
                    <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-primary">Admin Dashboard</a>
                <?php else: ?>
                    <a href="<?= site_url('user/dashboard') ?>" class="btn btn-primary">My Dashboard</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= site_url('user/login') ?>" style="font-weight:600;">Log In</a>
                <a href="<?= site_url('user/signup') ?>" class="btn btn-primary">Sign Up</a>
            <?php endif; ?>
        </nav>
        <button class="navbar__toggle" id="navToggle" aria-label="Toggle menu">&#9776;</button>
    </div>
</header>
