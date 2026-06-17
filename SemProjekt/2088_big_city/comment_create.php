<?php
session_start();

require_once 'auth.php';
require_once 'classes/Database.php';
require_once 'classes/CommentRepository.php';

requireLogin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = trim($_POST['question'] ?? '');
    $answer = trim($_POST['answer'] ?? '');

    if ($question === '' || $answer === '') {
        $error = 'Vyplň otázku aj odpoveď.';
    } else {
        try {
            $database = new Database();
            $commentRepository = new CommentRepository($database->getConnection());

            $commentRepository->create((int) $_SESSION['user_id'], $question, $answer);

            header('Location: index.php#0');
            exit;
        } catch (PDOException $exception) {
            $error = 'Komentár sa nepodarilo uložiť.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<?php include 'Header a footer/header.php'; ?>
<body style="background:#1b2a38; color:white;">

<div class="container" style="max-width: 700px; padding-top: 80px;">
    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
        <h2>Pridať otázku a odpoveď</h2>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Otázka</label>
                <textarea name="question" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label>Odpoveď</label>
                <textarea name="answer" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-success">Uložiť</button>
            <a href="index.php" class="btn btn-link">Späť</a>
        </form>
    </div>
</div>

</body>
</html>
