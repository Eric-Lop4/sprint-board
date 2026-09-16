<?php
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();
$data = loadData();

require __DIR__ . '/../includes/header.php';
?>
    <h1>Sprints disponibles</h1>
    <button></button>
        <div class="row g-3">
    <?php foreach ($data['sprints'] as $sp): ?>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body flex justify-content-center">
                    <h4 class="h4"><?= h($sp['name']) ?></h4>
                    <p class="h4"><?= h($sp['goal']) ?></p>
                    <p class="h4"><?= h($sp['start_date']) ?></p>
                    <p class="h4"><?= h($sp['end_date']) ?></p>
                    <p class="h4"><?= h($sp['status']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>