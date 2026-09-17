<?php

declare(strict_types=1);

function h(string|int|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function validCsrf(): bool
{
    return isset($_POST['csrf'], $_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], (string) $_POST['csrf']);
}

function activeSprint(array $sprints): ?array
{
    foreach ($sprints as $sprint) {
        if (($sprint['status'] ?? '') === 'active') {
            return $sprint;
        }
    }

    return null;
}

function statusLabel(string $status): string
{
    return [
        'todo' => 'To do',
        'in_progress' => 'In progress',
        'done' => 'Done',
    ][$status] ?? $status;
}

function fecha(bool $fecha): string
{
    if($fecha){
        echo date(DATE_RFC2822) . "\n";
    } else {
        echo date('l \t\h\e jS');
    }
    return "";
}

function isFilled(array $values, array $errors): array {
    if (empty($values['name']) || empty($values['goal']) || empty($values['start_date']) || empty($values['end_date']) || empty($values['status'])) {
        $errors[] = 'Los campos tienen que estar completos';
    }
    return $errors;
}

function validationString(array $values, array $errores): array {
    $tamañoName = mb_strlen($values['name']);
    $tamañoGoal = mb_strlen($values['goal']);
    
    if ($tamañoName < 3) {
        $errores[] = 'El name es muy corto';
    } elseif ($tamañoName > 100) {
        $errores[] = 'El name es muy largo';
    }

    if ($tamañoGoal < 3) {
        $errores[] = 'El goal es muy corto';
    } elseif ($tamañoGoal > 100) {
        $errores[] = 'El goal es muy largo';
    }
    return $errores; 
}

function validateDate($values, $errores): array {
    $dataInici = $values['start_date'];
    $dataFi = $values['end_date'];

    $dataValidadaInici = DateTime::createFromFormat('Y-m-d',$dataInici);
    $dataValidadaFi = DateTime::createFromFormat('Y-m-d',$dataFi);


    if(date_timestamp_get($dataValidadaFi) < date_timestamp_get($dataValidadaInici)){
        $errores[] = 'La data de de fi no pot ser menor a la incial';
    }


    return $errores;
}

