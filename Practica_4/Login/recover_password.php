<!-- Daniel Torres Sanchez -->
<link rel="stylesheet" href="../Estils/estils.css">

<?php
// Iniciar sessió
session_start();

// Incloure la connexió a la base de dades
include "../Controlador/db_connection.php";

// Incloure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

// Funció per enviar el correu amb PHPMailer
function enviarCorreu($nomC, $emailC, $textC) {
    $mail = new PHPMailer(true);
    try {
        // Configuració del servidor SMTP
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'd.torres2@sapalomera.cat';
        $mail->Password   = 'vjka sytx lzyp dvkz';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Configuració dels destinataris
        $mail->setFrom('d.torres2@sapalomera.cat', 'Dani');
        $mail->addAddress($emailC); // Correu del destinatari

        // Contingut del correu
        $mail->isHTML(true);
        $mail->Subject = 'Recuperar Contrasenya';
        $mail->Body    = 'Nom: '.$nomC.'<br/> Text: '.$textC;

        // Enviar el correu
        $mail->send();
        echo 'Enviat correctament';
    } catch (Exception $e) {
        echo "El correu no s'ha enviat. Error: {$mail->ErrorInfo}";
    }
}

// Inicialitzar missatge d'error
$error_message = "";
$success_message = "";

// Si el formulari és enviat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Comprovar si el correu electrònic existeix a la base de dades
    $stmt = $pdo->prepare("SELECT * FROM usuaris WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generar un token únic i una data d'expiració
        $token = bin2hex(random_bytes(50)); // Token aleatori
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour')); // 1 hora d'expiració

        // Actualitzar l'usuari amb el token i l'expiració
        $updateStmt = $pdo->prepare("UPDATE usuaris SET reset_token = ?, reset_expiration = ? WHERE email = ?");
        if ($updateStmt->execute([$token, $expiration, $email])) {
            // Enviar correu
            $resetLink = "http://localhost/Practiques/UF1/Practica_4/Login/reset_password.php?token=" . $token;
            enviarCorreu($user['username'], $email, "Fes clic aquí per restablir la teva contrasenya: <a href='$resetLink'>$resetLink</a>");
            $success_message = "S'han enviat les instruccions a la teva adreça de correu.";
        } else {
            $error_message = "Error al generar el token. Prova-ho més tard.";
        }
    } else {
        $error_message = "No s'ha trobat cap usuari amb aquest correu.";
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contrasenya</title>
</head>
<body>
<div class="container">
    <div class="principalBox">
        <h1>Recuperar Contrasenya</h1>
        <?php if ($error_message): ?>
            <p class="error" style="color:red;"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <?php if ($success_message): ?>
            <p class="success" style="color:green;"><?php echo htmlspecialchars($success_message); ?></p>
        <?php endif; ?>
        <form action="recover_password.php" method="POST">
            <label for="email">Correu electrònic:</label>
            <input type="email" name="email" required>
            <button type="submit" class="submit-button">Enviar instruccions</button>
        </form>
        <a href="login.php">Tornar a l'inici de sessió</a>
    </div>
</div>
</body>
</html>
