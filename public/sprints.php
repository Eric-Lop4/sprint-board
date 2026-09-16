<?php

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$data = loadData();
$pageTitle = 'Sprints';
require __DIR__ . '/../includes/header.php';

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Sprints</h1>
    </div>
</div>

<div class="row g-3">
    <?php foreach ($data['sprints'] as $sprints): ?>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="h4"> <?= h($sprints['name']) ?></h2>
                    <p class="text-muted">Objectiu: <?= ($sprints['goal']) ?> membre(s)</p>
                    <p class="text-info"> Data d'inici: <?= ($sprints['start_date']) ?> </p>
                    <p class="text-danger">Data fi: <?= ($sprints['end_date']) ?></p>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>