<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . '/../includes/data.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';
requireAuth();

$data = loadData();
$errors = [];
$id = (int) ($_GET['id'] ?? 0);
$task = findRecord($data['tasks'], $id);

if (!$task) {
    http_response_code(404);
    exit('Tasca no trobada');
}

$title = (string) ($task['title'] ?? '');
$description = (string) ($task['description'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim((string) ($_POST['title'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));

    if (!validCsrf()) {
        $errors[] = 'La sessió no és vàlida.';
    }
    if ($title === '') {
        $errors[] = 'El títol és obligatori.';
    }
    if ($description === '') {
        $errors[] = 'La descripció és obligatòria.';
    }

    if (!$errors) {
        foreach ($data['tasks'] as $key => $savedTask) {
            if ((int) $savedTask['id'] === $id) {
                $data['tasks'][$key]['title'] = $title;
                $data['tasks'][$key]['description'] = $description;
                break;
            }
        }

        if (saveData($data)) {
            redirect('board.php');
        }

        $errors[] = 'No s’ha pogut guardar la tasca. Intenta-ho de nou.';
    }
}
$pageTitle = 'Editar tasca';
require __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-7">
        <h1>Editar tasca</h1>

        <?php foreach ($errors as $error): ?>
            <div class="alert alert-danger"><?= h($error) ?></div>
        <?php endforeach; ?>

        <form method="post" class="card card-body">
            <input type="hidden" name="csrf" value="<?= h(csrfToken()) ?>">

            <label class="form-label">Títol</label>
            <input class="form-control mb-3" name="title" value="<?= h($title) ?>" required>

            <label class="form-label">Descripció</label>
            <textarea class="form-control mb-3" name="description" rows="4" required><?= h($description) ?></textarea>

            <button class="btn btn-primary">Guardar canvis</button>
            <a href="board.php" class="btn btn-outline-secondary">Cancel·lar</a>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>