<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$id = (int) ($_GET['id'] ?? 0);
$data = loadData();
$sprints = findRecord($data['sprints'], $id);

if (!$sprints) {
    http_response_code(404);
    exit('Sprint no trobat. Codi 404');
}
if (!$id) {
    http_response_code(400);
    exit('Codi incorrecte o no trobat. Codi 400');
}

$errors = [];


$pageTitle = $sprints['name'];

require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between">
    <div>
        <h1><?= h($sprints['name']) ?></h1>
        <p><?= h($sprints['goal']) ?></p>
        <p class="text-info"> Data d'inici: <?= ($sprints['start_date']) ?> </p>
        <p class="text-danger">Data fi: <?= ($sprints['end_date']) ?></p>
        <p class="text-muted">
            Estat: <?= h($sprints['status']) ?>
        </p>
    </div>
    <a href="sprints.php" class="btn btn-outline-secondary align-self-start">Tornar</a>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>