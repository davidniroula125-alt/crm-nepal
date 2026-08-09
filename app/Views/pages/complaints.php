<?= view('layout/header', ['title' => 'Complaints']) ?>

<div class="page-actions">
    <button class="btn btn-primary" onclick="openComplaintModal()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Submit Complaint
    </button>
</div>

<div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($complaints)): ?>
            <tr><td colspan="6" class="empty-state">No complaints found</td></tr>
            <?php else: ?>
            <?php foreach ($complaints as $complaint): ?>
            <tr>
                <td><strong><?= esc($complaint['name']) ?></strong></td>
                <td><?= esc($complaint['email']) ?></td>
                <td><?= esc($complaint['subject']) ?></td>
                <td><?= status_badge($complaint['status']) ?></td>
                <td><?= date('M d, Y', strtotime($complaint['created_at'])) ?></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-icon" onclick="viewComplaint(<?= htmlspecialchars(json_encode($complaint), ENT_QUOTES) ?>)" title="View">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Complaint Modal -->
<div id="complaintModal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="closeModal('complaintModal')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="complaintModalTitle">Submit Complaint</h3>
            <button class="modal-close" onclick="closeModal('complaintModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="complaintForm" method="POST" action="/complaints/store">
                <div class="form-group">
                    <label>Name *</label>
                    <input type="text" name="name" id="complaintName" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" id="complaintEmail" required>
                </div>
                <div class="form-group">
                    <label>Subject *</label>
                    <input type="text" name="subject" id="complaintSubject" required>
                </div>
                <div class="form-group">
                    <label>Message *</label>
                    <textarea name="message" id="complaintMessage" rows="4" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('complaintModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Complaint Modal -->
<div id="viewComplaintModal" class="modal" style="display:none;">
    <div class="modal-overlay" onclick="closeModal('viewComplaintModal')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Complaint Details</h3>
            <button class="modal-close" onclick="closeModal('viewComplaintModal')">&times;</button>
        </div>
        <div class="modal-body">
            <p><strong>Name:</strong> <span id="viewComplaintName"></span></p>
            <p><strong>Email:</strong> <span id="viewComplaintEmail"></span></p>
            <p><strong>Subject:</strong> <span id="viewComplaintSubject"></span></p>
            <div class="inquiry-message">
                <strong>Message:</strong>
                <p id="viewComplaintMessage"></p>
            </div>
            <div class="reply-section" id="complaintReplySection" style="display:none;">
                <h4>Reply</h4>
                <form method="POST" id="complaintReplyForm">
                    <div class="form-group">
                        <textarea name="reply" rows="4" placeholder="Write your reply..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openComplaintModal() {
    document.getElementById('complaintModal').style.display = 'flex';
}

function viewComplaint(data) {
    document.getElementById('viewComplaintName').textContent = data.name;
    document.getElementById('viewComplaintEmail').textContent = data.email;
    document.getElementById('viewComplaintSubject').textContent = data.subject;
    document.getElementById('viewComplaintMessage').textContent = data.message;
    document.getElementById('viewComplaintModal').style.display = 'flex';
}
</script>

<?= view('layout/footer') ?>
