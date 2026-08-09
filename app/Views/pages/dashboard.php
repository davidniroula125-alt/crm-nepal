<?= view('layout/header', ['title' => 'Dashboard']) ?>

<div class="stats-grid">
    <div class="stat-card stat-blue">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= format_currency($pipelineValue) ?></span>
            <span class="stat-label">Pipeline Value</span>
        </div>
    </div>
    <div class="stat-card stat-green">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= $activeLeads ?></span>
            <span class="stat-label">Active Leads</span>
        </div>
    </div>
    <div class="stat-card stat-orange">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= $renewalRate ?>%</span>
            <span class="stat-label">Win Rate</span>
        </div>
    </div>
    <div class="stat-card stat-purple">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="stat-info">
            <span class="stat-value"><?= format_currency($monthlyRevenue) ?></span>
            <span class="stat-label">Monthly Revenue</span>
        </div>
    </div>
</div>

<div class="kanban-board">
    <?php
    $stageLabels = [
        'lead' => 'Leads',
        'proposals' => 'Proposals',
        'negotiation' => 'Negotiation',
        'closed_won' => 'Closed Won',
        'closed_lost' => 'Closed Lost',
    ];
    $stageColors = [
        'lead' => '#3B82F6',
        'proposals' => '#F59E0B',
        'negotiation' => '#F97316',
        'closed_won' => '#10B981',
        'closed_lost' => '#EF4444',
    ];
    ?>
    <?php foreach ($stages as $stage => $deals): ?>
    <div class="kanban-column" data-stage="<?= $stage ?>">
        <div class="kanban-header" style="border-top: 3px solid <?= $stageColors[$stage] ?>">
            <h3><?= $stageLabels[$stage] ?></h3>
            <span class="kanban-count"><?= count($deals) ?></span>
        </div>
        <div class="kanban-cards" data-stage="<?= $stage ?>">
            <?php foreach ($deals as $deal): ?>
            <div class="kanban-card" data-id="<?= $deal['id'] ?>">
                <h4><?= esc($deal['title']) ?></h4>
                <p class="deal-value"><?= format_currency($deal['value']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="recent-activity">
    <h3>Recent Activity</h3>
    <div class="activity-list">
        <?php if (empty($recentActivity)): ?>
        <p class="empty-state">No recent activity</p>
        <?php else: ?>
        <?php foreach ($recentActivity as $activity): ?>
        <div class="activity-item">
            <div class="activity-dot"></div>
            <div class="activity-content">
                <span class="activity-action"><?= esc($activity['action']) ?></span>
                <span class="activity-time"><?= date('M d, Y H:i', strtotime($activity['created_at'])) ?></span>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= view('layout/footer') ?>
