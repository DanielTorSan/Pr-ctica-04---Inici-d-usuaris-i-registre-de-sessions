<!-- Daniel Torres Sanchez -->
<link rel="stylesheet" href="../Estils/estils.css">

<?php
// Incloure la connexió a la base de dades i el fitxer de gestió d'IDs
include "db_connection.php";
include "id_manager.php";

// Habilitar el reporte d'errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar si s'ha enviat una sol·licitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenir les dades del formulari
    $dni = $_POST['dni'] ?? null;
    $cos = $_POST['cos'] ?? null;
    $titol = $_POST['titol'] ?? null;

    // Validar que tots els camps estiguin presents
    if ($dni && $cos && $titol) {
        try {
            // Obtenir el següent ID disponible
            $nouID = obtenirIDMinim($pdo);

            // Preparar la consulta d'inserció amb el nou ID
            $stmt = $pdo->prepare("INSERT INTO articles (ID, dni, cos, titol) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nouID, $dni, $cos, $titol]);

            // Reajustar els IDs després de la inserció
            reajustarIDs($pdo);

            // Confirmació d'inserció
            echo "<p>Article inserit correctament amb ID $nouID!</p>";
            echo "<a href='../index.php'>Tornar a l'inici</a>";

        } catch (PDOException $e) {
            // Mostrar error en cas de fallada
            echo "<p>Error en inserir l'article: " . $e->getMessage() . "</p>";
        }
    } else {
        // Si falten camps, mostrar un missatge d'error
        echo "<p>Tots els camps són obligatoris!</p>";
    }
} else {
    // Si no és una sol·licitud POST, redirigir al formulari
    header("Location: ../Vista/inserir.html");
    exit;
}
?>
