<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
    .chart-card canvas { max-height: 300px; }
    @media (max-width: 1024px) { .charts-row { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <h2>Revenue Report</h2>
    <a href="<?= base_url('/admin/reports') ?>" class="btn btn-outline btn-sm">&#8592; All Reports</a>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/reports/revenue') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <label class="form-label mb-0" style="white-space:nowrap;">Date Range:</label>
        <input type="date" name="start_date" value="<?= esc($startDate) ?>" class="form-control" style="width:180px;">
        <span style="color:var(--color-text-muted);">to</span>
        <input type="date" name="end_date" value="<?= esc($endDate) ?>" class="form-control" style="width:180px;">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="<?= base_url('/admin/reports/revenue') ?>" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon green">&#36;</div>
        <div class="kpi-info">
            <span class="kpi-value">NPR <?= number_format($totalRevenue, 0) ?></span>
            <span class="kpi-label">Total Revenue</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon teal">&#36;</div>
        <div class="kpi-info">
            <span class="kpi-value">NPR <?= number_format($monthlyAvg, 0) ?></span>
            <span class="kpi-label">Monthly Average</span>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Revenue Over Time</h3>
        </div>
        <div class="chart-container" style="min-height:300px;">
            <canvas id="revenueLineChart"></canvas>
        </div>
    </div>
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Revenue by Plan</h3>
        </div>
        <div class="chart-container">
            <canvas id="revenuePlanChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var colors = {
        teal: '#0F6E63', accent: '#F2994A', success: '#2E9E5B',
        danger: '#D64545', warning: '#E0A72E', blue: '#3B82F6',
        purple: '#8B5CF6', pink: '#EC4899', gray: '#6B7280'
    };
    var planColors = [colors.teal, colors.accent, colors.blue, colors.success, colors.purple, colors.pink, colors.danger, colors.warning, colors.gray, '#14B8A6'];

    // Revenue Over Time
    var revLabels = <?= json_encode($revenueLabels) ?>;
    var revData = <?= json_encode($revenueData) ?>;
    new Chart(document.getElementById('revenueLineChart'), {
        type: 'line',
        data: {
            labels: revLabels,
            datasets: [{
                label: 'Revenue (NPR)',
                data: revData,
                borderColor: colors.teal,
                backgroundColor: 'rgba(15,110,99,0.1)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: colors.teal,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: function (ctx) { return 'NPR ' + ctx.parsed.y.toLocaleString(); } } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { callback: function (val) { return 'NPR ' + val.toLocaleString(); } } },
                x: { grid: { display: false } }
            }
        }
    });

    // Revenue by Plan
    var planLabels = <?= json_encode($planLabels) ?>;
    var planData = <?= json_encode($planData) ?>;
    new Chart(document.getElementById('revenuePlanChart'), {
        type: 'pie',
        data: {
            labels: planLabels,
            datasets: [{
                data: planData,
                backgroundColor: planLabels.map(function (_, i) { return planColors[i % planColors.length]; }),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11 } } },
                tooltip: { callbacks: { label: function (ctx) { return ctx.label + ': NPR ' + ctx.parsed.toLocaleString(); } } }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
