<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
    .chart-card canvas { max-height: 300px; }
    @media (max-width: 1024px) { .charts-row { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <h2>Lead Report</h2>
    <a href="<?= base_url('/admin/reports') ?>" class="btn btn-outline btn-sm">&#8592; All Reports</a>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/reports/leads') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <label class="form-label mb-0" style="white-space:nowrap;">Date Range:</label>
        <input type="date" name="start_date" value="<?= esc($startDate) ?>" class="form-control" style="width:180px;">
        <span style="color:var(--color-text-muted);">to</span>
        <input type="date" name="end_date" value="<?= esc($endDate) ?>" class="form-control" style="width:180px;">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="<?= base_url('/admin/reports/leads') ?>" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon teal">&#9733;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalLeads) ?></span>
            <span class="kpi-label">Total Leads</span>
        </div>
    </div>
    <?php
    $statusColors = [
        'New' => 'green', 'Contacted' => 'blue', 'Qualified' => 'orange',
        'Converted' => 'teal', 'Lost' => 'red',
    ];
    foreach ($statusLabels as $i => $label):
        $color = $statusColors[$label] ?? 'teal';
    ?>
    <div class="kpi-card">
        <div class="kpi-icon <?= $color ?>"><?= esc($statusData[$i]) ?></div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($statusData[$i]) ?></span>
            <span class="kpi-label"><?= esc($label) ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="charts-row">
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Leads by Status</h3>
        </div>
        <div class="chart-container">
            <canvas id="leadsByStatusChart"></canvas>
        </div>
    </div>
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Leads by Source</h3>
        </div>
        <div class="chart-container">
            <canvas id="leadsBySourceChart"></canvas>
        </div>
    </div>
</div>

<div class="admin-card chart-card mb-3">
    <div class="admin-card-header">
        <h3>Leads Over Time</h3>
    </div>
    <div class="chart-container" style="min-height:300px;">
        <canvas id="leadsOverTimeChart"></canvas>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Leads in Period (<?= esc($startDate) ?> to <?= esc($endDate) ?>)</h3>
    </div>
    <?php if (empty($leads)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">&#9733;</div>
            <h3>No leads found</h3>
            <p>No leads were created in the selected date range.</p>
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
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leads as $lead): ?>
                        <?php
                        $statusClasses = [
                            'New' => 'badge-info', 'Contacted' => 'badge-warning',
                            'Qualified' => 'badge-purple', 'Converted' => 'badge-success',
                            'Lost' => 'badge-danger',
                        ];
                        ?>
                        <tr>
                            <td><?= esc($lead->id) ?></td>
                            <td><?= esc($lead->full_name) ?></td>
                            <td><?= esc($lead->company_name ?? '-') ?></td>
                            <td><?= esc($lead->source) ?></td>
                            <td><span class="badge <?= $statusClasses[$lead->status] ?? 'badge-info' ?>"><?= esc($lead->status) ?></span></td>
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

    var sourceColors = [colors.teal, colors.accent, colors.blue, colors.success, colors.danger, colors.purple, colors.pink, colors.warning, colors.gray, '#14B8A6'];

    // Leads by Status
    var statusLabels = <?= json_encode($statusLabels) ?>;
    var statusData = <?= json_encode($statusData) ?>;
    new Chart(document.getElementById('leadsByStatusChart'), {
        type: 'bar',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Leads',
                data: statusData,
                backgroundColor: statusLabels.map(function (l) { return statusColorMap[l] || colors.gray; }),
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

    // Leads by Source
    var sourceLabels = <?= json_encode($sourceLabels) ?>;
    var sourceData = <?= json_encode($sourceData) ?>;
    new Chart(document.getElementById('leadsBySourceChart'), {
        type: 'doughnut',
        data: {
            labels: sourceLabels,
            datasets: [{
                data: sourceData,
                backgroundColor: sourceLabels.map(function (_, i) { return sourceColors[i % sourceColors.length]; }),
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { padding: 12, usePointStyle: true, font: { size: 11 } } } },
            cutout: '55%'
        }
    });

    // Leads Over Time
    var timeLabels = <?= json_encode($timeLabels) ?>;
    var timeData = <?= json_encode($timeData) ?>;
    new Chart(document.getElementById('leadsOverTimeChart'), {
        type: 'line',
        data: {
            labels: timeLabels,
            datasets: [{
                label: 'Leads',
                data: timeData,
                borderColor: colors.teal,
                backgroundColor: 'rgba(15,110,99,0.1)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: colors.teal,
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
});
</script>

<?= $this->endSection() ?>
