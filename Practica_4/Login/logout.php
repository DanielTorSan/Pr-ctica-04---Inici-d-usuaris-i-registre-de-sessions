<!-- Daniel Torres Sanchez -->
<?php
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Eliminar la cookie del usuario si existe
if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/'); // Expirar la cookie estableciendo el tiempo en el pasado
}

// Redirigir a la página principal
header("Location: ../index.php");
exit();
?>
