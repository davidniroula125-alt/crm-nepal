<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
    .chart-card canvas { max-height: 300px; }
    @media (max-width: 1024px) { .charts-row { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <h2>Sales Report</h2>
    <a href="<?= base_url('/admin/reports') ?>" class="btn btn-outline btn-sm">&#8592; All Reports</a>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/reports/sales') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <label class="form-label mb-0" style="white-space:nowrap;">Date Range:</label>
        <input type="date" name="start_date" value="<?= esc($startDate) ?>" class="form-control" style="width:180px;">
        <span style="color:var(--color-text-muted);">to</span>
        <input type="date" name="end_date" value="<?= esc($endDate) ?>" class="form-control" style="width:180px;">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="<?= base_url('/admin/reports/sales') ?>" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon teal">&#128200;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalLeads) ?></span>
            <span class="kpi-label">Total Leads</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#10003;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($convertedLeads) ?></span>
            <span class="kpi-label">Converted</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon blue">&#37;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($conversionRate) ?>%</span>
            <span class="kpi-label">Conversion Rate</span>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Conversions Over Time</h3>
        </div>
        <div class="chart-container">
            <canvas id="conversionsChart"></canvas>
        </div>
    </div>
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Pipeline by Status</h3>
        </div>
        <div class="chart-container">
            <canvas id="pipelineChart"></canvas>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Converted Leads (<?= esc($startDate) ?> to <?= esc($endDate) ?>)</h3>
    </div>
    <?php if (empty($leads)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">&#10003;</div>
            <h3>No conversions found</h3>
            <p>No leads were converted in the selected date range.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Source</th>
                        <th>Assigned To</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td><?= esc($lead->id) ?></td>
                            <td><?= esc($lead->full_name) ?></td>
                            <td><?= esc($lead->company_name ?? '-') ?></td>
                            <td><?= esc($lead->source) ?></td>
                            <td><?= esc($lead->assigned_to_name ?? 'Unassigned') ?></td>
                            <td><?= date('M d, Y', strtotime($lead->created_at)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var colors = {
        teal: '#0F6E63', accent: '#F2994A', success: '#2E9E5B',
        danger: '#D64545', warning: '#E0A72E', blue: '#3B82F6',
        purple: '#8B5CF6', pink: '#EC4899', gray: '#6B7280'
    };
    var statusColorMap = {
        'New': colors.success, 'Contacted': colors.blue,
        'Qualified': colors.warning, 'Converted': colors.teal, 'Lost': colors.danger
    };

    // Conversions Over Time
    var convLabels = <?= json_encode($conversionLabels) ?>;
    var convData = <?= json_encode($conversionData) ?>;
    new Chart(document.getElementById('conversionsChart'), {
        type: 'line',
        data: {
            labels: convLabels,
            datasets: [{
                label: 'Conversions',
                data: convData,
                borderColor: colors.success,
                backgroundColor: 'rgba(46,158,91,0.1)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: colors.success,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }
        }
    });

    // Pipeline by Status
    var pipeLabels = <?= json_encode($pipelineLabels) ?>;
    var pipeData = <?= json_encode($pipelineData) ?>;
    new Chart(document.getElementById('pipelineChart'), {
        type: 'bar',
        data: {
            labels: pipeLabels,
            datasets: [{
                label: 'Leads',
                data: pipeData,
                backgroundColor: pipeLabels.map(function (l) { return statusColorMap[l] || colors.gray; }),
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }
        }
    });
});
</script>

<?= $this->endSection() ?>
