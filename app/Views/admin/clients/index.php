<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Clients</h2>
    <a href="<?= site_url('/admin/clients/create') ?>" class="btn btn-primary">Add New Client</a>
</div>

<form method="GET" action="<?= site_url('/admin/clients') ?>" class="admin-filter-form">
    <input type="text"
           name="search"
           class="form-control"
           placeholder="Search by name, company or email..."
           value="<?= esc($search) ?>">
    <select name="status" class="form-control">
        <option value="">All Status</option>
        <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
        <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
    </select>
    <button type="submit" class="btn btn-primary">Search</button>
    <?php if ($search !== '' || $status !== ''): ?>
        <a href="<?= site_url('/admin/clients') ?>" class="btn btn-secondary">Clear</a>
    <?php endif; ?>
</form>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Company</th>
                <th>Contact Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clients)): ?>
                <tr>
                    <td colspan="8" class="text-center">No clients found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= esc($client->id) ?></td>
                        <td><?= esc($client->company_name) ?></td>
                        <td><?= esc($client->contact_name) ?></td>
                        <td><?= esc($client->email) ?></td>
                        <td><?= esc($client->phone) ?></td>
                        <td>
                            <span class="badge badge-<?= $client->status === 'active' ? 'success' : 'secondary' ?>">
                                <?= esc(ucfirst($client->status)) ?>
                            </span>
                        </td>
                        <td><?= esc(date('M d, Y', strtotime($client->created_at))) ?></td>
                        <td>
                            <a href="<?= site_url("/admin/clients/{$client->id}") ?>" class="btn btn-sm btn-info">View</a>
                            <a href="<?= site_url("/admin/clients/{$client->id}/edit") ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($pager): ?>
    <div class="admin-pagination">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
