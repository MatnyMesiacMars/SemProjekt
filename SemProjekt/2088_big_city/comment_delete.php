<?php
session_start();

require_once 'auth.php';
require_once 'classes/Database.php';
require_once 'classes/CommentRepository.php';

requireLogin();

$database = new Database();
$commentRepository = new CommentRepository($database->getConnection());

$id = (int) ($_GET['id'] ?? 0);
$comment = $commentRepository->findById($id);

if ($comment && canEditComment($comment)) {
    $commentRepository->delete($id);
}

header('Location: index.php');
exit;
