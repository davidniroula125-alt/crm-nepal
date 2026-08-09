<?= view('layout/header', ['title' => 'Settings']) ?>

<div class="form-container">
    <form method="POST" action="/settings/update" class="form-card">
        <?php if (session()->get('success')): ?>
        <div class="alert alert-success">
            <?= session()->get('success') ?>
        </div>
        <?php endif; ?>
        
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?= esc($user['name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?= esc($user['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="language">Language</label>
                <select id="language" name="language">
                    <option value="en" <?= ($user['language'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                    <option value="ne" <?= ($user['language'] ?? '') === 'ne' ? 'selected' : '' ?>>Nepali</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">New Password (leave blank to keep current)</label>
                <input type="password" id="password" name="password" minlength="6">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>

<?= view('layout/footer') ?>
