<!-- Daniel Torres Sanchez -->
<?php
session_start();

// Incluir conexión a la base de datos
include "../Controlador/db_connection.php";

// Consultar todos los artículos
$stmt = $pdo->prepare("SELECT * FROM articles");
$stmt->execute();
$articles = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Articles</title>
</head>
<body>
    <h1>Articles</h1>

    <div>
        <?php foreach ($articles as $article): ?>
            <div>
                <h2><?php echo htmlspecialchars($article['titol']); ?></h2>
                <p><?php echo htmlspecialchars($article['cos']); ?></p>
                <p><strong>DNI:</strong> <?php echo htmlspecialchars($article['dni']); ?></p>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="modificar.php?dni=<?php echo htmlspecialchars($article['dni']); ?>">Modificar</a>
                    <a href="esborrar.php?dni=<?php echo htmlspecialchars($article['dni']); ?>">Esborrar</a>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>

    <?php if (isset($_SESSION['user'])): ?>
        <a href="../Controlador/logout.php">Tancar Sessió</a>
    <?php else: ?>
        <a href="../Login/login.php">Iniciar Sessió</a>
    <?php endif; ?>

    <a href="../index.php">Tornar a la pàgina inicial</a>
</body>
</html>
