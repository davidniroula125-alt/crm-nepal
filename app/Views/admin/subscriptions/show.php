<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Subscription Details</h2>
    <div>
        <a href="<?= site_url("/admin/subscriptions/{$subscription->id}/edit") ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('/admin/subscriptions') ?>" class="btn btn-secondary">Back to List</a>
        <form method="POST" action="<?= site_url("/admin/subscriptions/{$subscription->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this subscription?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Subscription Information</h3>
        <?php
            $badgeClass = 'secondary';
            if ($subscription->status === 'active') { $badgeClass = 'success'; }
            elseif ($subscription->status === 'expiring') { $badgeClass = 'warning'; }
            elseif ($subscription->status === 'expired') { $badgeClass = 'danger'; }
        ?>
        <span class="badge badge-<?= $badgeClass ?>">
            <?= esc(ucfirst($subscription->status)) ?>
        </span>
    </div>
    <div class="admin-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>ID</label>
                <span><?= esc($subscription->id) ?></span>
            </div>
            <div class="info-item">
                <label>Client</label>
                <span><?= esc($subscription->client_name ?? 'Unknown') ?></span>
            </div>
            <div class="info-item">
                <label>Plan Name</label>
                <span><?= esc($subscription->plan_name) ?></span>
            </div>
            <div class="info-item">
                <label>Billing Cycle</label>
                <span><?= esc(ucfirst($subscription->billing_cycle)) ?></span>
            </div>
            <div class="info-item">
                <label>Amount</label>
                <span>NPR <?= esc(number_format((float) $subscription->amount, 2)) ?></span>
            </div>
            <div class="info-item">
                <label>Start Date</label>
                <span><?= esc(date('M d, Y', strtotime($subscription->start_date))) ?></span>
            </div>
            <div class="info-item">
                <label>End Date</label>
                <span><?= $subscription->end_date ? esc(date('M d, Y', strtotime($subscription->end_date))) : 'N/A' ?></span>
            </div>
            <div class="info-item">
                <label>Created At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($subscription->created_at))) ?></span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
