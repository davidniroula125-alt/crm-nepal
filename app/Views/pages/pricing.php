<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="hero" style="text-align:center;">
    <div class="container">
        <h1>Simple, Transparent Pricing</h1>
        <p style="max-width:560px;margin:0 auto 28px;">No hidden fees. No long-term contracts. Choose the plan that fits your agency.</p>
        <div class="pricing-toggle" style="display:inline-flex;align-items:center;gap:12px;margin-bottom:10px;">
            <span id="label-monthly" style="font-weight:600;color:var(--color-primary);">Monthly</span>
            <label class="toggle" style="position:relative;width:48px;height:26px;cursor:pointer;">
                <input type="checkbox" id="billing-toggle" style="opacity:0;width:0;height:0;">
                <span class="toggle__slider" style="position:absolute;inset:0;background:var(--color-border);border-radius:26px;transition:.2s;"></span>
                <span class="toggle__knob" style="position:absolute;top:3px;left:3px;width:20px;height:20px;background:#fff;border-radius:50%;transition:.2s;box-shadow:var(--shadow-sm);"></span>
            </label>
            <span id="label-annual" style="font-weight:500;color:var(--color-text-muted);">Annual <span style="color:var(--color-success);font-size:13px;">Save 20%</span></span>
        </div>
    </div>
</section>

<style>
    .pricing-toggle input:checked ~ .toggle__slider { background: var(--color-primary); }
    .pricing-toggle input:checked ~ .toggle__knob { transform: translateX(22px); }
    .pricing-toggle input:checked ~ #label-monthly,
    .pricing-toggle input:not(:checked) ~ #label-annual { font-weight:500;color:var(--color-text-muted); }
</style>

<section class="section" style="padding-top:24px;">
    <div class="container">
        <?php if (! empty($plans)): ?>
        <div class="features-grid" style="grid-template-columns:repeat(<?= count($plans) > 4 ? 4 : count($plans) ?>,1fr);gap:24px;">
            <?php foreach ($plans as $i => $plan): ?>
            <div class="feature-card" style="text-align:center;padding:32px 24px;<?= $i === 1 ? 'border-color:var(--color-primary);' : '' ?>">
                <?php if ($i === 1): ?>
                    <div style="background:var(--color-primary);color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:4px 12px;border-radius:4px;display:inline-block;margin-bottom:12px;">Most Popular</div>
                <?php endif; ?>
                <h3 style="font-size:22px;margin-bottom:4px;"><?= esc($plan->name) ?></h3>
                <p style="color:var(--color-text-muted);font-size:14px;margin-bottom:16px;"><?= esc($plan->description) ?></p>
                <div style="margin-bottom:20px;">
                    <span class="price-monthly" style="font-size:36px;font-weight:700;color:var(--color-primary);">NPR <?= number_format($plan->price_monthly) ?></span>
                    <span class="price-annual" style="font-size:36px;font-weight:700;color:var(--color-primary);display:none;">NPR <?= number_format($plan->price_annual ?? $plan->price_monthly) ?></span>
                    <span class="price-cycle" style="font-size:14px;color:var(--color-text-muted);">/month</span>
                </div>
                <ul style="text-align:left;margin-bottom:24px;">
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Full CRM access</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Lead & customer management</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Sales pipeline</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Tour & booking management</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Payment tracking</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Reports & analytics</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Email support</li>
                </ul>
                <a href="<?= site_url('request-a-demo') ?>" class="btn <?= $i === 1 ? 'btn-primary' : 'btn-outline' ?>" style="width:100%;">Get Started</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="features-grid" style="grid-template-columns:repeat(3,1fr);gap:24px;">
            <?php
            $placeholderPlans = [
                ['name' => 'Starter', 'monthly' => 2999, 'annual' => 2399, 'desc' => 'For small agencies just getting started.'],
                ['name' => 'Professional', 'monthly' => 5999, 'annual' => 4799, 'desc' => 'For growing travel businesses.'],
                ['name' => 'Enterprise', 'monthly' => 12999, 'annual' => 10399, 'desc' => 'For large operations and DMCs.'],
            ];
            foreach ($placeholderPlans as $i => $plan): ?>
            <div class="feature-card" style="text-align:center;padding:32px 24px;<?= $i === 1 ? 'border-color:var(--color-primary);' : '' ?>">
                <?php if ($i === 1): ?>
                    <div style="background:var(--color-primary);color:#fff;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:4px 12px;border-radius:4px;display:inline-block;margin-bottom:12px;">Most Popular</div>
                <?php endif; ?>
                <h3 style="font-size:22px;margin-bottom:4px;"><?= esc($plan['name']) ?></h3>
                <p style="color:var(--color-text-muted);font-size:14px;margin-bottom:16px;"><?= esc($plan['desc']) ?></p>
                <div style="margin-bottom:20px;">
                    <span class="price-monthly" style="font-size:36px;font-weight:700;color:var(--color-primary);">NPR <?= number_format($plan['monthly']) ?></span>
                    <span class="price-annual" style="font-size:36px;font-weight:700;color:var(--color-primary);display:none;">NPR <?= number_format($plan['annual']) ?></span>
                    <span class="price-cycle" style="font-size:14px;color:var(--color-text-muted);">/month</span>
                </div>
                <ul style="text-align:left;margin-bottom:24px;">
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Full CRM access</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Lead & customer management</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Sales pipeline</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Reports & analytics</li>
                    <li style="padding:6px 0;font-size:14px;color:var(--color-text-muted);">✓ Email support</li>
                </ul>
                <a href="<?= site_url('request-a-demo') ?>" class="btn <?= $i === 1 ? 'btn-primary' : 'btn-outline' ?>" style="width:100%;">Get Started</a>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="section section-alt">
    <div class="container" style="max-width:720px;">
        <div class="section__head">
            <h2>Pricing FAQ</h2>
        </div>
        <div class="faq-list">
            <div class="faq-item" style="margin-bottom:16px;">
                <h4 style="font-size:16px;color:var(--color-primary-dark);margin-bottom:8px;">Can I switch plans anytime?</h4>
                <p style="color:var(--color-text-muted);font-size:14px;">Yes, you can upgrade or downgrade your plan at any time. Changes take effect on your next billing cycle.</p>
            </div>
            <div class="faq-item" style="margin-bottom:16px;">
                <h4 style="font-size:16px;color:var(--color-primary-dark);margin-bottom:8px;">Is there a free trial?</h4>
                <p style="color:var(--color-text-muted);font-size:14px;">We offer a 14-day free trial on all plans. No credit card required.</p>
            </div>
            <div class="faq-item" style="margin-bottom:16px;">
                <h4 style="font-size:16px;color:var(--color-primary-dark);margin-bottom:8px;">What payment methods do you accept?</h4>
                <p style="color:var(--color-text-muted);font-size:14px;">We accept bank transfer, eSewa, Khalti, and international credit/debit cards.</p>
            </div>
            <div class="faq-item" style="margin-bottom:16px;">
                <h4 style="font-size:16px;color:var(--color-primary-dark);margin-bottom:8px;">Are there setup fees?</h4>
                <p style="color:var(--color-text-muted);font-size:14px;">No. All plans include free setup and onboarding assistance.</p>
            </div>
            <div class="faq-item">
                <h4 style="font-size:16px;color:var(--color-primary-dark);margin-bottom:8px;">Do you offer custom plans?</h4>
                <p style="color:var(--color-text-muted);font-size:14px;">Yes, for larger operations and DMCs we can create custom packages with dedicated support. Contact us for details.</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggle = document.getElementById('billing-toggle');
    var monthlyPrices = document.querySelectorAll('.price-monthly');
    var annualPrices = document.querySelectorAll('.price-annual');
    var cycles = document.querySelectorAll('.price-cycle');
    var labelM = document.getElementById('label-monthly');
    var labelA = document.getElementById('label-annual');
    toggle.addEventListener('change', function() {
        var annual = this.checked;
        monthlyPrices.forEach(function(el) { el.style.display = annual ? 'none' : 'inline'; });
        annualPrices.forEach(function(el) { el.style.display = annual ? 'inline' : 'none'; });
        cycles.forEach(function(el) { el.textContent = annual ? '/month (billed annually)' : '/month'; });
        labelM.style.fontWeight = annual ? '500' : '600';
        labelM.style.color = annual ? 'var(--color-text-muted)' : 'var(--color-primary)';
        labelA.style.fontWeight = annual ? '600' : '500';
        labelA.style.color = annual ? 'var(--color-primary)' : 'var(--color-text-muted)';
    });
});
</script>

<?= $this->endSection() ?>
