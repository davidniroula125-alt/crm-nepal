<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Contact Inquiries <span class="badge"><?= esc($total) ?></span></h2>
</div>

<div class="admin-filter-bar">
    <form method="GET" action="<?= base_url('/admin/contact-inquiries') ?>">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="New" <?= $currentStatus === 'New' ? 'selected' : '' ?>>New</option>
            <option value="Read" <?= $currentStatus === 'Read' ? 'selected' : '' ?>>Read</option>
            <option value="Responded" <?= $currentStatus === 'Responded' ? 'selected' : '' ?>>Responded</option>
        </select>
    </form>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($inquiries)): ?>
                <tr>
                    <td colspan="8" class="text-center">No contact inquiries found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($inquiries as $inquiry): ?>
                    <tr class="<?= $inquiry->status === 'New' ? 'row-new' : '' ?>">
                        <td><?= esc($inquiry->id) ?></td>
                        <td><?= esc($inquiry->name) ?></td>
                        <td><?= esc($inquiry->company ?? 'N/A') ?></td>
                        <td><?= esc($inquiry->email) ?></td>
                        <td><?= esc($inquiry->subject) ?></td>
                        <td>
                            <?php
                            $badgeClass = 'badge-new';
                            if ($inquiry->status === 'Read') $badgeClass = 'badge-read';
                            elseif ($inquiry->status === 'Responded') $badgeClass = 'badge-responded';
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= esc($inquiry->status) ?></span>
                        </td>
                        <td><?= esc(date('Y-m-d', strtotime($inquiry->created_at))) ?></td>
                        <td>
                            <a href="<?= base_url('/admin/contact-inquiries/' . $inquiry->id) ?>" class="btn btn-sm btn-info">View</a>
                            <form method="POST" action="<?= base_url('/admin/contact-inquiries/' . $inquiry->id . '/delete') ?>" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="admin-pagination">
    <?= $pager->links() ?>
</div>

<style>
    .admin-page-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
    .admin-page-header h2 { margin: 0; }
    .badge { background: #007bff; color: #fff; padding: 2px 8px; border-radius: 12px; font-size: 14px; }
    .admin-filter-bar { margin-bottom: 20px; }
    .admin-filter-bar select { padding: 6px 12px; border: 1px solid #ccc; border-radius: 4px; }
    .admin-table-wrapper { overflow-x: auto; }
    .admin-table { width: 100%; border-collapse: collapse; background: #fff; }
    .admin-table th, .admin-table td { padding: 10px 12px; border: 1px solid #e0e0e0; text-align: left; }
    .admin-table th { background: #f5f5f5; font-weight: 600; }
    .admin-table tr:hover { background: #f9f9f9; }
    .row-new { background: #fff8e1 !important; }
    .row-new:hover { background: #fff3cd !important; }
    .badge-new { background: #ffc107; color: #333; }
    .badge-read { background: #17a2b8; color: #fff; }
    .badge-responded { background: #28a745; color: #fff; }
    .btn { padding: 4px 10px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; display: inline-block; }
    .btn-sm { padding: 3px 8px; font-size: 12px; }
    .btn-info { background: #17a2b8; color: #fff; }
    .btn-danger { background: #dc3545; color: #fff; }
    .inline-form { display: inline; }
    .text-center { text-align: center; }
    .admin-pagination { margin-top: 20px; }
    .admin-pagination a, .admin-pagination strong { margin: 0 4px; padding: 4px 10px; border: 1px solid #ccc; border-radius: 4px; text-decoration: none; }
    .admin-pagination strong { background: #007bff; color: #fff; border-color: #007bff; }
</style>

<?= $this->endSection() ?>
