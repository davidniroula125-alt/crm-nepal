<?= view('layout/header', ['title' => 'Inquiries & Support']) ?>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($inquiries)): ?>
            <tr><td colspan="7" class="empty-state">No inquiries found</td></tr>
            <?php else: ?>
            <?php foreach ($inquiries as $inquiry): ?>
            <tr>
                <td><strong><?= esc($inquiry['name']) ?></strong></td>
                <td><?= esc($inquiry['email']) ?></td>
                <td><?= esc($inquiry['subject']) ?></td>
                <td><span class="badge badge-blue"><?= esc(ucfirst($inquiry['type'])) ?></span></td>
                <td><?= status_badge($inquiry['status']) ?></td>
                <td><?= date('M d, Y', strtotime($inquiry['created_at'])) ?></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="viewInquiry(<?= htmlspecialchars(json_encode($inquiry), ENT_QUOTES) ?>)" title="View">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                        <form method="POST" action="/inquiries/updateStatus/<?= $inquiry['id'] ?>" style="display:inline;">
                            <select name="status" onchange="this.form.submit()" class="status-select">
                                <option value="unread" <?= $inquiry['status'] === 'unread' ? 'selected' : '' ?>>Unread</option>
                                <option value="read" <?= $inquiry['status'] === 'read' ? 'selected' : '' ?>>Read</option>
                                <option value="replied" <?= $inquiry['status'] === 'replied' ? 'selected' : '' ?>>Replied</option>
                                <option value="resolved" <?= $inquiry['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                                <option value="closed" <?= $inquiry['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Inquiry Detail Modal -->
<div id="inquiryModal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="closeModal('inquiryModal')"></div>
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3>Inquiry Details</h3>
            <button class="modal-close" onclick="closeModal('inquiryModal')">&times;</button>
        </div>
        <div class="modal-body" id="inquiryDetail">
            <div class="inquiry-info">
                <p><strong>Name:</strong> <span id="inquiryName"></span></p>
                <p><strong>Email:</strong> <span id="inquiryEmail"></span></p>
                <p><strong>Subject:</strong> <span id="inquirySubject"></span></p>
                <p><strong>Date:</strong> <span id="inquiryDate"></span></p>
                <div class="inquiry-message">
                    <strong>Message:</strong>
                    <p id="inquiryMessage"></p>
                </div>
            </div>
            <div class="reply-section">
                <h4>Reply</h4>
                <form method="POST" id="replyForm">
                    <div class="form-group">
                        <textarea name="reply" id="replyText" rows="4" placeholder="Write your reply..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function viewInquiry(data) {
    document.getElementById('inquiryName').textContent = data.name;
    document.getElementById('inquiryEmail').textContent = data.email;
    document.getElementById('inquirySubject').textContent = data.subject;
    document.getElementById('inquiryDate').textContent = data.created_at;
    document.getElementById('inquiryMessage').textContent = data.message;
    document.getElementById('replyForm').action = '/inquiries/reply/' + data.id;
    document.getElementById('inquiryModal').style.display = 'flex';
}
</script>

<?= view('layout/footer') ?>
