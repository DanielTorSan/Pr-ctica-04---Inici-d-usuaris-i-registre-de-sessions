<!-- Daniel Torres Sanchez -->
<link rel="stylesheet" href="../Estils/estils.css">

<?php
// Incluir la conexión a la base de datos
include "db_connection.php";

// Habilitar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $dni = $_POST['dni'] ?? null;
    $cos = $_POST['cos'] ?? null;
    $titol = $_POST['titol'] ?? null;

    // Validar que todos los campos estén presentes
    if ($dni && $cos && $titol) {
        try {
            // Preparar la consulta de inserción
            $stmt = $pdo->prepare("INSERT INTO articles (dni, cos, titol) VALUES (?, ?, ?)");
            $stmt->execute([$dni, $cos, $titol]);

            // Confirmación de inserción
            echo "<p>Article inserit correctament!</p>";
            echo "<a href='../index.php'>Tornar a l'inici</a>";

        } catch (PDOException $e) {
            // Mostrar error en caso de fallo
            echo "<p>Error en inserir l'article: " . $e->getMessage() . "</p>";
        }
    } else {
        // Si faltan campos, mostrar un mensaje de error
        echo "<p>Tots els camps són obligatoris!</p>";
    }
} else {
    // Si no es una solicitud POST, redirigir al formulario
    header("Location: ../Vista/inserir.html");
    exit;
}
?>
