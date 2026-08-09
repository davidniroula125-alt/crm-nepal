<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Client Details</h2>
    <div>
        <a href="<?= site_url("/admin/clients/{$client->id}/edit") ?>" class="btn btn-warning">Edit</a>
        <a href="<?= site_url('/admin/clients') ?>" class="btn btn-secondary">Back to List</a>
        <form method="POST" action="<?= site_url("/admin/clients/{$client->id}/delete") ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this client?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Client Information</h3>
        <span class="badge badge-<?= $client->status === 'active' ? 'success' : 'secondary' ?>">
            <?= esc(ucfirst($client->status)) ?>
        </span>
    </div>
    <div class="admin-card-body">
        <div class="info-grid">
            <div class="info-item">
                <label>ID</label>
                <span><?= esc($client->id) ?></span>
            </div>
            <div class="info-item">
                <label>Company Name</label>
                <span><?= esc($client->company_name) ?></span>
            </div>
            <div class="info-item">
                <label>Contact Name</label>
                <span><?= esc($client->contact_name) ?></span>
            </div>
            <div class="info-item">
                <label>Email</label>
                <span><?= esc($client->email) ?></span>
            </div>
            <div class="info-item">
                <label>Phone</label>
                <span><?= esc($client->phone ?: 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Address</label>
                <span><?= esc($client->address ?: 'N/A') ?></span>
            </div>
            <div class="info-item">
                <label>Lead ID</label>
                <span><?= $client->lead_id ? esc($client->lead_id) : 'None' ?></span>
            </div>
            <div class="info-item">
                <label>Created At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($client->created_at))) ?></span>
            </div>
            <div class="info-item">
                <label>Updated At</label>
                <span><?= esc(date('M d, Y h:i A', strtotime($client->updated_at))) ?></span>
            </div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Subscriptions</h3>
    </div>
    <div class="admin-card-body">
        <?php if (empty($subscriptions)): ?>
            <p class="text-muted">No subscriptions found for this client.</p>
        <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscriptions as $sub): ?>
                            <tr>
                                <td><?= esc($sub->id) ?></td>
                                <td><?= esc($sub->plan_name ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge badge-<?= ($sub->status ?? '') === 'active' ? 'success' : 'secondary' ?>">
                                        <?= esc(ucfirst($sub->status ?? 'unknown')) ?>
                                    </span>
                                </td>
                                <td><?= esc($sub->start_date ?? 'N/A') ?></td>
                                <td><?= esc($sub->end_date ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Payments</h3>
    </div>
    <div class="admin-card-body">
        <?php if (empty($payments)): ?>
            <p class="text-muted">No payments found for this client.</p>
        <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td><?= esc($payment->id) ?></td>
                                <td><?= esc($payment->amount ?? 'N/A') ?></td>
                                <td><?= esc($payment->payment_method ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge badge-<?= ($payment->status ?? '') === 'completed' ? 'success' : 'secondary' ?>">
                                        <?= esc(ucfirst($payment->status ?? 'unknown')) ?>
                                    </span>
                                </td>
                                <td><?= esc($payment->created_at ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
