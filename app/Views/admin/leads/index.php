<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Leads</h2>
    <div class="d-flex gap-1">
        <a href="<?= base_url('/admin/leads/export?' . http_build_query($filters)) ?>" class="btn btn-outline btn-sm">Export CSV</a>
        <a href="<?= base_url('/admin/leads/create') ?>" class="btn btn-primary">+ Add New Lead</a>
    </div>
</div>

<div class="admin-card mb-3">
    <form method="GET" action="<?= base_url('/admin/leads') ?>" class="d-flex gap-1 align-center" style="flex-wrap:wrap;">
        <div class="search-box">
            <input type="text" name="search" placeholder="Search name, email, company..." value="<?= esc($filters['search'] ?? '') ?>" class="form-control" style="width:240px;">
        </div>

        <select name="status" class="form-control" style="width:160px;">
            <option value="">All Statuses</option>
            <?php foreach ($statusOptions as $status): ?>
                <option value="<?= esc($status) ?>" <?= ($filters['status'] ?? '') === $status ? 'selected' : '' ?>>
                    <?= esc($status) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="source" class="form-control" style="width:160px;">
            <option value="">All Sources</option>
            <?php foreach ($sourceOptions as $source): ?>
                <option value="<?= esc($source) ?>" <?= ($filters['source'] ?? '') === $source ? 'selected' : '' ?>>
                    <?= esc($source) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="assigned_to" class="form-control" style="width:180px;">
            <option value="">All Assignees</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= esc($user->id) ?>" <?= (string) ($filters['assigned_to'] ?? '') === (string) $user->id ? 'selected' : '' ?>>
                    <?= esc($user->name) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <?php if (! empty($filters['search']) || ! empty($filters['status']) || ! empty($filters['source']) || ! empty($filters['assigned_to'])): ?>
            <a href="<?= base_url('/admin/leads') ?>" class="btn btn-outline btn-sm">Clear</a>
        <?php endif; ?>
    </form>
</div>

<?php if (empty($leads)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9733;</div>
            <h3>No leads found</h3>
            <p>There are no leads matching your criteria, or no leads have been added yet.</p>
        </div>
    </div>
<?php else: ?>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Follow-up</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead): ?>
                    <?php
                    $statusClasses = [
                        'New'       => 'badge-info',
                        'Contacted' => 'badge-warning',
                        'Qualified' => 'badge-purple',
                        'Converted' => 'badge-success',
                        'Lost'      => 'badge-danger',
                    ];
                    $statusClass = $statusClasses[$lead->status] ?? 'badge-info';
                    ?>
                    <tr>
                        <td><?= esc($lead->id) ?></td>
                        <td><a href="<?= base_url('/admin/leads/' . $lead->id) ?>"><?= esc($lead->full_name) ?></a></td>
                        <td><?= esc($lead->company_name ?? '-') ?></td>
                        <td><?= esc($lead->email ?? '-') ?></td>
                        <td><?= esc($lead->phone ?? '-') ?></td>
                        <td><?= esc($lead->source) ?></td>
                        <td><span class="badge <?= $statusClass ?>"><?= esc($lead->status) ?></span></td>
                        <td><?= esc($lead->assigned_to_name ?? 'Unassigned') ?></td>
                        <td>
                            <?php if ($lead->next_follow_up_at): ?>
                                <?= esc(date('M d, Y H:i', strtotime($lead->next_follow_up_at))) ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?= esc(date('M d, Y', strtotime($lead->created_at))) ?></td>
                        <td>
                            <div class="table-actions">
                                <a href="<?= base_url('/admin/leads/' . $lead->id) ?>" class="btn btn-outline btn-sm">View</a>
                                <a href="<?= base_url('/admin/leads/' . $lead->id . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                                <form method="POST" action="<?= base_url('/admin/leads/' . $lead->id . '/delete') ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this lead?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php
    $lastPage = ceil($total / $perPage);
    if ($lastPage > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="<?= base_url('/admin/leads?' . http_build_query(array_merge($filters, ['page' => $currentPage - 1]))) ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php
            $start = max(1, $currentPage - 2);
            $end   = min($lastPage, $currentPage + 2);

            for ($i = $start; $i <= $end; $i++):
            ?>
                <?php if ($i === $currentPage): ?>
                    <span class="active"><?= $i ?></span>
                <?php else: ?>
                    <a href="<?= base_url('/admin/leads?' . http_build_query(array_merge($filters, ['page' => $i]))) ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($currentPage < $lastPage): ?>
                <a href="<?= base_url('/admin/leads?' . http_build_query(array_merge($filters, ['page' => $currentPage + 1]))) ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?= $this->endSection() ?>
