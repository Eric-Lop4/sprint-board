<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$errors = [];
$data = loadData();
$pageTitle = 'SprintsCreate';
require __DIR__ . '/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['name'] = ($_POST['name'] ?? '');
    $values['goal'] =  ($_POST['goal'] ?? '');
    $values['start_date'] = ($_POST['start_date'] ?? '');
    $values['end_date'] = ($_POST['end_date'] ?? '');
    $values['status'] = ($_POST['status'] ?? ''); 

if (!$errors) {
        $ids = array_column($data['sprints'], 'id');
        $data['sprints'][] = ['id' => $ids ? max($ids) + 1 : 1, 'name' => $values['name'], 'goal' => $values['goal'], 'start_date' => $values['start_date'], 'end_date' => $values['end_date'], 'status' => $values['status']];
        if (saveData($data)) {
            redirect('sprints.php');
        }

        $errors[] = 'No s’ha pogut guardar el compte. Intenta-ho de nou.';
    }
}



?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-primary fw-semibold mb-1"></p>
        <h1>Create a sprint</h1>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <form method="post">

            <label class="form-label">name</label>
            <input class="form-control mb-3" type="text" name="name" required>

            <label class="form-label">goal</label>
            <input class="form-control mb-3" type="text" name="goal" required>

            <label class="form-label">start_date</label>
            <input class="form-control mb-3" type="date" name="start_date" required>

            <label class="form-label">end_date</label>
            <input class="form-control mb-3" type="date" name="end_date" required>

            <label class="form-label">status</label>
            <input class="form-control mb-3" type="text" name="status" required>

            <button class="btn btn-primary">Enviar</button>

        </form>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>