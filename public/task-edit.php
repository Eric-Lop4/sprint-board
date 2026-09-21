<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require __DIR__ . '/../includes/header.php';
$data = loadData();
$id = (int) ($_GET['id'] ?? 0);
$taska = findRecord($data['tasks'], $id);
?>


<?php require __DIR__ . '/../includes/footer.php'; ?>
