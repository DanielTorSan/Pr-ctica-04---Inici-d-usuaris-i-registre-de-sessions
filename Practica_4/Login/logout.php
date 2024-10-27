<!-- Daniel Torres Sanchez -->
<?php
session_start();

// Destruir totes les variables de sessió
session_unset();

// Destruir la sessió
session_destroy();

// Eliminar la cookie de l'usuari si existeix
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/'); // Expirar la cookie establint el temps en el passat
}

// Redirigir a la pàgina principal
header("Location: ../index.php");
exit();
?>
