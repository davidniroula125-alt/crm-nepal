<header class="site-header">
    <div class="navbar">
        <a href="<?= site_url('/') ?>" class="navbar__logo">
            <img src="<?= base_url('assets/images/logo.svg') ?>" alt="CRM Software Nepal" height="44">
        </a>
        <nav class="navbar__links" id="navLinks">
            <a href="<?= site_url('/') ?>">Home</a>
            <a href="<?= site_url('about-us') ?>">About Us</a>
            <a href="<?= site_url('features') ?>">Features</a>
            <a href="<?= site_url('solutions') ?>">Solutions</a>
            <a href="<?= site_url('pricing') ?>">Pricing</a>
            <a href="<?= site_url('blog') ?>">Blog</a>
            <a href="<?= site_url('contact-us') ?>">Contact Us</a>
            <a href="<?= site_url('request-a-demo') ?>" class="btn btn-primary">Request a Demo</a>
        </nav>
        <button class="navbar__toggle" id="navToggle" aria-label="Toggle menu">&#9776;</button>
    </div>
</header>
