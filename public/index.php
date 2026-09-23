<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$data = loadData();
$user = currentUser();
$sprint = activeSprint($data['sprints'] ?? []);
$sprintTasks = array_filter(
    $data['tasks'] ?? [],
    static fn (array $task): bool => $sprint !== null
        && (int) ($task['sprint_id'] ?? 0) === (int) $sprint['id']
);
$counts = array_count_values(array_column($sprintTasks, 'status'));
$pageTitle = 'Inici';
$visit_count = (int) ($_SESSION['visit_count'] ?? 0) + 1;
$_SESSION['visit_count'] = $visit_count;
require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1">Has visitat aquesta pàgina <?= $visit_count ?> vegades</p>
        <p class="text-primary fw-semibold mb-1">PANELL DE TREBALL</p>
        <h1>Hola, <?= h($user['name'] . " " . h($user['email'])) ?></h1>
    </div>
    <a class="btn btn-primary" href="task-create.php">+ Nova tasca</a>
</div>

<?php if ($sprint): ?>
    <div class="card mb-4 border-primary">
        <div class="card-body">
            <span class="badge text-bg-success float-end">Actiu</span>
            <h2 class="h4"><?= h($sprint['name']) ?></h2>
            <p class="mb-1"><?= h($sprint['goal']) ?></p>
            <small class="text-muted">
                <?= h($sprint['start_date']) ?> → <?= h($sprint['end_date']) ?>
            </small>
        </div>
    </div>
<?php endif; ?>

<div class="row g-3 mb-4">
    <?php foreach (['todo' => 'To do', 'in_progress' => 'In progress', 'done' => 'Done'] as $key => $label): ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted"><?= $label ?></small>
                    <div class="display-6"><?= (int) ($counts[$key] ?? 0) ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<a class="btn btn-outline-dark" href="board.php">Obrir tauler Kanban</a>

<?php require __DIR__ . '/../includes/footer.php'; ?>
