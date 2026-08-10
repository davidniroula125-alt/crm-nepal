<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<style>
.dashboard-welcome {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark, #0a4a3f) 100%);
    border-radius: 16px;
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.dashboard-welcome h2 { font-family: var(--font-heading); font-size: 1.4rem; margin-bottom: 4px; }
.dashboard-welcome p { opacity: .85; font-size: .92rem; margin: 0; }
.dashboard-welcome-date {
    background: rgba(255,255,255,.15);
    padding: 8px 18px;
    border-radius: 20px;
    font-size: .85rem;
    font-weight: 500;
}

.kpi-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
.kpi-card {
    background: var(--color-card-bg, #fff);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: transform .2s, box-shadow .2s;
}
.kpi-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.06); }
.kpi-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.kpi-icon.teal    { background: #E6F7F5; color: var(--color-primary); }
.kpi-icon.green   { background: #E8F8EF; color: var(--color-success); }
.kpi-icon.blue    { background: #EBF5FF; color: #3B82F6; }
.kpi-icon.orange  { background: #FFF4E6; color: var(--color-warning); }
.kpi-icon.red     { background: #FDECEA; color: var(--color-danger); }
.kpi-icon.purple  { background: #F3EEFF; color: #8B5CF6; }
.kpi-info { min-width: 0; }
.kpi-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    font-family: var(--font-heading);
    line-height: 1.2;
    color: var(--color-text);
}
.kpi-label {
    display: block;
    font-size: .78rem;
    color: var(--color-text-muted);
    font-weight: 500;
    margin-top: 2px;
}
.revenue-highlight { color: var(--color-success) !important; }

.dashboard-section { margin-bottom: 28px; }
.dashboard-section-title {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 16px;
    color: var(--color-text);
}
.charts-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
.chart-card canvas { max-height: 300px; }

.activity-list { list-style: none; padding: 0; margin: 0; }
.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--color-border);
}
.activity-item:last-child { border-bottom: none; }
.activity-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: var(--color-primary-light);
    color: var(--color-primary);
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem;
    flex-shrink: 0;
}
.activity-body { flex: 1; min-width: 0; }
.activity-body p { font-size: .85rem; margin: 0; line-height: 1.5; }
.activity-body .activity-user { font-weight: 600; color: var(--color-primary); }
.activity-time { font-size: .75rem; color: var(--color-text-muted); margin-top: 2px; }

.recent-tabs { display: flex; gap: 0; border-bottom: 2px solid var(--color-border); }
.recent-tab {
    padding: 10px 20px;
    font-size: .85rem;
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
.recent-tab.active { color: var(--color-primary); border-bottom-color: var(--color-primary); }
.recent-panel { display: none; padding: 16px 0 0; }
.recent-panel.active { display: block; }

.status-badge {
    display: inline-block;
    padding: 3px 10px;
    font-size: .72rem;
    font-weight: 600;
    border-radius: 20px;
}
.status-new       { background: #E8F8EF; color: var(--color-success); }
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

.view-all-link { font-size: .82rem; font-weight: 600; color: var(--color-primary); }
.view-all-link:hover { text-decoration: underline; }
.text-muted { color: var(--color-text-muted); }

.dashboard-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
@media (max-width: 1024px) { .charts-row, .dashboard-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px) {
    .recent-tabs { overflow-x: auto; flex-wrap: nowrap; }
    .recent-tab { padding: 8px 14px; font-size: .82rem; white-space: nowrap; }
    .kpi-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
}
</style>

<!-- Welcome Banner -->
<div class="dashboard-welcome">
    <div>
        <h2>Welcome back, <?= esc(session()->get('user_name') ?? 'Admin') ?>! &#128075;</h2>
        <p>Here's what's happening with your CRM today.</p>
    </div>
    <div class="dashboard-welcome-date">
        <?= date('l, M d, Y') ?>
    </div>
</div>

<!-- KPI Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon teal">&#9733;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($totalLeads) ?></span>
            <span class="kpi-label">Total Leads</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#10003;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($newLeads) ?></span>
            <span class="kpi-label">New Leads</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon blue">&#128269;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($qualifiedLeads) ?></span>
            <span class="kpi-label">Qualified</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon purple">&#10004;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($convertedLeads) ?></span>
            <span class="kpi-label">Converted</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon teal">&#128101;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($totalClients) ?></span>
            <span class="kpi-label">Total Clients</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#9989;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($activeClients) ?></span>
            <span class="kpi-label">Active Clients</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon green">&#36;</div>
        <div class="kpi-info">
            <span class="kpi-value revenue-highlight">NPR <?= number_format($totalRevenue, 0) ?></span>
            <span class="kpi-label">Total Revenue</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon teal">&#128176;</div>
        <div class="kpi-info">
            <span class="kpi-value revenue-highlight">NPR <?= number_format($revenueThisMonth, 0) ?></span>
            <span class="kpi-label">This Month</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#8987;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($paymentPending) ?></span>
            <span class="kpi-label">Payments Pending</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon red">&#9888;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($overduePayments) ?></span>
            <span class="kpi-label">Overdue</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon blue">&#128172;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($totalTickets) ?></span>
            <span class="kpi-label">Support Tickets</span>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon orange">&#128197;</div>
        <div class="kpi-info">
            <span class="kpi-value"><?= number_format($pendingFollowUps) ?></span>
            <span class="kpi-label">Pending Follow-ups</span>
        </div>
    </div>
</div>

<!-- Charts -->
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

<!-- Recent Activities + Data -->
<div class="dashboard-grid">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Recent Activities</h3>
        </div>
        <?php if (empty($recentActivities)): ?>
            <div class="empty-state" style="padding: 30px 16px; text-align:center;">
                <p class="text-muted">No recent activities.</p>
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

        <div class="recent-panel active" id="panel-leads">
            <?php if (empty($latestLeads)): ?>
                <div style="padding:30px 16px; text-align:center;"><p class="text-muted">No leads yet.</p></div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border:none;">
                    <table class="admin-table">
                        <thead><tr><th>Name</th><th>Source</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php foreach ($latestLeads as $lead): ?>
                            <tr>
                                <td><strong><?= esc($lead->full_name) ?></strong></td>
                                <td><?= esc($lead->source) ?></td>
                                <td><span class="status-badge status-<?= strtolower($lead->status) ?>"><?= esc($lead->status) ?></span></td>
                                <td class="text-muted"><?= date('M d', strtotime($lead->created_at)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="recent-panel" id="panel-clients">
            <?php if (empty($latestClients)): ?>
                <div style="padding:30px 16px; text-align:center;"><p class="text-muted">No clients yet.</p></div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border:none;">
                    <table class="admin-table">
                        <thead><tr><th>Contact</th><th>Company</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php foreach ($latestClients as $client): ?>
                            <tr>
                                <td><strong><?= esc($client->contact_name) ?></strong></td>
                                <td><?= esc($client->company_name) ?></td>
                                <td><span class="status-badge status-<?= strtolower($client->status) ?>"><?= esc($client->status) ?></span></td>
                                <td class="text-muted"><?= date('M d', strtotime($client->created_at)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="recent-panel" id="panel-payments">
            <?php if (empty($latestPayments)): ?>
                <div style="padding:30px 16px; text-align:center;"><p class="text-muted">No payments yet.</p></div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border:none;">
                    <table class="admin-table">
                        <thead><tr><th>Client</th><th>Amount</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php foreach ($latestPayments as $payment): ?>
                            <tr>
                                <td><strong><?= esc($payment->contact_name ?? $payment->company_name ?? 'N/A') ?></strong></td>
                                <td>NPR <?= number_format($payment->amount, 2) ?></td>
                                <td><span class="status-badge status-<?= strtolower($payment->status) ?>"><?= esc($payment->status) ?></span></td>
                                <td class="text-muted"><?= date('M d', strtotime($payment->created_at)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="recent-panel" id="panel-inquiries">
            <?php if (empty($latestInquiries)): ?>
                <div style="padding:30px 16px; text-align:center;"><p class="text-muted">No inquiries yet.</p></div>
            <?php else: ?>
                <div class="admin-table-wrapper" style="border:none;">
                    <table class="admin-table">
                        <thead><tr><th>Name</th><th>Subject</th><th>Status</th><th>Date</th></tr></thead>
                        <tbody>
                        <?php foreach ($latestInquiries as $inquiry): ?>
                            <tr>
                                <td><strong><?= esc($inquiry->name) ?></strong></td>
                                <td><?= esc($inquiry->subject) ?></td>
                                <td><span class="status-badge status-<?= strtolower($inquiry->status) ?>"><?= esc($inquiry->status) ?></span></td>
                                <td class="text-muted"><?= date('M d', strtotime($inquiry->created_at)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.recent-tab').forEach(function (tab) {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.recent-tab').forEach(function (t) { t.classList.remove('active'); });
            document.querySelectorAll('.recent-panel').forEach(function (p) { p.classList.remove('active'); });
            tab.classList.add('active');
            var panel = document.getElementById('panel-' + tab.getAttribute('data-tab'));
            if (panel) panel.classList.add('active');
        });
    });

    var colors = {
        teal: '#0F6E63', tealLight: 'rgba(15,110,99,0.15)', accent: '#F2994A',
        success: '#2E9E5B', danger: '#D64545', warning: '#E0A72E',
        blue: '#3B82F6', purple: '#8B5CF6', pink: '#EC4899', gray: '#6B7280'
    };
    var statusColorMap = {'New':colors.success,'Contacted':colors.blue,'Qualified':colors.warning,'Converted':colors.teal,'Lost':colors.danger};
    var sourceColors = [colors.teal,colors.accent,colors.blue,colors.success,colors.danger,colors.purple,colors.pink,colors.warning,colors.gray,'#14B8A6'];

    var statusLabels = <?= json_encode($leadStatusLabels) ?>;
    var statusData = <?= json_encode($leadStatusCounts) ?>;
    var statusBg = statusLabels.map(function(l){return statusColorMap[l]||colors.gray;});

    new Chart(document.getElementById('leadsByStatusChart'), {
        type:'bar', data:{labels:statusLabels,datasets:[{label:'Leads',data:statusData,backgroundColor:statusBg,borderRadius:8,barPercentage:.6}]},
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{stepSize:1}},x:{grid:{display:false}}}}
    });

    var sourceLabels = <?= json_encode($leadSourceLabels) ?>;
    var sourceData = <?= json_encode($leadSourceCounts) ?>;
    var sourceBg = sourceLabels.map(function(_,i){return sourceColors[i%sourceColors.length];});

    new Chart(document.getElementById('leadsBySourceChart'), {
        type:'doughnut', data:{labels:sourceLabels,datasets:[{data:sourceData,backgroundColor:sourceBg,borderWidth:2,borderColor:'#fff'}]},
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{padding:14,usePointStyle:true,pointStyleWidth:10,font:{size:12}}}},cutout:'60%'}
    });

    var revLabels = <?= json_encode($monthlyRevenueLabels) ?>;
    var revData = <?= json_encode($monthlyRevenueData) ?>;
    new Chart(document.getElementById('monthlyRevenueChart'), {
        type:'line', data:{labels:revLabels,datasets:[{label:'Revenue (NPR)',data:revData,borderColor:colors.teal,backgroundColor:colors.tealLight,fill:true,tension:.35,pointBackgroundColor:colors.teal,pointBorderColor:'#fff',pointBorderWidth:2,pointRadius:5,pointHoverRadius:7}]},
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{callbacks:{label:function(ctx){return 'NPR '+ctx.parsed.y.toLocaleString();}}}},scales:{y:{beginAtZero:true,ticks:{callback:function(val){return 'NPR '+val.toLocaleString();}}},x:{grid:{display:false}}}}
    });
});
</script>

<?= $this->endSection() ?>
