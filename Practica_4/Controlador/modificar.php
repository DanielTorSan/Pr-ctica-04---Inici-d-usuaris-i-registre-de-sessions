<!-- Daniel Torres Sanchez -->
<?php
// Iniciar sessió
session_start();

// Habilitar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la conexión a la base de datos
include "../Controlador/db_connection.php"; // Verifica que esta ruta sea correcta

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger los datos del formulario
    $dni = $_POST['dni'];
    $nou_cos = $_POST['cos'];
    $nou_titol = $_POST['titol'];

    // Llamar a la función para modificar el artículo
    modificarArticle($pdo, $dni, $nou_cos, $nou_titol);
    header("Location: ../index.php"); // Redireccionar después de modificar
    exit();
}

// Función para modificar un artículo
function modificarArticle($pdo, $dni, $nou_cos, $nou_titol) {
    $stmt = $pdo->prepare("UPDATE articles SET cos = ?, titol = ? WHERE dni = ?");
    $stmt->execute([$nou_cos, $nou_titol, $dni]);
}

// Si se proporciona un DNI, obtener los datos del artículo para mostrar en el formulario
if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE dni = ?");
    $stmt->execute([$dni]);
    $article = $stmt->fetch();

    if (!$article) {
        echo "Article no trobat."; // Si no se encuentra el artículo, mostrar mensaje
        exit();
    }
} else {
    echo "DNI no proporcionat."; // Mensaje de error si no se proporciona un DNI
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Article</title>
    <link rel="stylesheet" href="../Estils/estils.css">
</head>
<body>
    <div class="container">
        <div class="principalBox">
            <h1>Modificar Article</h1>
            <form method="POST" action="modificar.php" class="box">
                <input type="hidden" name="dni" value="<?php echo htmlspecialchars($dni); ?>">

                <label for="cos">Nou Cos:</label>
                <input type="text" name="cos" id="cos" value="<?php echo htmlspecialchars($article['cos']); ?>" required><br>

                <label for="titol">Nou Títol:</label>
                <input type="text" name="titol" id="titol" value="<?php echo htmlspecialchars($article['titol']); ?>" required><br>

                <input type="submit" value="Modificar Article" class="submit-button">
            </form>
            <a href="../index.php">Tornar a l'Inici</a>
        </div>
    </div>
</body>
</html>
