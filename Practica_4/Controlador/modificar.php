<!-- Daniel Torres Sanchez -->
<?php
// Iniciar sessió
session_start();

// Habilitar el reporte d'errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incloure la connexió a la base de dades
include "../Controlador/db_connection.php";

// Verificar si s'ha enviat el formulari
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recollir les dades del formulari
    $id = $_POST['id'];
    $nou_cos = $_POST['cos'];
    $nou_titol = $_POST['titol'];

    // Cridar a la funció per modificar l'article
    modificarArticle($pdo, $id, $nou_cos, $nou_titol);
    header("Location: ../index.php"); // Redirigir després de modificar
    exit();
}

// Funció per modificar un article a la base de dades
function modificarArticle($pdo, $id, $nou_cos, $nou_titol) {
    $stmt = $pdo->prepare("UPDATE articles SET cos = ?, titol = ? WHERE ID = ?");
    $stmt->execute([$nou_cos, $nou_titol, $id]);
}

// Si es proporciona un ID, obtenir les dades de l'article per mostrar-les al formulari
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM articles WHERE ID = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();

    if (!$article) {
        echo "Article no trobat."; // Si no es troba l'article, mostrar missatge
        exit();
    }
} else {
    echo "ID no proporcionat."; // Missatge d'error si no es proporciona un ID
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
            <!-- Formulari per modificar el títol i cos de l'article -->
            <form method="POST" action="modificar.php" class="box">
                <!-- Camp ocult per enviar el ID en enviar el formulari -->
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <label for="cos">Nou Cos:</label>
                <!-- Camp de text per al nou contingut de l'article -->
                <input type="text" name="cos" id="cos" value="<?php echo htmlspecialchars($article['cos']); ?>" required><br>

                <label for="titol">Nou Títol:</label>
                <!-- Camp de text per al nou títol de l'article -->
                <input type="text" name="titol" id="titol" value="<?php echo htmlspecialchars($article['titol']); ?>" required><br>

                <!-- Botó per enviar el formulari -->
                <input type="submit" value="Modificar Article" class="submit-button">
            </form>
            <!-- Enllaç per tornar a la pàgina principal -->
            <a href="../index.php">Tornar a l'Inici</a>
        </div>
    </div>
</body>
</html>
