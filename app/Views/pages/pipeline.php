<?= view('layout/header', ['title' => 'Pipeline']) ?>

<div class="page-actions">
    <button class="btn btn-primary" onclick="openDealModal()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Deal
    </button>
</div>

<div class="kanban-board">
    <?php
    $stageLabels = [
        'lead' => 'Leads',
        'proposals' => 'Proposals',
        'negotiation' => 'Negotiation',
        'closed_won' => 'Closed Won',
        'closed_lost' => 'Closed Lost',
    ];
    $stageColors = [
        'lead' => '#3B82F6',
        'proposals' => '#F59E0B',
        'negotiation' => '#F97316',
        'closed_won' => '#10B981',
        'closed_lost' => '#EF4444',
    ];
    ?>
    <?php foreach ($stages as $stage => $deals): ?>
    <div class="kanban-column" data-stage="<?= $stage ?>">
        <div class="kanban-header" style="border-top: 3px solid <?= $stageColors[$stage] ?>">
            <h3><?= $stageLabels[$stage] ?></h3>
            <span class="kanban-count"><?= count($deals) ?></span>
        </div>
        <div class="kanban-cards" data-stage="<?= $stage ?>" ondrop="drop(event)" ondragover="allowDrop(event)">
            <?php foreach ($deals as $deal): ?>
            <div class="kanban-card" draggable="true" ondragstart="drag(event)" data-id="<?= $deal['id'] ?>">
                <h4><?= esc($deal['title']) ?></h4>
                <p class="deal-value"><?= format_currency($deal['value']) ?></p>
                <div class="deal-actions">
                    <button class="btn-icon" onclick="editDeal(<?= $deal['id'] ?>, '<?= esc($deal['title']) ?>', '<?= esc($deal['stage']) ?>', <?= $deal['value'] ?>)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <a href="/pipeline/delete/<?= $deal['id'] ?>" class="btn-icon btn-danger" onclick="return confirm('Delete this deal?')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Deal Modal -->
<div id="dealModal" class="modal">
    <div class="modal-overlay" onclick="closeModal('dealModal')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="dealModalTitle">Add Deal</h3>
            <button class="modal-close" onclick="closeModal('dealModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="dealForm" method="POST" action="/pipeline/store">
                <input type="hidden" name="deal_id" id="dealId">
                <div class="form-group">
                    <label for="dealTitle">Deal Title *</label>
                    <input type="text" id="dealTitle" name="title" required>
                </div>
                <div class="form-group">
                    <label for="dealContact">Contact</label>
                    <select id="dealContact" name="contact_id">
                        <option value="">Select Contact</option>
                        <?php foreach ($contacts as $contact): ?>
                        <option value="<?= $contact['id'] ?>"><?= esc($contact['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dealValue">Value (NPR)</label>
                    <input type="number" id="dealValue" name="value" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label for="dealStage">Stage</label>
                    <select id="dealStage" name="stage">
                        <option value="lead">Lead</option>
                        <option value="proposals">Proposals</option>
                        <option value="negotiation">Negotiation</option>
                        <option value="closed_won">Closed Won</option>
                        <option value="closed_lost">Closed Lost</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('dealModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="dealSubmitBtn">Create Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openDealModal(title, stage, value, dealId) {
    document.getElementById('dealModalTitle').textContent = dealId ? 'Edit Deal' : 'Add Deal';
    document.getElementById('dealTitle').value = title || '';
    document.getElementById('dealStage').value = stage || 'lead';
    document.getElementById('dealValue').value = value || 0;
    document.getElementById('dealId').value = dealId || '';
    document.getElementById('dealForm').action = dealId ? '/pipeline/update/' + dealId : '/pipeline/store';
    document.getElementById('dealSubmitBtn').textContent = dealId ? 'Update Deal' : 'Create Deal';
    document.getElementById('dealModal').style.display = 'flex';
}

function editDeal(id, title, stage, value) {
    openDealModal(title, stage, value, id);
}
</script>

<?= view('layout/footer') ?>
