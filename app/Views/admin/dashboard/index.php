<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
    .dashboard-section { margin-bottom: 32px; }
    .dashboard-section-title {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 16px;
        color: var(--color-text);
    }
    .charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 28px; }
    .chart-card canvas { max-height: 300px; }
    .activity-list { list-style: none; padding: 0; margin: 0; }
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid var(--color-border);
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-icon {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: var(--color-primary-light);
        color: var(--color-primary);
        display: flex; align-items: center; justify-content: center;
        font-size: .95rem;
        flex-shrink: 0;
    }
    .activity-body { flex: 1; }
    .activity-body p { font-size: .88rem; margin: 0; line-height: 1.5; }
    .activity-body .activity-user { font-weight: 600; color: var(--color-primary); }
    .activity-time { font-size: .78rem; color: var(--color-text-muted); margin-top: 3px; }
    .recent-tabs { display: flex; gap: 0; border-bottom: 2px solid var(--color-border); margin-bottom: 0; }
    .recent-tab {
        padding: 10px 20px;
        font-size: .88rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        background: none;
        color: var(--color-text-muted);
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        transition: all .2s;
    }
    .recent-tab:hover { color: var(--color-primary); }
    .recent-tab.active {
        color: var(--color-primary);
        border-bottom-color: var(--color-primary);
    }
    .recent-panel { display: none; padding: 16px 0 0; }
    .recent-panel.active { display: block; }
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        font-size: .75rem;
        font-weight: 600;
        border-radius: 20px;
    }
    .status-new      { background: #E8F8EF; color: var(--color-success); }
    .status-contacted { background: var(--color-primary-light); color: var(--color-primary); }
    .status-qualified { background: #FFF8E6; color: var(--color-warning); }
    .status-converted { background: #E8F8EF; color: var(--color-success); }
    .status-lost      { background: #FDECEA; color: var(--color-danger); }
    .status-active    { background: #E8F8EF; color: var(--color-success); }
    .status-inactive  { background: #FDECEA; color: var(--color-danger); }
    .status-paid      { background: #E8F8EF; color: var(--color-success); }
    .status-pending   { background: #FFF8E6; color: var(--color-warning); }
    .status-overdue   { background: #FDECEA; color: var(--color-danger); }
    .status-read      { background: var(--color-primary-light); color: var(--color-primary); }
    .status-responded { background: #E8F8EF; color: var(--color-success); }
    .status-open      { background: var(--color-primary-light); color: var(--color-primary); }
    .revenue-highlight {
        display: inline-block;
        font-family: var(--font-heading);
        font-weight: 700;
        color: var(--color-success);
    }
    .view-all-link {
        font-size: .85rem;
        font-weight: 600;
        color: var(--color-primary);
    }
    .view-all-link:hover { text-decoration: underline; }
    @media (max-width: 1024px) {
        .charts-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .recent-tabs { overflow-x: auto; flex-wrap: nowrap; }
        .recent-tab { padding: 8px 14px; font-size: .82rem; white-space: nowrap; }
    }
</style>

<!-- ═══════════════════════════════════════════════════════════════
     KPI CARDS
     ═══════════════════════════════════════════════════════════════ -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon teal">&#9733;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalLeads) ?></span>
            <span class="kpi-label">Total Leads</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#10003;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($newLeads) ?></span>
            <span class="kpi-label">New Leads</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon blue">&#128269;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($qualifiedLeads) ?></span>
            <span class="kpi-label">Qualified Leads</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#10004;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($convertedLeads) ?></span>
            <span class="kpi-label">Converted Leads</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon teal">&#9787;</div>
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
        <div class="kpi-icon blue">&#9993;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalInquiries) ?></span>
            <span class="kpi-label">Total Inquiries</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#9993;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($newInquiries) ?></span>
            <span class="kpi-label">New Inquiries</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon teal">&#128197;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($pendingFollowUps) ?></span>
            <span class="kpi-label">Pending Follow-ups</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#9881;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($upcomingDemos) ?></span>
            <span class="kpi-label">Upcoming Demos</span>
        </div>
    </div>

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
            <span class="kpi-value revenue-highlight">NPR <?= number_format($revenueThisMonth, 0) ?></span>
            <span class="kpi-label">Revenue This Month</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#10003;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($paymentReceived) ?></span>
            <span class="kpi-label">Payments Received</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#8987;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($paymentPending) ?></span>
            <span class="kpi-label">Payments Pending</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon red">&#9888;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($overduePayments) ?></span>
            <span class="kpi-label">Overdue Payments</span>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon teal">&#10003;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($activeSubscriptions) ?></span>
            <span class="kpi-label">Active Subscriptions</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#9200;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($expiringSubscriptions) ?></span>
            <span class="kpi-label">Expiring Subscriptions</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon blue">&#128172;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($totalTickets) ?></span>
            <span class="kpi-label">Support Tickets</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon red">&#128680;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= esc($openTickets) ?></span>
            <span class="kpi-label">Open Tickets</span>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════
     CHARTS
     ═══════════════════════════════════════════════════════════════ -->
<div class="dashboard-section">
    <h2 class="dashboard-section-title">Analytics Overview</h2>
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
    <div class="admin-card chart-card">
        <div class="admin-card-header">
            <h3>Monthly Revenue (Last 12 Months)</h3>
        </div>
        <div class="chart-container" style="min-height: 320px;">
            <canvas id="monthlyRevenueChart"></canvas>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════
     RECENT ACTIVITIES + RECENT DATA
     ═══════════════════════════════════════════════════════════════ -->
<div class="dashboard-grid">
    <!-- Recent Activities -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Recent Activities</h3>
            <a href="<?= base_url('/admin/reports') ?>" class="view-all-link">View All</a>
        </div>
        <?php if (empty($recentActivities)): ?>
            <div class="empty-state" style="padding: 30px 16px;">
                <p class="text-muted">No recent activities found.</p>
            </div>
        <?php else: ?>
            <ul class="activity-list">
                <?php foreach ($recentActivities as $activity): ?>
                    <li class="activity-item">
                        <div class="activity-icon">&#9998;</div>
                        <div class="activity-body">
                            <p>
                                <span class="activity-user"><?= esc($activity->user_name ?? 'System') ?></span>
                                <?= esc($activity->action) ?>
                                <?php if ($activity->subject_type): ?>
                                    <span class="text-muted">(<?= esc($activity->subject_type) ?><?= $activity->subject_id ? '#' . $activity->subject_id : '' ?>)</span>
                                <?php endif; ?>
                            </p>
                            <div class="activity-time"><?= esc($activity->created_at) ?></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Recent Data Tabs -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Recent Data</h3>
        </div>

        <div class="recent-tabs">
            <button class="recent-tab active" data-tab="leads">Leads</button>
            <button class="recent-tab" data-tab="clients">Clients</button>
            <button class="recent-tab" data-tab="payments">Payments</button>
            <button class="recent-tab" data-tab="inquiries">Inquiries</button>
        </div>

        <!-- Leads Panel -->
        <div class="recent-panel active" id="panel-leads">
            <?php if (empty($latestLeads)): ?>
                <div class="empty-state" style="padding: 30px 16px;">
                    <p class="text-muted">No leads yet.</p>
                </div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border: none;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestLeads as $lead): ?>
                                <tr>
                                    <td><strong><?= esc($lead->full_name) ?></strong></td>
                                    <td><?= esc($lead->source) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($lead->status) ?>"><?= esc($lead->status) ?></span>
                                    </td>
                                    <td class="text-muted"><?= date('M d, Y', strtotime($lead->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Clients Panel -->
        <div class="recent-panel" id="panel-clients">
            <?php if (empty($latestClients)): ?>
                <div class="empty-state" style="padding: 30px 16px;">
                    <p class="text-muted">No clients yet.</p>
                </div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border: none;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Contact</th>
                                <th>Company</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestClients as $client): ?>
                                <tr>
                                    <td><strong><?= esc($client->contact_name) ?></strong></td>
                                    <td><?= esc($client->company_name) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($client->status) ?>"><?= esc($client->status) ?></span>
                                    </td>
                                    <td class="text-muted"><?= date('M d, Y', strtotime($client->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Payments Panel -->
        <div class="recent-panel" id="panel-payments">
            <?php if (empty($latestPayments)): ?>
                <div class="empty-state" style="padding: 30px 16px;">
                    <p class="text-muted">No payments yet.</p>
                </div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border: none;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestPayments as $payment): ?>
                                <tr>
                                    <td><strong><?= esc($payment->contact_name ?? $payment->company_name ?? 'N/A') ?></strong></td>
                                    <td>NPR <?= number_format($payment->amount, 2) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($payment->status) ?>"><?= esc($payment->status) ?></span>
                                    </td>
                                    <td class="text-muted"><?= date('M d, Y', strtotime($payment->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Inquiries Panel -->
        <div class="recent-panel" id="panel-inquiries">
            <?php if (empty($latestInquiries)): ?>
                <div class="empty-state" style="padding: 30px 16px;">
                    <p class="text-muted">No inquiries yet.</p>
                </div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border: none;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestInquiries as $inquiry): ?>
                                <tr>
                                    <td><strong><?= esc($inquiry->name) ?></strong></td>
                                    <td><?= esc($inquiry->subject) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= strtolower($inquiry->status) ?>"><?= esc($inquiry->status) ?></span>
                                    </td>
                                    <td class="text-muted"><?= date('M d, Y', strtotime($inquiry->created_at)) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════
     CHART.JS + TAB SWITCHING SCRIPTS
     ═══════════════════════════════════════════════════════════════ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Tab switching ──
    document.querySelectorAll('.recent-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.recent-tab').forEach(function (t) { t.classList.remove('active'); });
            document.querySelectorAll('.recent-panel').forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            var panel = document.getElementById('panel-' + tab.getAttribute('data-tab'));
            if (panel) panel.classList.add('active');
        });
    });

    // ── Color palette ──
    var colors = {
        teal:    '#0F6E63',
        tealLight: 'rgba(15,110,99,0.15)',
        accent:  '#F2994A',
        success: '#2E9E5B',
        danger:  '#D64545',
        warning: '#E0A72E',
        blue:    '#3B82F6',
        purple:  '#8B5CF6',
        pink:    '#EC4899',
        gray:    '#6B7280'
    };

    var statusColorMap = {
        'New':       colors.success,
        'Contacted': colors.blue,
        'Qualified': colors.warning,
        'Converted': colors.teal,
        'Lost':      colors.danger
    };

    var sourceColors = [colors.teal, colors.accent, colors.blue, colors.success, colors.danger, colors.purple, colors.pink, colors.warning, colors.gray, '#14B8A6'];

    // ── Leads by Status (Bar) ──
    var statusLabels = <?= json_encode($leadStatusLabels) ?>;
    var statusData   = <?= json_encode($leadStatusCounts) ?>;
    var statusBg     = statusLabels.map(function (l) { return statusColorMap[l] || colors.gray; });

    new Chart(document.getElementById('leadsByStatusChart'), {
        type: 'bar',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Leads',
                data: statusData,
                backgroundColor: statusBg,
                borderRadius: 6,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // ── Leads by Source (Doughnut) ──
    var sourceLabels = <?= json_encode($leadSourceLabels) ?>;
    var sourceData   = <?= json_encode($leadSourceCounts) ?>;
    var sourceBg     = sourceLabels.map(function (_, i) { return sourceColors[i % sourceColors.length]; });

    new Chart(document.getElementById('leadsBySourceChart'), {
        type: 'doughnut',
        data: {
            labels: sourceLabels,
            datasets: [{
                data: sourceData,
                backgroundColor: sourceBg,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 14, usePointStyle: true, pointStyleWidth: 10, font: { size: 12 } }
                }
            },
            cutout: '60%'
        }
    });

    // ── Monthly Revenue (Line) ──
    var revLabels = <?= json_encode($monthlyRevenueLabels) ?>;
    var revData   = <?= json_encode($monthlyRevenueData) ?>;

    new Chart(document.getElementById('monthlyRevenueChart'), {
        type: 'line',
        data: {
            labels: revLabels,
            datasets: [{
                label: 'Revenue (NPR)',
                data: revData,
                borderColor: colors.teal,
                backgroundColor: colors.tealLight,
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
                tooltip: {
                    callbacks: {
                        label: function (ctx) {
                            return 'NPR ' + ctx.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (val) { return 'NPR ' + val.toLocaleString(); }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>

<?= $this->endSection() ?>
