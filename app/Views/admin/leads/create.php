<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h2>Create New Lead</h2>
</div>

<div class="admin-card">
    <form method="POST" action="<?= base_url('/admin/leads/store') ?>" class="admin-form">
        <?= csrf_field() ?>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="full_name">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="full_name" id="full_name" class="form-control" value="<?= esc(old('full_name')) ?>" required maxlength="150">
                <?php if (session()->getFlashdata('validation')): ?>
                    <?php $errors = session()->getFlashdata('validation')->listErrors(); ?>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label" for="company_name">Company Name</label>
                <input type="text" name="company_name" id="company_name" class="form-control" value="<?= esc(old('company_name')) ?>" maxlength="150">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= esc(old('email')) ?>">
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="<?= esc(old('phone')) ?>" maxlength="30">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="source">Source <span class="text-danger">*</span></label>
                <select name="source" id="source" class="form-control" required>
                    <option value="">Select Source</option>
                    <?php foreach ($sourceOptions as $source): ?>
                        <option value="<?= esc($source) ?>" <?= old('source') === $source ? 'selected' : '' ?>>
                            <?= esc($source) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <?php foreach ($statusOptions as $status): ?>
                        <option value="<?= esc($status) ?>" <?= old('status', 'New') === $status ? 'selected' : '' ?>>
                            <?= esc($status) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="assigned_to">Assigned To</label>
            <select name="assigned_to" id="assigned_to" class="form-control">
                <option value="">Unassigned</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= esc($user->id) ?>" <?= old('assigned_to') == $user->id ? 'selected' : '' ?>>
                        <?= esc($user->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label" for="next_follow_up_at">Next Follow-up Date</label>
            <input type="datetime-local" name="next_follow_up_at" id="next_follow_up_at" class="form-control" value="<?= esc(old('next_follow_up_at') ? date('Y-m-d\TH:i', strtotime(old('next_follow_up_at'))) : '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label" for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="5"><?= esc(old('notes')) ?></textarea>
        </div>

        <div class="d-flex gap-1 mt-2">
            <button type="submit" class="btn btn-primary">Create Lead</button>
            <a href="<?= base_url('/admin/leads') ?>" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
