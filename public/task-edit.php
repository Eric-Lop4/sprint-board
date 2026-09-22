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
$status = (string) ($task['status'] ?? 'todo');
$sprintId = (string) ($task['sprint_id'] ?? '');
$teamId = (string) ($task['team_id'] ?? '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim((string) ($_POST['title'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));
    $status = (string) ($_POST['status'] ?? '');
    $sprintId = (string) ($_POST['sprint_id'] ?? '');
    $teamId = (string) ($_POST['team_id'] ?? '');

    if (!validCsrf()) {
        $errors[] = 'La sessió no és vàlida.';
    }
    if ($title === '') {
        $errors[] = 'El títol és obligatori.';
    }
    if ($description === '') {
        $errors[] = 'La descripció és obligatòria.';
    }
    if (!in_array($status, ['todo', 'in_progress', 'done'], true)) {
        $errors[] = 'L’estat seleccionat no és vàlid.';
    }
    if ($sprintId === '' || findRecord($data['sprints'] ?? [], (int) $sprintId) === null) {
        $errors[] = 'El sprint seleccionat no existeix.';
    }
    if ($teamId !== '' && findRecord($data['teams'] ?? [], (int) $teamId) === null) {
        $errors[] = 'L’equip seleccionat no existeix.';
    }

    if (!$errors) {
        foreach ($data['tasks'] as $key => $task) {
            if ((int) $task['id'] === $id) {
                $data['tasks'][$key]['title'] = $title;
                $data['tasks'][$key]['description'] = $description;
                $data['tasks'][$key]['status'] = $status;
                $data['tasks'][$key]['sprint_id'] = (int) $sprintId;
                $data['tasks'][$key]['team_id'] = $teamId === '' ? null : (int) $teamId;
                break;
            }
        }

        if (saveData($data)) {
            redirect('task.php?id=' . $id);
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

            <label class="form-label" for="status">Estat</label>
            <select class="form-select mb-3" id="status" name="status">
                <option value="todo" <?= $status === 'todo' ? 'selected' : '' ?>>To do</option>
                <option value="in_progress" <?= $status === 'in_progress' ? 'selected' : '' ?>>In progress</option>
                <option value="done" <?= $status === 'done' ? 'selected' : '' ?>>Done</option>
            </select>

            <label class="form-label" for="sprint_id">Sprint</label>
            <select class="form-select mb-3" id="sprint_id" name="sprint_id">
                <?php foreach ($data['sprints'] ?? [] as $sprint): ?>
                    <option value="<?= (int) $sprint['id'] ?>" <?= $sprintId === (string) $sprint['id'] ? 'selected' : '' ?>>
                        <?= h($sprint['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="form-label" for="team_id">Equip</label>
            <select class="form-select mb-3" id="team_id" name="team_id">
                <option value="">Sense equip</option>
                <?php foreach ($data['teams'] ?? [] as $team): ?>
                    <option value="<?= (int) $team['id'] ?>" <?= $teamId === (string) $team['id'] ? 'selected' : '' ?>>
                        <?= h($team['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="btn btn-primary">Guardar canvis</button>
            <a href="task.php?id=<?= $id ?>" class="btn btn-outline-secondary">Cancel·lar</a>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>