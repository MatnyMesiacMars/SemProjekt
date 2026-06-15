<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/UserRepository.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Vyplň všetky polia.';
    } else {
        try {
            $database = new Database();
            $userRepository = new UserRepository($database->getConnection());

            $userRepository->create($username, $email, $password);
            $message = 'Registrácia bola úspešná. Teraz sa môžeš prihlásiť.';
        } catch (PDOException $exception) {
            $error = 'Používateľské meno alebo email už existuje.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<?php include 'Header a footer/header.php'; ?>
<body style="background:#1b2a38; color:white;">

<div class="container" style="max-width: 520px; padding-top: 80px;">
    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
        <h2>Registrácia</h2>

        <?php if ($message !== ''): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Používateľské meno</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Heslo</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Registrovať</button>
            <a href="login.php" class="btn btn-link">Prihlásenie</a>
            <a href="index.php" class="btn btn-link">Späť na stránku</a>
        </form>
    </div>
</div>

</body>
</html>
