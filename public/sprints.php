<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$data = loadData();
$pageTitle = 'Sprint';
require __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1"></p>
        <h1>Sprints</h1>
        <a class="btn btn-primary" href="sprints-create.php"> Create new sprint</a>
    </div>
</div>

<div class="row g-3">
        <div class="col-md-6">
            <?php foreach($data["sprints"] as $s):?>
            <div class="card m-2">
                <div class="card-body">
                    <a href="sprint.php?id=<?php echo ($s["id"])?>">
                    <h4><?php echo($s["name"])?></h4>
                </a>
                    <p><?php echo($s["goal"])?></p>
                    <p><?php echo($s["start_date"])?></p>
                    <p><?php echo($s["end_date"])?></p>
                    <p><?php echo($s["status"])?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
