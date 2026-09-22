<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$data = loadData();
$pageTitle = 'Mostrar Sprint';
$id = (int) ($_GET['id'] ?? 0);
if ($id === null) {
    http_response_code(400);
    exit('Sprint');
}
$sprint = findRecord($data['sprints'], $id);

if (!$sprint) {
    http_response_code(404);
    exit('Sprint no trobat');
}

require __DIR__ . '/../includes/header.php';
?>

<div class="row g-3">
        <div class="col-md-6">
            <div class="card m-2">
                <div class="card-body">
                    <a href="sprint.php"><h4><?php echo h($sprint["name"])?></h4></a>
                    <p><?php echo h($sprint["name"])?></p>
                    <p><?php echo h($sprint["goal"])?></p>
                    <p><?php echo h($sprint["start_date"])?></p>
                    <p><?php echo h($sprint["end_date"])?></p>
                    <p><?php echo h($sprint["status"])?></p>
                </div>
            </div>
        </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>