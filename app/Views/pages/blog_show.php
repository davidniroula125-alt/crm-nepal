<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="section" style="padding-top:48px;">
    <div class="container" style="max-width:780px;">

        <!-- Breadcrumb -->
        <div style="margin-bottom:24px;font-size:14px;">
            <a href="<?= site_url('blog') ?>" style="color:var(--color-primary);">Blog</a>
            <?php if (! empty($post->category_name)): ?>
            <span style="color:var(--color-text-muted);"> / </span>
            <a href="<?= site_url('blog/category/' . esc($post->category_slug)) ?>" style="color:var(--color-primary);"><?= esc($post->category_name) ?></a>
            <?php endif; ?>
        </div>

        <!-- Title -->
        <h1 style="font-size:34px;color:var(--color-primary-dark);margin-bottom:16px;"><?= esc($post->title) ?></h1>

        <!-- Meta -->
        <div style="display:flex;gap:20px;flex-wrap:wrap;font-size:14px;color:var(--color-text-muted);margin-bottom:32px;padding-bottom:24px;border-bottom:1px solid var(--color-border);">
            <?php if (! empty($post->author_name)): ?>
            <span>By <?= esc($post->author_name) ?></span>
            <?php endif; ?>
            <span><?= date('F d, Y', strtotime($post->published_at ?? $post->created_at)) ?></span>
            <?php if (! empty($post->category_name)): ?>
            <span style="color:var(--color-primary);"><?= esc($post->category_name) ?></span>
            <?php endif; ?>
        </div>

        <!-- Featured Image -->
        <?php if (! empty($post->featured_image)): ?>
        <div style="margin-bottom:32px;border-radius:var(--radius-md);overflow:hidden;">
            <img src="<?= esc($post->featured_image) ?>" alt="<?= esc($post->title) ?>" style="width:100%;display:block;">
        </div>
        <?php else: ?>
        <div style="margin-bottom:32px;border-radius:var(--radius-md);background:var(--color-primary-light);aspect-ratio:16/9;display:flex;align-items:center;justify-content:center;color:var(--color-primary);font-size:14px;">
            Featured Image
        </div>
        <?php endif; ?>

        <!-- Body -->
        <div style="font-size:16px;line-height:1.8;color:var(--color-text);">
            <?= $post->body ?>
        </div>

        <!-- Tags -->
        <?php if (! empty($post->tags)): ?>
        <div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--color-border);">
            <strong style="font-size:14px;">Tags:</strong>
            <?php
            $tags = array_map('trim', explode(',', $post->tags));
            foreach ($tags as $tag):
            ?>
            <span style="display:inline-block;padding:4px 12px;background:var(--color-primary-light);color:var(--color-primary);border-radius:20px;font-size:12px;font-weight:500;margin:4px 4px 0 0;"><?= esc($tag) ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Social Sharing -->
        <div style="margin-top:24px;padding-top:24px;border-top:1px solid var(--color-border);display:flex;align-items:center;gap:12px;">
            <span style="font-size:14px;font-weight:600;">Share:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:var(--color-primary-light);color:var(--color-primary);font-size:14px;font-weight:700;">f</a>
            <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($post->title) ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:var(--color-primary-light);color:var(--color-primary);font-size:14px;font-weight:700;">t</a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode(current_url()) ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:var(--color-primary-light);color:var(--color-primary);font-size:14px;font-weight:700;">in</a>
            <a href="mailto:?subject=<?= urlencode($post->title) ?>&body=<?= urlencode(current_url()) ?>" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:50%;background:var(--color-primary-light);color:var(--color-primary);font-size:14px;font-weight:700;">@</a>
        </div>

        <!-- Back link -->
        <div style="margin-top:32px;">
            <a href="<?= site_url('blog') ?>" class="btn btn-outline" style="font-size:14px;">← Back to Blog</a>
        </div>
    </div>
</section>

<!-- Related Posts -->
<?php if (! empty($related)): ?>
<section class="section section-alt">
    <div class="container">
        <div class="section__head">
            <h2>Related Articles</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;">
            <?php foreach ($related as $rel): ?>
            <article class="feature-card" style="padding:0;overflow:hidden;">
                <div style="aspect-ratio:16/9;background:var(--color-primary-light);display:flex;align-items:center;justify-content:center;color:var(--color-primary);font-size:13px;">
                    Featured Image
                </div>
                <div style="padding:20px;">
                    <?php if (! empty($rel->category_name)): ?>
                    <span style="font-size:12px;font-weight:600;color:var(--color-primary);text-transform:uppercase;letter-spacing:.04em;"><?= esc($rel->category_name) ?></span>
                    <?php endif; ?>
                    <h3 style="font-size:16px;margin:8px 0;">
                        <a href="<?= site_url('blog/' . esc($rel->slug)) ?>" style="color:var(--color-primary-dark);"><?= esc($rel->title) ?></a>
                    </h3>
                    <p style="font-size:13px;color:var(--color-text-muted);margin-bottom:12px;"><?= esc($rel->excerpt) ?></p>
                    <span style="font-size:12px;color:var(--color-text-muted);"><?= date('M d, Y', strtotime($rel->published_at)) ?></span>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?= $this->endSection() ?>
