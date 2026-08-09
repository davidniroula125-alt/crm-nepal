<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

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

<div class="page-header">
    <h2><?= esc($lead->full_name) ?></h2>
    <div class="d-flex gap-1">
        <a href="<?= base_url('/admin/leads/' . $lead->id . '/edit') ?>" class="btn btn-primary">Edit</a>
        <form method="POST" action="<?= base_url('/admin/leads/' . $lead->id . '/delete') ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this lead?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
</div>

<div class="admin-card mb-3">
    <div class="admin-card-header">
        <h3>Lead Information</h3>
        <span class="badge <?= $statusClass ?>" id="current-status-badge"><?= esc($lead->status) ?></span>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:18px;">
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Full Name</p>
            <p style="font-weight:600;"><?= esc($lead->full_name) ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Company</p>
            <p style="font-weight:600;"><?= esc($lead->company_name ?? '-') ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Email</p>
            <p style="font-weight:600;"><?= esc($lead->email ?? '-') ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Phone</p>
            <p style="font-weight:600;"><?= esc($lead->phone ?? '-') ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Source</p>
            <p style="font-weight:600;"><?= esc($lead->source) ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Assigned To</p>
            <p style="font-weight:600;"><?= esc($lead->assigned_to_name ?? 'Unassigned') ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Next Follow-up</p>
            <p style="font-weight:600;"><?= $lead->next_follow_up_at ? esc(date('M d, Y H:i', strtotime($lead->next_follow_up_at))) : '-' ?></p>
        </div>
        <div>
            <p class="text-muted" style="font-size:.82rem; margin-bottom:2px;">Created</p>
            <p style="font-weight:600;"><?= esc(date('M d, Y H:i', strtotime($lead->created_at))) ?></p>
        </div>
    </div>

    <?php if ($lead->notes): ?>
        <div style="margin-top:18px; padding-top:14px; border-top:1px solid var(--color-border);">
            <p class="text-muted" style="font-size:.82rem; margin-bottom:4px;">Notes</p>
            <p style="white-space:pre-wrap;"><?= esc($lead->notes) ?></p>
        </div>
    <?php endif; ?>
</div>

<div class="admin-card mb-3">
    <div class="admin-card-header">
        <h3>Change Status</h3>
    </div>
    <div class="d-flex gap-1" style="flex-wrap:wrap;" id="status-buttons">
        <button type="button"
                class="btn btn-sm <?= $lead->status === 'New' ? 'btn-primary' : 'btn-outline' ?>"
                onclick="changeLeadStatus(<?= $lead->id ?>, 'New')">New</button>
        <button type="button"
                class="btn btn-sm <?= $lead->status === 'Contacted' ? 'btn-accent' : 'btn-outline' ?>"
                onclick="changeLeadStatus(<?= $lead->id ?>, 'Contacted')">Contacted</button>
        <button type="button"
                class="btn btn-sm <?= $lead->status === 'Qualified' ? 'btn-primary' : 'btn-outline' ?>"
                onclick="changeLeadStatus(<?= $lead->id ?>, 'Qualified')"
                style="background:<?= $lead->status === 'Qualified' ? '#8B5CF6' : 'transparent' ?>; color:<?= $lead->status === 'Qualified' ? '#fff' : 'var(--color-primary)' ?>; border-color:var(--color-primary);">Qualified</button>
        <button type="button"
                class="btn btn-sm <?= $lead->status === 'Converted' ? 'btn-success' : 'btn-outline' ?>"
                onclick="changeLeadStatus(<?= $lead->id ?>, 'Converted')">Converted</button>
        <button type="button"
                class="btn btn-sm <?= $lead->status === 'Lost' ? 'btn-danger' : 'btn-outline' ?>"
                onclick="changeLeadStatus(<?= $lead->id ?>, 'Lost')">Lost</button>
    </div>
    <div id="status-message" style="margin-top:10px; display:none;"></div>
</div>

<?php if (! empty($followUps)): ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Follow-ups</h3>
        </div>
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($followUps as $fu): ?>
                        <?php
                        $fuStatusClass = match($fu->status) {
                            'Pending'   => 'badge-warning',
                            'Completed' => 'badge-success',
                            'Cancelled' => 'badge-danger',
                            default     => 'badge-info',
                        };
                        ?>
                        <tr>
                            <td><?= esc($fu->title) ?></td>
                            <td><?= esc(date('M d, Y H:i', strtotime($fu->due_at))) ?></td>
                            <td><span class="badge <?= $fuStatusClass ?>"><?= esc($fu->status) ?></span></td>
                            <td><?= esc($fu->notes ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<script>
function changeLeadStatus(leadId, status) {
    const messageEl = document.getElementById('status-message');
    messageEl.style.display = 'none';

    fetch('<?= base_url("/admin/leads") ?>' + '/' + leadId + '/status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
        },
        body: 'status=' + encodeURIComponent(status)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageEl.textContent = data.message;
            messageEl.style.display = 'block';
            messageEl.style.color = 'var(--color-success)';

            // Update badge
            const badge = document.getElementById('current-status-badge');
            badge.textContent = status;

            // Update button styles
            const buttons = document.querySelectorAll('#status-buttons .btn');
            buttons.forEach(btn => {
                btn.classList.remove('btn-primary', 'btn-accent', 'btn-success', 'btn-danger');
                btn.classList.add('btn-outline');
                btn.style.background = '';
                btn.style.color = '';
            });
        } else {
            messageEl.textContent = data.message || 'Failed to update status.';
            messageEl.style.display = 'block';
            messageEl.style.color = 'var(--color-danger)';
        }
    })
    .catch(() => {
        messageEl.textContent = 'An error occurred. Please try again.';
        messageEl.style.display = 'block';
        messageEl.style.color = 'var(--color-danger)';
    });
}
</script>

<?= $this->endSection() ?>
