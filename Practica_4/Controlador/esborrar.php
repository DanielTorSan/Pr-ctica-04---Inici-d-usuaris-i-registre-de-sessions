<!-- Daniel Torres Sanchez -->
<?php
session_start();

// Incloure la connexió a la base de dades i les funcions de gestió d'IDs
include "../Controlador/db_connection.php"; // Verifica que aquesta ruta sigui correcta
include "../Controlador/id_manager.php"; // Incloure id_manager.php per utilitzar funcions de gestió d'IDs

// Comprovar si s'ha passat un ID
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Preparar i executar la consulta per esborrar l'article
    $stmt = $pdo->prepare("DELETE FROM articles WHERE ID = :id");
    $stmt->bindParam(':id', $id);
    
    // Executar la consulta
    if ($stmt->execute()) {
        // Cridar a la funció per reajustar els IDs després de l'eliminació
        reajustarIDs($pdo);
        // Missatge d'èxit
        echo "<p>Article esborrat correctament.</p>";
    } else {
        // Missatge d'error si no es va poder esborrar
        echo "<p>No s'ha pogut esborrar l'article amb ID: $id</p>";
    }

    // Redirigir a la pàgina d'índex després d'esborrar
    header("Location: ../index.php");
    exit();
} else {
    echo "<p>ID no proporcionat.</p>";
}
?>
