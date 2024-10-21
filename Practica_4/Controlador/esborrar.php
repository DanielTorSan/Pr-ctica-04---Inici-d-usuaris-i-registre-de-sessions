<!-- esborrar.php -->
<?php
session_start();

// Incluir la conexión a la base de datos y las funciones de id_manager
include "../Controlador/db_connection.php"; // Verifica que esta ruta sea correcta
include "../Controlador/id_manager.php"; // Incluir id_manager.php para usar funciones de gestión de IDs

// Verificar si se ha pasado un ID
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Preparar y ejecutar la consulta para eliminar el artículo
    $stmt = $pdo->prepare("DELETE FROM articles WHERE ID = :id");
    $stmt->bindParam(':id', $id);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Llamar a la función para reajustar los IDs después de la eliminación
        reajustarIDs($pdo);
        // Mensaje de éxito
        echo "<p>Article esborrat correctament.</p>";
    } else {
        // Mensaje de error si no se pudo borrar
        echo "<p>No s'ha pogut esborrar l'article amb ID: $id</p>";
    }

    // Redirigir a la página de índice después de borrar
    header("Location: ../index.php");
    exit();
} else {
    echo "<p>ID no proporcionat.</p>";
}
?>
