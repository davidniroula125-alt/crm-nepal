<footer class="footer">
    <div class="container footer__grid">
        <div class="footer__brand">
            <img src="<?= base_url('assets/images/logo.svg') ?>" alt="CRM Software Nepal" height="36" style="filter:brightness(2);margin-bottom:12px;">
            <p><?= esc($footerDesc ?? 'CRM Software Nepal helps travel agencies, trekking agencies, tour operators and DMCs manage leads, customers, bookings, payments and follow-ups in one place.') ?></p>
        </div>
        <div class="footer__col">
            <h4>Company</h4>
            <a href="<?= site_url('about-us') ?>">About Us</a>
            <a href="<?= site_url('contact-us') ?>">Contact</a>
            <a href="#">Careers</a>
        </div>
        <div class="footer__col">
            <h4>Product</h4>
            <a href="<?= site_url('features') ?>">Features</a>
            <a href="<?= site_url('pricing') ?>">Pricing</a>
            <a href="<?= site_url('solutions') ?>">Solutions</a>
            <a href="<?= site_url('request-a-demo') ?>">Demo</a>
        </div>
        <div class="footer__col">
            <h4>Resources</h4>
            <a href="<?= site_url('blog') ?>">Blog</a>
            <a href="<?= site_url('faq') ?>">FAQ</a>
            <?php if (session()->get('user_id')): ?>
                <?php if (in_array(session()->get('user_role'), ['admin', 'editor'])): ?>
                    <a href="<?= site_url('admin/dashboard') ?>">Admin Dashboard</a>
                <?php else: ?>
                    <a href="<?= site_url('user/dashboard') ?>">My Dashboard</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= site_url('user/login') ?>">Log In</a>
                <a href="<?= site_url('user/signup') ?>">Sign Up</a>
            <?php endif; ?>
        </div>
        <div class="footer__col">
            <h4>Contact</h4>
            <a href="#"><?= esc($siteAddress ?? 'Kathmandu, Nepal') ?></a>
            <a href="mailto:<?= esc($siteEmail ?? 'info@crmsoftwarenepal.com') ?>"><?= esc($siteEmail ?? 'info@crmsoftwarenepal.com') ?></a>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <p>&copy; <?= date('Y') ?> <?= esc($copyright ?? 'CRM Software Nepal. All rights reserved.') ?></p>
            <div>
                <a href="<?= site_url('privacy-policy') ?>">Privacy Policy</a>
                <a href="<?= site_url('terms-and-conditions') ?>">Terms</a>
                <a href="<?= site_url('refund-policy') ?>">Refund Policy</a>
                <a href="<?= site_url('cookie-policy') ?>">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>
