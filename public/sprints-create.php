<?php

declare(strict_types=1);
session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();
$errors = [];

$data = loadData();
$values = ['name' => '', 'goal' => '', 'start_date' => '',  'end_date' => '', 'status' => ''];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['name'] = trim((string) ($_POST['name'] ?? ''));
    $values['goal'] = trim((string) ($_POST['goal'] ?? ''));
    $values['start_date'] = trim((string) ($_POST['start_date'] ?? ''));
    $values['end_date'] = trim((string) ($_POST['end_date'] ?? ''));
    $values['status'] = trim((string) ($_POST['status'] ?? ''));


    if ($values['name'] === '') $errors[] = 'El nom és obligatori.';
    if ($values['goal'] === '') $errors[] = 'Posar un objectiu és obligatori.';
    if ($values['start_date'] === '') $errors[] = 'Has de posar una data de inici.';
    if ($values['end_date'] === '') $errors[] = 'Has de posar una data de fi.';

    $inici = DateTime::createFromFormat(
        'Y-m-d',
        $_POST['start_date'] ?? ''
    );
    $fi = DateTime::createFromFormat(
        'Y-m-d',
        $_POST['end_date'] ?? ''
    );

    if ($inici !== false && $fi !== false && $fi < $inici) {
        $errors[] = 'La data de finalització no pot ser anterior a la
        d\'inici.';
    }



    if ($values['status'] === '') $errors[] = 'Defineix el status';


    if (!$errors) {
        $data['sprints'][] = [
            'id' => $data['next_ids']['sprints']++,
            'name' => $values['name'],
            'goal' => $values['goal'],
            'start_date' => $values['start_date'],
            'end_date' => $values['end_date'],
            'status' => $values['status']
        ];

        if (saveData($data)) {
            redirect('sprints.php');
        }

        $errors[] = 'No s’ha pogut guardar el sprint. Intenta-ho de nou.';
    }
}
$pageTitle = 'Nou sprint';
require __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Nou sprint</h1>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endforeach; ?>

        <form method="post" class="card card-body" novalidate>
            <input type="hidden" name="csrf" value="<?= h(csrfToken()) ?>">

            <label class="form-label">Nom</label>
            <input class="form-control mb-3" name="name" value="<?= h($values['name']) ?>" required>

            <label class="form-label">Objectiu</label>
            <textarea class="form-control mb-3" name="goal" rows="4" required><?= h($values['goal']) ?></textarea>


            <label class="form-label">Data d'inici</label>
            <input type="date" class="form-control mb-3" name="start_date" required><?= h($values['start_date']) ?></date>

            <label class="form-label">Data fi</label>
            <input type="date" class="form-control mb-3" name="end_date" required><?= h($values['end_date']) ?></date>

            <label class="form-label">Estat</label>
            <input type="radio" id="active" name="status" value="active">
            <label for="active">Actiu</label>

            <input type="radio" class="" id="inactive" name="status" value="inactive">
            <label for="inactive">Inactiu</label>



            <button class="btn btn-primary">Crear sprint</button>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>