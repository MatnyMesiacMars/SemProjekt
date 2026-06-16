<?php

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

function isAdmin(): bool
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function canEditComment(array $comment): bool
{
    if (!isLoggedIn()) {
        return false;
    }

    return isAdmin() || (int) $comment['user_id'] === (int) $_SESSION['user_id'];
}
