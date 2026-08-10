<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="site-manager">
    <div class="site-manager-header">
        <h2>Site Content Manager</h2>
        <p class="text-muted">Edit all public website content. Changes go live immediately.</p>
    </div>

    <div class="site-manager-layout">
        <!-- Pages Sidebar -->
        <div class="pages-sidebar">
            <div class="pages-sidebar-header">Website Pages</div>
            <?php foreach ($pages as $slug => $label): ?>
                <a href="<?= site_url("/admin/site?page={$slug}") ?>"
                   class="page-nav-item <?= $currentPage === $slug ? 'active' : '' ?>">
                    <span class="page-nav-icon">
                        <?php
                        $icons = [
                            'home' => '&#127968;', 'about' => '&#128100;', 'features' => '&#128736;',
                            'solutions' => '&#128230;', 'pricing' => '&#128176;', 'faq' => '&#10067;',
                            'contact' => '&#9993;', 'demo' => '&#128247;', 'settings' => '&#9881;'
                        ];
                        echo $icons[$slug] ?? '&#128196;';
                        ?>
                    </span>
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Content Editor -->
        <div class="content-editor">
            <form method="POST" action="<?= site_url('/admin/site/update') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="slug" value="<?= esc($currentPage) ?>">

                <div class="editor-card">
                    <div class="editor-header">
                        <h3><?= $pages[$currentPage] ?? 'Page Content' ?></h3>
                        <span class="editor-badge">Live Editing</span>
                    </div>

                    <?php if (empty($content)): ?>
                        <div class="empty-editor">
                            <div class="empty-icon">&#128221;</div>
                            <p>No content sections found for this page yet.</p>
                            <p class="text-muted">Save this page to initialize its default content blocks.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($content as $section => $fields): ?>
                            <div class="content-section">
                                <div class="section-header">
                                    <span class="section-icon">&#9679;</span>
                                    <h4><?= ucwords(str_replace('_', ' ', $section)) ?></h4>
                                </div>

                                <div class="section-fields">
                                    <?php foreach ($fields as $key => $value): ?>
                                        <div class="field-group">
                                            <label class="field-label">
                                                <?= ucwords(str_replace('_', ' ', $key)) ?>
                                            </label>
                                            <?php if (strlen($value) > 120): ?>
                                                <textarea name="content[<?= esc($section) ?>][<?= esc($key) ?>]"
                                                          rows="4"
                                                          class="form-control field-textarea"><?= esc($value) ?></textarea>
                                            <?php else: ?>
                                                <input type="text"
                                                       name="content[<?= esc($section) ?>][<?= esc($key) ?>]"
                                                       value="<?= esc($value) ?>"
                                                       class="form-control field-input">
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="editor-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                        &#10003; Save <?= $pages[$currentPage] ?? 'Content' ?>
                    </button>
                    <a href="<?= site_url("/admin/site?page={$currentPage}") ?>" class="btn btn-outline btn-lg">
                        &#8634; Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.site-manager { padding: 0; }
.site-manager-header { margin-bottom: 24px; }
.site-manager-header h2 { font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 4px; }
.text-muted { color: var(--color-text-muted); font-size: .88rem; }

.site-manager-layout { display: grid; grid-template-columns: 230px 1fr; gap: 24px; }
@media (max-width: 768px) { .site-manager-layout { grid-template-columns: 1fr; } }

.pages-sidebar {
    background: var(--color-card-bg, #fff);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    padding: 8px;
    height: fit-content;
    position: sticky;
    top: 20px;
}
.pages-sidebar-header {
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--color-text-muted);
    padding: 12px 16px 8px;
}
.page-nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 11px 16px;
    border-radius: 8px;
    text-decoration: none;
    color: var(--color-text-muted);
    font-size: .88rem;
    font-weight: 500;
    transition: all .2s;
}
.page-nav-item:hover { background: var(--color-primary-light); color: var(--color-primary); }
.page-nav-item.active { background: var(--color-primary); color: #fff; font-weight: 600; box-shadow: 0 2px 8px rgba(var(--color-primary-rgb, 15,110,99), .25); }
.page-nav-icon { font-size: 1rem; width: 22px; text-align: center; }

.content-editor { min-width: 0; }

.editor-card {
    background: var(--color-card-bg, #fff);
    border: 1px solid var(--color-border);
    border-radius: 12px;
    overflow: hidden;
}
.editor-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 28px;
    border-bottom: 2px solid var(--color-border);
}
.editor-header h3 { font-family: var(--font-heading); font-size: 1.1rem; margin: 0; }
.editor-badge {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 4px 12px;
    border-radius: 20px;
    background: #D4EDDA;
    color: #155724;
}

.empty-editor { text-align: center; padding: 48px 24px; }
.empty-icon { font-size: 2.5rem; margin-bottom: 12px; }
.empty-editor p { margin: 4px 0; font-size: .95rem; }

.content-section {
    padding: 0 28px;
}
.section-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 0 12px;
    border-bottom: 1px solid var(--color-border);
    margin-bottom: 16px;
}
.section-icon { color: var(--color-primary); font-size: .6rem; }
.section-header h4 {
    font-size: .82rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: var(--color-primary);
    margin: 0;
}

.field-group { margin-bottom: 16px; }
.field-label {
    display: block;
    font-size: .82rem;
    font-weight: 600;
    color: var(--color-text);
    margin-bottom: 5px;
}
.form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--color-border);
    border-radius: 8px;
    font-size: .9rem;
    font-family: var(--font-body);
    transition: border-color .2s, box-shadow .2s;
    background: var(--color-card-bg, #fff);
    color: var(--color-text);
}
.form-control:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(var(--color-primary-rgb, 15,110,99), .1);
}
.field-textarea { resize: vertical; min-height: 80px; }

.editor-actions {
    display: flex;
    gap: 12px;
    margin-top: 20px;
    padding: 20px 0 0;
}
.btn-lg { padding: 12px 28px; font-size: .95rem; }
.btn-outline {
    background: transparent;
    border: 1px solid var(--color-border);
    color: var(--color-text);
    padding: 12px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: .95rem;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
}
.btn-outline:hover { background: var(--color-primary-light); border-color: var(--color-primary); color: var(--color-primary); }
</style>

<?= $this->endSection() ?>
