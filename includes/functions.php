<?php

declare(strict_types=1);

date_default_timezone_set('UTC'); //Declarat per al Ex2


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


// EXERCICIS
//Exercici 2
function mostrarData(bool $withTime): string
{
    if ($withTime) {
        return date('l, jS \of F Y') . "\n";
    } else {
        return "";
    }
}
