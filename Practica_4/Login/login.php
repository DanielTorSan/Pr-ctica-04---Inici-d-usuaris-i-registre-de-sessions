<!-- Daniel Torres Sanchez -->
<link rel="stylesheet" href="../Estils/estils.css">

<?php
// Iniciar sessió
session_start();

// Incloure la connexió a la base de dades
include "../Controlador/db_connection.php";

// Inicialitzar missatge d'error
$error_message = "";

// Si el formulari és enviat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Buscar l'usuari a la base de dades
    $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Comprovar si l'usuari existeix i la contrasenya és correcta
    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sessió i redirigir al inici
        $_SESSION['user'] = $username;
        setcookie("user", $username, time() + 2400, "/"); // Cookie de sessió durant 40min
        header("Location: ../index.php");
        exit(); // Assegurar-se que no s'executi més codi després de la redirecció
    } else {
        $error_message = "Usuari o contrasenya incorrectes.";
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessió</title>
</head>
<body>

<div class="container">
    <div class="principalBox">
        <h1>Inicia Sessió</h1>
        <?php if ($error_message): ?>
            <p class="error" style="color:red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="username">Nom d'usuari:</label>
            <input type="text" name="username" required>
            
            <label for="password">Contrasenya:</label>
            <input type="password" name="password" required>
            
            <button type="submit" class="submit-button">Iniciar Sessió</button>
        </form>

        <p>No tens un compte? <a href="register.php">Registra't aquí</a></p>
        <p><a href="recover_password.php">Has oblidat la teva contrasenya?</a></p>
        <a href="../index.php">Tornar a l'inici</a>
    </div>
</div>

</body>
</html>
