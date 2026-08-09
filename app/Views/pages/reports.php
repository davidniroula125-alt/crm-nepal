<?= view('layout/header', ['title' => 'Reports']) ?>

<div class="reports-grid">
    <div class="chart-card">
        <h3>Deals by Stage</h3>
        <div class="chart-container">
            <div class="bar-chart">
                <?php foreach ($dealsByStage as $stage => $count): ?>
                <div class="bar-item">
                    <div class="bar-label"><?= ucfirst(str_replace('_', ' ', $stage)) ?></div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width: <?= $count > 0 ? max(10, ($count / max($dealsByStage)) * 100) : 0 ?>%"></div>
                    </div>
                    <div class="bar-value"><?= $count ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="chart-card">
        <h3>Deals by Month</h3>
        <div class="chart-container">
            <div class="bar-chart">
                <?php foreach ($dealsByMonth as $month): ?>
                <div class="bar-item">
                    <div class="bar-label"><?= $month['label'] ?? '' ?></div>
                    <div class="bar-track">
                        <div class="bar-fill bar-blue" style="width: <?= ($month['count'] ?? 0) > 0 ? max(10, (($month['count'] ?? 0) / max(array_column($dealsByMonth, 'count') ?: [1])) * 100) : 0 ?>%"></div>
                    </div>
                    <div class="bar-value"><?= $month['count'] ?? 0 ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="chart-card">
        <h3>Invoices by Status</h3>
        <div class="chart-container">
            <div class="donut-chart">
                <?php
                $totalInvoices = array_sum($invoicesByStatus);
                $colors = ['paid' => '#10B981', 'pending' => '#F59E0B', 'overdue' => '#EF4444'];
                ?>
                <?php foreach ($invoicesByStatus as $status => $count): ?>
                <div class="donut-item">
                    <div class="donut-color" style="background: <?= $colors[$status] ?? '#6B7280' ?>"></div>
                    <span class="donut-label"><?= ucfirst($status) ?></span>
                    <span class="donut-value"><?= $count ?></span>
                    <span class="donut-percent"><?= $totalInvoices > 0 ? round(($count / $totalInvoices) * 100) : 0 ?>%</span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="chart-card">
        <h3>Contacts by Status</h3>
        <div class="chart-container">
            <div class="donut-chart">
                <?php
                $totalContacts = array_sum($contactsByStatus);
                $cColors = ['active' => '#10B981', 'lead' => '#3B82F6', 'prospect' => '#F59E0B', 'customer' => '#8B5CF6'];
                ?>
                <?php foreach ($contactsByStatus as $status => $count): ?>
                <div class="donut-item">
                    <div class="donut-color" style="background: <?= $cColors[$status] ?? '#6B7280' ?>"></div>
                    <span class="donut-label"><?= ucfirst($status) ?></span>
                    <span class="donut-value"><?= $count ?></span>
                    <span class="donut-percent"><?= $totalContacts > 0 ? round(($count / $totalContacts) * 100) : 0 ?>%</span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="section-card">
    <h3>Top Contacts by Value</h3>
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>Name</th><th>Company</th><th>Email</th><th>Value</th></tr>
            </thead>
            <tbody>
                <?php foreach ($topContacts as $i => $contact): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><strong><?= esc($contact['name']) ?></strong></td>
                    <td><?= esc($contact['company_name']) ?></td>
                    <td><?= esc($contact['email']) ?></td>
                    <td><strong><?= format_currency($contact['value']) ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layout/footer') ?>
