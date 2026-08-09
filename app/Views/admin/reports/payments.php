<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
    .chart-card canvas { max-height: 300px; }
    @media (max-width: 1024px) { .charts-row { grid-template-columns: 1fr; } }
</style>

<div class="page-header">
    <h2>Payment Report</h2>
    <a href="<?= base_url('/admin/reports') ?>" class="btn btn-outline btn-sm">&#8592; All Reports</a>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/reports/payments') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <label class="form-label mb-0" style="white-space:nowrap;">Date Range:</label>
        <input type="date" name="start_date" value="<?= esc($startDate) ?>" class="form-control" style="width:180px;">
        <span style="color:var(--color-text-muted);">to</span>
        <input type="date" name="end_date" value="<?= esc($endDate) ?>" class="form-control" style="width:180px;">
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="<?= base_url('/admin/reports/payments') ?>" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon green">&#36;</div>
        <div class="kpi-info">
            <span class="kpi-value">NPR <?= number_format($totalCollected, 0) ?></span>
            <span class="kpi-label">Total Collected</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#10003;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalPaid) ?></span>
            <span class="kpi-label">Paid</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#8987;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalPending) ?></span>
            <span class="kpi-label">Pending</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon red">&#9888;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalOverdue) ?></span>
            <span class="kpi-label">Overdue</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon blue">&#128178;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalPartial) ?></span>
            <span class="kpi-label">Partial</span>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Payment Status Breakdown</h3>
        </div>
        <div class="chart-container">
            <canvas id="paymentStatusChart"></canvas>
        </div>
    </div>
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Payments Over Time</h3>
        </div>
        <div class="chart-container" style="min-height:300px;">
            <canvas id="paymentsOverTimeChart"></canvas>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Payments in Period (<?= esc($startDate) ?> to <?= esc($endDate) ?>)</h3>
    </div>
    <?php if (empty($payments)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">&#128179;</div>
            <h3>No payments found</h3>
            <p>No payments were recorded in the selected date range.</p>
        </div>
    <?php else: ?>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Method</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment): ?>
                        <?php
                        $statusBadge = [
                            'Paid' => 'badge-success', 'Pending' => 'badge-warning',
                            'Overdue' => 'badge-danger', 'Partial' => 'badge-info',
                        ];
                        ?>
                        <tr>
                            <td><?= esc($payment->id) ?></td>
                            <td><?= esc($payment->contact_name ?? $payment->company_name ?? 'N/A') ?></td>
                            <td>NPR <?= number_format($payment->amount, 2) ?></td>
                            <td><span class="badge <?= $statusBadge[$payment->status] ?? 'badge-info' ?>"><?= esc($payment->status) ?></span></td>
                            <td><?= esc($payment->method ?? '-') ?></td>
                            <td><?= date('M d, Y', strtotime($payment->created_at)) ?></td>
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
        warning: '#E0A72E', blue: '#3B82F6', accent: '#F2994A',
        purple: '#8B5CF6', gray: '#6B7280'
    };
    var statusColors = [colors.success, colors.warning, colors.danger, colors.blue];

    // Payment Status
    var statusLabels = <?= json_encode($statusLabels) ?>;
    var statusData = <?= json_encode($statusData) ?>;
    new Chart(document.getElementById('paymentStatusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: statusColors,
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

    // Payments Over Time
    var payLabels = <?= json_encode($paymentLabels) ?>;
    var payAmounts = <?= json_encode($paymentAmounts) ?>;
    new Chart(document.getElementById('paymentsOverTimeChart'), {
        type: 'bar',
        data: {
            labels: payLabels,
            datasets: [{
                label: 'Amount (NPR)',
                data: payAmounts,
                backgroundColor: colors.teal,
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
});
</script>

<?= $this->endSection() ?>
