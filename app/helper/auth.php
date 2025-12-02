<?php
function requireAdmin()
{
    if (!isAdmin()) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Accès réservé aux administrateurs.'
        ];
        header("Location: index.php?action=list");
        exit;
    }
}

function requireUser()
{
    if (!isUser()) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Connectez-vous pour accéder à cette page.'
        ];
        header("Location: index.php?action=connexion");
        exit;
    }
}

function isAdmin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isUser()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'user';
}

?>