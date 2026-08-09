<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="admin-page-header">
    <h2>Edit Subscription</h2>
    <a href="<?= site_url('/admin/subscriptions') ?>" class="btn btn-secondary">Back to List</a>
</div>

<div class="admin-form-wrapper">
    <form method="POST" action="<?= site_url("/admin/subscriptions/{$subscription->id}/update") ?>">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="client_id">Client <span class="required">*</span></label>
            <select id="client_id" name="client_id" class="form-control" required>
                <option value="">-- Select Client --</option>
                <?php if (! empty($clients)): ?>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= esc($client->id) ?>"
                            <?= old('client_id', $subscription->client_id) == $client->id ? 'selected' : '' ?>>
                            <?= esc($client->contact_name . ' (' . $client->company_name . ')') ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="plan_name">Plan Name <span class="required">*</span></label>
            <?php if (! empty($pricingPlans)): ?>
                <select id="plan_name" name="plan_name" class="form-control" required>
                    <option value="">-- Select Plan --</option>
                    <?php foreach ($pricingPlans as $plan): ?>
                        <option value="<?= esc($plan->name) ?>"
                            <?= old('plan_name', $subscription->plan_name) === $plan->name ? 'selected' : '' ?>>
                            <?= esc($plan->name) ?> (NPR <?= esc(number_format((float) $plan->price_monthly, 2)) ?>/mo)
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="text"
                       id="plan_name"
                       name="plan_name"
                       class="form-control"
                       value="<?= esc(old('plan_name', $subscription->plan_name)) ?>"
                       placeholder="Enter plan name"
                       required>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="billing_cycle">Billing Cycle <span class="required">*</span></label>
            <select id="billing_cycle" name="billing_cycle" class="form-control" required>
                <option value="monthly" <?= old('billing_cycle', $subscription->billing_cycle) === 'monthly' ? 'selected' : '' ?>>Monthly</option>
                <option value="annual" <?= old('billing_cycle', $subscription->billing_cycle) === 'annual' ? 'selected' : '' ?>>Annual</option>
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount (NPR) <span class="required">*</span></label>
            <input type="number"
                   id="amount"
                   name="amount"
                   class="form-control"
                   value="<?= esc(old('amount', $subscription->amount)) ?>"
                   step="0.01"
                   min="0"
                   placeholder="0.00"
                   required>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date <span class="required">*</span></label>
            <input type="date"
                   id="start_date"
                   name="start_date"
                   class="form-control"
                   value="<?= esc(old('start_date', $subscription->start_date)) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date"
                   id="end_date"
                   name="end_date"
                   class="form-control"
                   value="<?= esc(old('end_date', $subscription->end_date)) ?>">
        </div>

        <div class="form-group">
            <label for="status">Status <span class="required">*</span></label>
            <select id="status" name="status" class="form-control" required>
                <option value="active" <?= old('status', $subscription->status) === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="expiring" <?= old('status', $subscription->status) === 'expiring' ? 'selected' : '' ?>>Expiring</option>
                <option value="expired" <?= old('status', $subscription->status) === 'expired' ? 'selected' : '' ?>>Expired</option>
                <option value="cancelled" <?= old('status', $subscription->status) === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Subscription</button>
            <a href="<?= site_url("/admin/subscriptions/{$subscription->id}") ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
