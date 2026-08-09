<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="hero" style="text-align:center;">
    <div class="container">
        <h1>CRM Solutions for Every Travel Business</h1>
        <p style="max-width:600px;margin:0 auto 28px;">Whether you run a small trekking outfit or a large DMC, CRM Software Nepal adapts to your workflow.</p>
        <div class="hero__ctas" style="justify-content:center;">
            <a href="<?= site_url('request-a-demo') ?>" class="btn btn-primary btn-lg">Request a Demo</a>
            <a href="<?= site_url('pricing') ?>" class="btn btn-outline btn-lg">View Pricing</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="features-grid" style="grid-template-columns:1fr 1fr;">

            <!-- Travel Agencies -->
            <div class="feature-card" style="padding:32px;">
                <div class="feature-card__icon">T</div>
                <h3>Travel Agencies</h3>
                <p style="color:var(--color-text-muted);margin-bottom:16px;">Manage your entire agency workflow — from first inquiry to post-trip follow-up — in a single platform built for Nepal's travel industry.</p>
                <ul>
                    <li>Capture leads from website, phone, walk-ins and social media</li>
                    <li>Build and send quotations with itinerary details</li>
                    <li>Track bookings, payments and outstanding balances</li>
                    <li>Manage customer profiles with travel history and preferences</li>
                    <li>Automated follow-up reminders for seasonal promotions</li>
                    <li>Performance reports by agent and lead source</li>
                </ul>
            </div>

            <!-- Trekking Agencies -->
            <div class="feature-card" style="padding:32px;">
                <div class="feature-card__icon">K</div>
                <h3>Trekking Agencies</h3>
                <p style="color:var(--color-text-muted);margin-bottom:16px;">Purpose-built for the unique needs of trekking operators — group management, guide assignments, gear tracking and permit coordination.</p>
                <ul>
                    <li>Manage group treks with traveler manifests and itineraries</li>
                    <li>Assign guides, porters and equipment to each trek</li>
                    <li>Track permits, insurance and medical requirements</li>
                    <li>Handle altitude-related safety information per trekker</li>
                    <li>Manage seasonal availability and departure calendars</li>
                    <li>Collect and analyze post-trek feedback</li>
                </ul>
            </div>

            <!-- Tour Operators -->
            <div class="feature-card" style="padding:32px;">
                <div class="feature-card__icon">O</div>
                <h3>Tour Operators</h3>
                <p style="color:var(--color-text-muted);margin-bottom:16px;">Full control over tour packages, multi-day itineraries, hotel and transport bookings with real-time availability tracking.</p>
                <ul>
                    <li>Create and manage tour packages with day-by-day plans</li>
                    <li>Track hotel, flight and activity bookings in one view</li>
                    <li>Multi-currency invoicing for international clients</li>
                    <li>Manage special requests: dietary, accessibility, celebrations</li>
                    <li>Seasonal pricing and early-bird discount management</li>
                    <li>Real-time availability calendar for all packages</li>
                </ul>
            </div>

            <!-- DMCs -->
            <div class="feature-card" style="padding:32px;">
                <div class="feature-card__icon">D</div>
                <h3>Destination Management Companies</h3>
                <p style="color:var(--color-text-muted);margin-bottom:16px;">Coordinate across multiple partner agencies, suppliers and sub-contractors with centralized booking and communication management.</p>
                <ul>
                    <li>Manage multiple partner agencies and commission structures</li>
                    <li>Centralized supplier and sub-contractor database</li>
                    <li>Group and FIT booking management side by side</li>
                    <li>Real-time inventory and availability sharing with partners</li>
                    <li>Consolidated invoicing and payment reconciliation</li>
                    <li>Performance reporting by partner, route and season</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- CTA -->
<section class="section section-alt">
    <div class="cta-band">
        <h2>Not sure which solution fits your business?</h2>
        <p>Talk to our team — we'll help you find the right CRM setup for your specific needs.</p>
        <a href="<?= site_url('contact-us') ?>" class="btn btn-outline btn-lg">Contact Us</a>
    </div>
</section>

<?= $this->endSection() ?>
