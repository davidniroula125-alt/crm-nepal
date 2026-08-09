<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Demo Requests <span class="badge"><?= esc($total) ?></span></h2>
</div>

<div class="admin-filter-bar">
    <form method="GET" action="<?= base_url('/admin/demo-requests') ?>">
        <label for="status">Filter by Status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="Pending" <?= $currentStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Scheduled" <?= $currentStatus === 'Scheduled' ? 'selected' : '' ?>>Scheduled</option>
            <option value="Completed" <?= $currentStatus === 'Completed' ? 'selected' : '' ?>>Completed</option>
            <option value="Cancelled" <?= $currentStatus === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
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
                <th>Phone</th>
                <th>Business Type</th>
                <th>Preferred Date</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($demoRequests)): ?>
                <tr>
                    <td colspan="10" class="text-center">No demo requests found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($demoRequests as $request): ?>
                    <tr>
                        <td><?= esc($request->id) ?></td>
                        <td><?= esc($request->full_name) ?></td>
                        <td><?= esc($request->company_name) ?></td>
                        <td><?= esc($request->email) ?></td>
                        <td><?= esc($request->phone) ?></td>
                        <td><?= esc($request->business_type) ?></td>
                        <td><?= esc($request->preferred_date) ?></td>
                        <td>
                            <?php
                            $badgeClass = 'badge-pending';
                            if ($request->status === 'Scheduled') $badgeClass = 'badge-scheduled';
                            elseif ($request->status === 'Completed') $badgeClass = 'badge-completed';
                            elseif ($request->status === 'Cancelled') $badgeClass = 'badge-cancelled';
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= esc($request->status) ?></span>
                        </td>
                        <td><?= esc(date('Y-m-d', strtotime($request->created_at))) ?></td>
                        <td>
                            <a href="<?= base_url('/admin/demo-requests/' . $request->id) ?>" class="btn btn-sm btn-info">View</a>
                            <form method="POST" action="<?= base_url('/admin/demo-requests/' . $request->id . '/delete') ?>" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this demo request?');">
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
    .badge-pending { background: #ffc107; color: #333; }
    .badge-scheduled { background: #007bff; color: #fff; }
    .badge-completed { background: #28a745; color: #fff; }
    .badge-cancelled { background: #dc3545; color: #fff; }
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
