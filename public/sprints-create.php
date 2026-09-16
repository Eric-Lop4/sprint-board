<?php
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();
$data = loadData();
$errors = [];
require __DIR__ . '/../includes/header.php';


if($_SERVER["REQUEST_METHOD"] === 'POST'){
    $values[] = $_POST["name"];
    $goal[] = $_POST["goal"];
    $start[] = $_POST["start_date"];
    $end[] = $_POST["end"];
    $status[] = $_POST["status"];

    if (!$errors) {
        $ids = array_column($data['sprints'],'id');
        $data['sprints'][] = ['id' => $ids ? max($ids) + 1 : 1, 'name' => $values['name'], 'goal' => $goal['goal'], 'start_date' => $start['start_date'], 'end_date' => $end['end_date'], 'status' => $status['status']];
        if (saveData($data)) {
            echo("guay");
        }

        $errors[] = 'No s’ha pogut guardar el spring. Intenta-ho de nou.';
    }
}

?>

<div class="row g-3">
    <div class="col-md-3">
        <form method="post">
            <label class="form-label">Name</label>
            <input class="form-control mb-3" type="text" name="name" required/>
            <label class="form-label">Goal</label>
            <input class="form-control mb-3" type="text" name="goal" required/>
            <label class="form-label">Start</label>
            <input class="form-control mb-3" type="date" name="start_date" required/>
            <label class="form-label">End</label>
            <input class="form-control mb-3" type="date" name="end_date" required/>
            <label class="form-label">Status</label>
            <input class="form-control mb-3" type="text" name="status" required/>
            <button class="btn btn-primary">Registrar-me</button>
        </form>

    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
