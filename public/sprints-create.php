<?php
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();
$data = loadData();
$errors = [];
$values =   [ 
            'name'          => '',
            'goal'          => '',
            'start_date'    => '',
            'end_date'      => '', 
            'status'        => ''
            ];
require __DIR__ . '/../includes/header.php';


if($_SERVER["REQUEST_METHOD"] === 'POST'){
    $values['name'] = $_POST["name"] ?? '';
    $values['goal'] = $_POST["goal"] ?? '';
    $values['start_date'] = $_POST["start_date"] ?? '';
    $values['end_date'] = $_POST["end_date"] ?? '';
    $values['status'] = $_POST["status"] ?? '';

    $errors = isFilled($values, $errors);
    $errors = validationString($values,$errors);
    $errors = validateDate($values, $errors);


    if (!$errors) {
        $ids = array_column($data['sprints'],'id');
        $data['sprints'][] = [
            'id'            => $ids ? max($ids) + 1 : 1,
            'name'          => $values["name"],
            'goal'          => $values["goal"],
            'start_date'    => $values["start_date"],
            'end_date'      => $values["end_date"],
            'status'        => $values["status"]
            ];
        
        if (saveData($data)) {
            redirect("index.php");
        };

        $errors[] = 'No s’ha pogut guardar el spring. Intenta-ho de nou.';
    }
}

?>

<div class="row g-3">
    <div class="col-md-12">
        <form method="post" novalidate>
            <label class="form-label">Name</label>
            <input class="form-control mb-3" type="text" name="name" value="<?= h($values['name'], ENT_QUOTES, 'UTF-8') ?>"/>
            <label class="form-label">Goal</label>
            <input class="form-control mb-3" type="text" name="goal" value="<?= h($values['goal'], ENT_QUOTES, 'UTF-8') ?>"/>
            <label class="form-label">Start</label>
            <input class="form-control mb-3" type="date" name="start_date" value="<?= h($values['start_date'], ENT_QUOTES, 'UTF-8') ?>"/>
            <label class="form-label">End</label>
            <input class="form-control mb-3" type="date" name="end_date" value="<?= h($values['end_date'], ENT_QUOTES, 'UTF-8') ?>"/>
            <label class="form-label">Status</label>
            <input class="form-control mb-3" type="text" name="status" value="<?= h($values['status'], ENT_QUOTES, 'UTF-8') ?>"/>
            <button class="btn btn-primary">Registrar-me</button>
            <?php if($errors !== []): ?>
                <?php foreach($errors as $e): ?>
                    <p class="text-danger"><?=h($e)?> </p>
                <?php endforeach;?>
            <?php endif;?>
        </form>

    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
