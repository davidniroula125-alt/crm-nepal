<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="hero" style="text-align:center;">
    <div class="container">
        <h1>Blog &amp; Resources</h1>
        <p style="max-width:520px;margin:0 auto 28px;">Insights, guides and news for travel businesses in Nepal — from CRM tips to digital transformation.</p>
    </div>
</section>

<section class="section" style="padding-top:32px;">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 280px;gap:40px;align-items:start;">

            <!-- Posts Grid -->
            <div>
                <?php if (! empty($posts)): ?>
                <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:24px;">
                    <?php foreach ($posts as $post): ?>
                    <article class="feature-card" style="padding:0;overflow:hidden;">
                        <div style="aspect-ratio:16/9;background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary);font-size:13px;">
                            <?= $post->featured_image ? '<img src="' . esc($post->featured_image) . '" alt="" style="width:100%;height:100%;object-fit:cover;">' : 'Featured Image' ?>
                        </div>
                        <div style="padding:20px;">
                            <?php if (! empty($post->category_name)): ?>
                            <span style="font-size:12px;font-weight:600;color:var(--color-primary);text-transform:uppercase;letter-spacing:.04em;"><?= esc($post->category_name) ?></span>
                            <?php endif; ?>
                            <h3 style="font-size:17px;margin:8px 0 8px;">
                                <a href="<?= site_url('blog/' . esc($post->slug)) ?>" style="color:var(--color-primary-dark);"><?= esc($post->title) ?></a>
                            </h3>
                            <p style="font-size:14px;color:var(--color-text-muted);margin-bottom:12px;"><?= esc($post->excerpt) ?></p>
                            <div style="display:flex;justify-content:space-between;font-size:12px;color:var(--color-text-muted);">
                                <span><?= esc($post->author_name ?? 'Admin') ?></span>
                                <span><?= date('M d, Y', strtotime($post->published_at ?? $post->created_at)) ?></span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if (isset($total) && $total > $perPage): ?>
                <div style="display:flex;justify-content:center;gap:8px;margin-top:32px;">
                    <?php
                    $totalPages = ceil($total / $perPage);
                    for ($p = 1; $p <= $totalPages; $p++):
                    ?>
                    <a href="<?= site_url(current_url() . '?page=' . $p) ?>" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:var(--radius-sm);border:1px solid var(--color-border);font-size:14px;font-weight:500;<?= ($currentPage ?? 1) === $p ? 'background:var(--color-primary);color:#fff;border-color:var(--color-primary);' : 'background:#fff;color:var(--color-text);' ?>"><?= $p ?></a>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <div style="text-align:center;padding:60px 0;">
                    <p style="color:var(--color-text-muted);font-size:16px;">No blog posts published yet. Check back soon!</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside>
                <div style="background:#fff;border:1px solid var(--color-border);border-radius:var(--radius-md);padding:24px;">
                    <h4 style="font-size:16px;color:var(--color-primary-dark);margin-bottom:16px;">Categories</h4>
                    <?php if (! empty($categories)): ?>
                    <ul>
                        <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?= site_url('blog/category/' . esc($cat->slug)) ?>" style="display:block;padding:6px 0;font-size:14px;color:var(--color-text-muted);border-bottom:1px solid var(--color-border);"><?= esc($cat->name) ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p style="font-size:14px;color:var(--color-text-muted);">No categories yet.</p>
                    <?php endif; ?>
                </div>

                <div style="background:#fff;border:1px solid var(--color-border);border-radius:var(--radius-md);padding:24px;margin-top:20px;">
                    <h4 style="font-size:16px;color:var(--color-primary-dark);margin-bottom:12px;">Subscribe to Updates</h4>
                    <p style="font-size:13px;color:var(--color-text-muted);margin-bottom:12px;">Get the latest articles and guides delivered to your inbox.</p>
                    <form method="post" action="#">
                        <input type="email" placeholder="Your email address" style="width:100%;margin-bottom:8px;" required>
                        <button type="submit" class="btn btn-primary" style="width:100%;font-size:14px;padding:10px 16px;">Subscribe</button>
                    </form>
                </div>
            </aside>

        </div>
    </div>
</section>

<style>
@media (max-width:900px) {
    .section .container > div { grid-template-columns:1fr !important; }
}
</style>

<?= $this->endSection() ?>
