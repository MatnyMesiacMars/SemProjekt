<?php
session_start();

require_once 'auth.php';
require_once 'classes/Database.php';
require_once 'classes/CommentRepository.php';

requireLogin();
requireAdmin();

$database = new Database();
$commentRepository = new CommentRepository($database->getConnection());

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $commentRepository->delete($id);
}

header('Location: index.php');
exit;
