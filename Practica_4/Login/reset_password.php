<!-- Daniel Torres Sanchez -->
<link rel="stylesheet" href="../Estils/estils.css">

<?php
// Incloure la connexió a la base de dades
include "../Controlador/db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password !== $confirm_password) {
        $error_message = "Les contrasenyes no coincideixen.";
    } else {
        // Verificar si el token és vàlid i no ha expirat
        $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE reset_token = ? AND reset_expiration > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Actualitzar la contrasenya i eliminar el token
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE usuaris SET password = ?, reset_token = NULL, reset_expiration = NULL WHERE reset_token = ?");
            $stmt->execute([$hashed_password, $token]);
            $success_message = "Contrasenya restablerta correctament.";
        } else {
            $error_message = "Token no vàlid o expirat.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablir Contrasenya</title>
    <link rel="stylesheet" href="../Estils/estils.css"> <!-- Inclou el teu fitxer CSS -->
</head>
<body>
    <div class="container">
        <div class="principalBox">
            <h1>Restablir Contrasenya</h1>
            <?php if (isset($error_message)): ?>
                <p class="error" style="color:red;"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <p class="success" style="color:green;"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
            <form action="reset_password.php" method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                
                <label for="password">Nova Contrasenya:</label>
                <input type="password" name="password" required>
                
                <label for="confirm_password">Confirmar Contrasenya:</label>
                <input type="password" name="confirm_password" required>
                
                <button type="submit">Restablir Contrasenya</button>
            </form>
            <a href="login.php">Tornar a l'inici de sessió</a>
        </div>
    </div>
</body>
</html>
