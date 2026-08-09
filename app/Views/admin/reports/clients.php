<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
    .chart-card canvas { max-height: 300px; }
    @media (max-width: 1024px) { .charts-row { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <h2>Client Report</h2>
    <a href="<?= base_url('/admin/reports') ?>" class="btn btn-outline btn-sm">&#8592; All Reports</a>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/reports/clients') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <label class="form-label mb-0" style="white-space:nowrap;">Date Range:</label>
        <input type="date" name="start_date" value="<?= esc($startDate) ?>" class="form-control" style="width:180px;">
        <span style="color:var(--color-text-muted);">to</span>
        <input type="date" name="end_date" value="<?= esc($endDate) ?>" class="form-control" style="width:180px;">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="<?= base_url('/admin/reports/clients') ?>" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon teal">&#128101;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalClients) ?></span>
            <span class="kpi-label">Total Clients</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#10003;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($activeClients) ?></span>
            <span class="kpi-label">Active Clients</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon red">&#10005;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($inactiveClients) ?></span>
            <span class="kpi-label">Inactive Clients</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon blue">&#43;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($newClients) ?></span>
            <span class="kpi-label">New This Period</span>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Clients Over Time</h3>
        </div>
        <div class="chart-container" style="min-height:300px;">
            <canvas id="clientsOverTimeChart"></canvas>
        </div>
    </div>
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Client Status Breakdown</h3>
        </div>
        <div class="chart-container">
            <canvas id="clientStatusChart"></canvas>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Clients Added (<?= esc($startDate) ?> to <?= esc($endDate) ?>)</h3>
    </div>
    <?php if (empty($clients)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">&#128101;</div>
            <h3>No clients found</h3>
            <p>No clients were added in the selected date range.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= esc($client->id) ?></td>
                            <td><?= esc($client->company_name) ?></td>
                            <td><?= esc($client->contact_name) ?></td>
                            <td><?= esc($client->email ?? '-') ?></td>
                            <td>
                                <span class="badge <?= $client->status === 'Active' ? 'badge-success' : 'badge-danger' ?>">
                                    <?= esc(ucfirst($client->status)) ?>
                                </span>
                            </td>
                            <td><?= date('M d, Y', strtotime($client->created_at)) ?></td>
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
        teal: '#0F6E63', success: '#2E9E5B', danger: '#D64545',
        blue: '#3B82F6', gray: '#6B7280'
    };

    // Clients Over Time
    var clientLabels = <?= json_encode($clientLabels) ?>;
    var clientData = <?= json_encode($clientData) ?>;
    new Chart(document.getElementById('clientsOverTimeChart'), {
        type: 'line',
        data: {
            labels: clientLabels,
            datasets: [{
                label: 'New Clients',
                data: clientData,
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

    // Client Status Breakdown
    var statusLabels = <?= json_encode($statusLabels) ?>;
    var statusData = <?= json_encode($statusData) ?>;
    var statusBg = [colors.success, colors.danger, colors.gray, colors.blue];

    new Chart(document.getElementById('clientStatusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: statusBg.slice(0, statusLabels.length),
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
});
</script>

<?= $this->endSection() ?>
