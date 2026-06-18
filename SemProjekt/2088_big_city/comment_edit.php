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
$comment = $commentRepository->findById($id);

if (!$comment) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question'] ?? '');
    $answer = trim($_POST['answer'] ?? '');

    if ($question === '') {
        $error = 'Vyplň otázku.';
    } else {
        $commentRepository->update($id, $question, $answer);

        header('Location: index.php#0');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<?php include 'Header a footer/header.php'; ?>
<body style="background:#1b2a38; color:white;">

<div class="container" style="max-width: 700px; padding-top: 80px;">
    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
        <h2>Upraviť otázku a odpoveď</h2>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Otázka</label>
                <textarea name="question" class="form-control" rows="4" required><?= htmlspecialchars($comment['question']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Odpoveď (nepovinné)</label>
                <textarea name="answer" class="form-control" rows="4"><?= htmlspecialchars($comment['answer'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Uložiť zmeny</button>
            <a href="index.php" class="btn btn-link">Späť</a>
        </form>
    </div>
</div>

</body>
</html>
