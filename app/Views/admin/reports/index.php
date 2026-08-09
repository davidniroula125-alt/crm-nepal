<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-top: 12px;
    }
    .report-card {
        background: var(--color-bg);
        border: 1px solid var(--color-border);
        border-radius: var(--radius-md);
        padding: 28px 24px;
        text-decoration: none;
        color: var(--color-text);
        transition: transform .2s, box-shadow .2s, border-color .2s;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
    }
    .report-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-primary);
    }
    .report-card-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        flex-shrink: 0;
    }
    .report-card-icon.teal { background: var(--color-primary); }
    .report-card-icon.green { background: var(--color-success); }
    .report-card-icon.orange { background: var(--color-accent); }
    .report-card-icon.blue { background: #3B82F6; }
    .report-card-icon.red { background: var(--color-danger); }
    .report-card-icon.purple { background: #8B5CF6; }
    .report-card-title {
        font-size: 1.1rem;
        font-weight: 700;
    }
    .report-card-desc {
        font-size: .88rem;
        color: var(--color-text-muted);
        line-height: 1.5;
    }
    .report-card-arrow {
        font-size: 1.2rem;
        color: var(--color-primary);
        margin-top: auto;
    }
</style>

<div class="page-header">
    <h2>Reports</h2>
</div>

<div class="report-grid">
    <a href="<?= base_url('/admin/reports/leads') ?>" class="report-card">
        <div class="report-card-icon teal">&#9733;</div>
        <div class="report-card-title">Lead Reports</div>
        <div class="report-card-desc">Track lead sources, statuses, conversion rates, and pipeline performance over time.</div>
        <div class="report-card-arrow">&#8594;</div>
    </a>

    <a href="<?= base_url('/admin/reports/sales') ?>" class="report-card">
        <div class="report-card-icon green">&#8599;</div>
        <div class="report-card-title">Sales Reports</div>
        <div class="report-card-desc">Monitor sales pipeline, conversion trends, and deal closure performance.</div>
        <div class="report-card-arrow">&#8594;</div>
    </a>

    <a href="<?= base_url('/admin/reports/revenue') ?>" class="report-card">
        <div class="report-card-icon orange">&#36;</div>
        <div class="report-card-title">Revenue Reports</div>
        <div class="report-card-desc">Analyze total revenue, monthly averages, and revenue breakdown by subscription plan.</div>
        <div class="report-card-arrow">&#8594;</div>
    </a>

    <a href="<?= base_url('/admin/reports/payments') ?>" class="report-card">
        <div class="report-card-icon blue">&#128179;</div>
        <div class="report-card-title">Payment Reports</div>
        <div class="report-card-desc">View payment collection status, pending amounts, overdue invoices, and trends.</div>
        <div class="report-card-arrow">&#8594;</div>
    </a>

    <a href="<?= base_url('/admin/reports/clients') ?>" class="report-card">
        <div class="report-card-icon purple">&#128101;</div>
        <div class="report-card-title">Client Reports</div>
        <div class="report-card-desc">Track client acquisition, active vs inactive clients, and growth over time.</div>
        <div class="report-card-arrow">&#8594;</div>
    </a>

    <a href="<?= base_url('/admin/reports/staff') ?>" class="report-card">
        <div class="report-card-icon red">&#128202;</div>
        <div class="report-card-title">Staff Performance</div>
        <div class="report-card-desc">Compare team performance by leads assigned, conversions, and revenue generated.</div>
        <div class="report-card-arrow">&#8594;</div>
    </a>
</div>

<?= $this->endSection() ?>
