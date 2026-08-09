<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .chart-card canvas { max-height: 350px; }
</style>

<div class="page-header">
    <h2>Staff Performance</h2>
    <a href="<?= base_url('/admin/reports') ?>" class="btn btn-outline btn-sm">&#8592; All Reports</a>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/reports/staff') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <label class="form-label mb-0" style="white-space:nowrap;">Date Range:</label>
        <input type="date" name="start_date" value="<?= esc($startDate) ?>" class="form-control" style="width:180px;">
        <span style="color:var(--color-text-muted);">to</span>
        <input type="date" name="end_date" value="<?= esc($endDate) ?>" class="form-control" style="width:180px;">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="<?= base_url('/admin/reports/staff') ?>" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

<div class="admin-card mb-3">
    <div class="admin-card-header">
        <h3>Performance Comparison</h3>
    </div>
    <?php if (empty($staffPerformance)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">&#128202;</div>
            <h3>No staff data</h3>
            <p>No active staff members found.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Staff Member</th>
                        <th>Leads Assigned</th>
                        <th>Leads Converted</th>
                        <th>Conversion Rate</th>
                        <th>Revenue Generated</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($staffPerformance as $staff): ?>
                        <tr>
                            <td><strong><?= esc($staff['name']) ?></strong></td>
                            <td><?= esc($staff['leadsAssigned']) ?></td>
                            <td><?= esc($staff['leadsConverted']) ?></td>
                            <td>
                                <span class="badge <?= $staff['conversionRate'] >= 50 ? 'badge-success' : ($staff['conversionRate'] >= 20 ? 'badge-warning' : 'badge-info') ?>">
                                    <?= esc($staff['conversionRate']) ?>%
                                </span>
                            </td>
                            <td>NPR <?= number_format($staff['revenue'], 0) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php if (! empty($staffNames)): ?>
<div class="admin-card chart-card mb-3">
    <div class="admin-card-header">
        <h3>Leads Assigned vs Converted</h3>
    </div>
    <div class="chart-container" style="min-height:350px;">
        <canvas id="staffPerformanceChart"></canvas>
    </div>
</div>

<div class="admin-card chart-card">
    <div class="admin-card-header">
        <h3>Revenue by Staff Member</h3>
    </div>
    <div class="chart-container" style="min-height:350px;">
        <canvas id="staffRevenueChart"></canvas>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var colors = {
        teal: '#0F6E63', accent: '#F2994A', success: '#2E9E5B',
        danger: '#D64545', blue: '#3B82F6', purple: '#8B5CF6',
        pink: '#EC4899', gray: '#6B7280'
    };

    <?php if (! empty($staffNames)): ?>
    // Leads Assigned vs Converted
    var staffNames = <?= json_encode($staffNames) ?>;
    var assignedData = <?= json_encode($assignedData) ?>;
    var convertedData = <?= json_encode($convertedData) ?>;

    new Chart(document.getElementById('staffPerformanceChart'), {
        type: 'bar',
        data: {
            labels: staffNames,
            datasets: [
                {
                    label: 'Assigned',
                    data: assignedData,
                    backgroundColor: colors.blue,
                    borderRadius: 6,
                    barPercentage: 0.6
                },
                {
                    label: 'Converted',
                    data: convertedData,
                    backgroundColor: colors.success,
                    borderRadius: 6,
                    barPercentage: 0.6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, padding: 16 } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Revenue by Staff
    var revenueData = <?= json_encode($revenueData) ?>;
    var barColors = [colors.teal, colors.accent, colors.blue, colors.success, colors.purple, colors.pink, colors.danger];

    new Chart(document.getElementById('staffRevenueChart'), {
        type: 'bar',
        data: {
            labels: staffNames,
            datasets: [{
                label: 'Revenue (NPR)',
                data: revenueData,
                backgroundColor: staffNames.map(function (_, i) { return barColors[i % barColors.length]; }),
                borderRadius: 6,
                barPercentage: 0.6
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
    <?php endif; ?>
});
</script>

<?= $this->endSection() ?>
