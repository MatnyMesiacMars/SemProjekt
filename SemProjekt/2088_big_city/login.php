<?php
session_start();

require_once 'classes/Database.php';
require_once 'classes/UserRepository.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        $database = new Database();
        $userRepository = new UserRepository($database->getConnection());
        $user = $userRepository->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_role'] = $user['role'];

            header('Location: index.php');
            exit;
        }

        $error = 'Nesprávne používateľské meno alebo heslo.';
    } catch (PDOException $exception) {
        $error = 'Chyba databázy. Skontroluj XAMPP MySQL a db/config.php.';
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<?php include 'Header a footer/header.php'; ?>
<body style="background:#1b2a38; color:white;">

<div class="container" style="max-width: 520px; padding-top: 80px;">
    <div class="tm-bg-dark-blue tm-white-border tm-textbox-padding">
        <h2>Prihlásenie</h2>

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
                <label>Heslo</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Prihlásiť</button>
            <a href="register.php" class="btn btn-link">Registrácia</a>
            <a href="index.php" class="btn btn-link">Späť na stránku</a>
        </form>
    </div>
</div>

</body>
</html>
