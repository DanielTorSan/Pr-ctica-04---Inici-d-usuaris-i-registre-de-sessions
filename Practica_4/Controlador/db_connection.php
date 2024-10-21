<!-- Daniel Torres Sanchez -->
<?php
// Conexió a la base de dades
try {
    // Cambiar el nombre de la base de datos a 'pt03_dani_torres'
    $pdo = new PDO("mysql:host=localhost;dbname=pt04_dani_torres", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la connexió: " . $e->getMessage());
}
?>
