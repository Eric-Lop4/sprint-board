<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();
$data = loadData();
$id = (int) ($_GET['id'] ?? 0);
$sprint = findRecord($data['sprints'], $id);

if (!$id == $sprint['id']) {
    http_response_code(404);
    exit('Sprint no trobada');
}
if ($id == null)
    {
        http_response_code(400);
        exit('400');
    }

require __DIR__ . '/../includes/header.php';
?>

    <h3><?=h($sprint["name"]) ?></h3>
    <p><?=h($sprint["goal"]) ?></p>
    <p><?=h($sprint["start_date"]) ?></p>
    <p><?=h($sprint["end_date"]) ?></p>
    <p><?=h($sprint["status"]) ?></p>





<?php require __DIR__ . '/../includes/footer.php'; ?>
