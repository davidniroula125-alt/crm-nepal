<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="hero" style="text-align:center;">
    <div class="container">
        <h1><?= esc($pageContent['hero']['headline'] ?? 'Powerful CRM Features for Travel Agencies') ?></h1>
        <p style="max-width:620px;margin:0 auto 28px;"><?= esc($pageContent['hero']['subtext'] ?? 'Every module built specifically for travel, trekking and tour businesses in Nepal.') ?></p>
        <div class="hero__ctas" style="justify-content:center;">
            <a href="<?= site_url('request-a-demo') ?>" class="btn btn-primary btn-lg">Request a Demo</a>
            <a href="<?= site_url('pricing') ?>" class="btn btn-outline btn-lg">View Pricing</a>
        </div>
    </div>
</section>

<?php
$features = [
    'lead_management'     => ['Lead Management', 'Capture every inquiry from your website, phone, social media and walk-ins — then never let one slip through the cracks.'],
    'customer_management' => ['Customer Management', 'A single profile for every traveler — past trips, upcoming bookings, documents and communication history in one place.'],
    'sales_management'    => ['Sales Management', 'Track every deal from first inquiry to signed booking — visualize your pipeline and forecast revenue with confidence.'],
    'inquiry_management'  => ['Inquiry Management', 'Respond to every inquiry faster with centralized tracking and automated routing across all channels.'],
    'tour_management'     => ['Tour / Travel Management', 'Manage every trip — from itinerary creation to on-ground execution — with full visibility for your whole team.'],
    'payment_management'  => ['Payment Management', 'Track deposits, installments and final payments — never lose sight of what\'s owed or overdue.'],
    'reporting'           => ['Reporting & Analytics', 'Make data-driven decisions with real-time dashboards and customizable reports across your entire business.'],
];

$alt = false;
foreach ($features as $key => $fallback):
    $title = $pageContent[$key]['headline'] ?? $fallback[0];
    $desc  = $pageContent[$key]['description'] ?? $fallback[1];
?>
<section class="section<?= $alt ? ' section-alt' : '' ?>">
    <div class="container" style="max-width:820px;">
        <div class="section__head" style="text-align:left;max-width:none;">
            <h2><?= esc($title) ?></h2>
            <p><?= esc($desc) ?></p>
        </div>
    </div>
</section>
<?php $alt = !$alt; endforeach; ?>

<section class="section">
    <div class="cta-band">
        <h2>Ready to get started?</h2>
        <p>Book a free demo and see how CRM Software Nepal can transform your travel business.</p>
        <a href="<?= site_url('request-a-demo') ?>" class="btn btn-outline btn-lg">Request a Demo</a>
    </div>
</section>

<?= $this->endSection() ?>
