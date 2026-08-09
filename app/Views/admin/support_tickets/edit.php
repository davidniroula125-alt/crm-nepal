<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Edit Support Ticket</h2>
    <a href="<?= site_url('/admin/support-tickets') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url("/admin/support-tickets/{$ticket->id}/update") ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="client_id">Client</label>
            <select id="client_id" name="client_id" class="form-control">
                <option value="">-- None --</option>
                <?php if (! empty($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client->id) ?>"
                            <?= old('client_id', $ticket->client_id) == $client->id ? 'selected' : '' ?>>
                            <?= esc($client->company_name) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="subject">Subject <span class="required">*</span></label>
            <input type="text"
                   id="subject"
                   name="subject"
                   class="form-control"
                   value="<?= esc(old('subject', $ticket->subject)) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="description">Description <span class="required">*</span></label>
            <textarea id="description"
                      name="description"
                      class="form-control"
                      rows="6"
                      required><?= esc(old('description', $ticket->description)) ?></textarea>
        </div>

        <div class="form-group">
            <label for="assigned_to">Assigned To</label>
            <select id="assigned_to" name="assigned_to" class="form-control">
                <option value="">-- Unassigned --</option>
                <?php if (! empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= esc($user->id) ?>"
                            <?= old('assigned_to', $ticket->assigned_to) == $user->id ? 'selected' : '' ?>>
                            <?= esc($user->name) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status <span class="required">*</span></label>
            <select id="status" name="status" class="form-control" required>
                <option value="Open" <?= old('status', $ticket->status) === 'Open' ? 'selected' : '' ?>>Open</option>
                <option value="In Progress" <?= old('status', $ticket->status) === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                <option value="Resolved" <?= old('status', $ticket->status) === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                <option value="Closed" <?= old('status', $ticket->status) === 'Closed' ? 'selected' : '' ?>>Closed</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Ticket</button>
            <a href="<?= site_url("/admin/support-tickets/{$ticket->id}") ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
