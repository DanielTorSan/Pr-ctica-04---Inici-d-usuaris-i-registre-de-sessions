<!-- Daniel Torres Sanchez -->
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llista d'articles</title>
    <link rel="stylesheet" href="Estils/estils.css">
</head>
<body>

<?php
// Iniciar sessió i gestionar la lògica d'inactivitat
session_start();
$inactivitat_maxima = 2400; // temps d'inactivitat en segons (40 minuts)
if (isset($_SESSION['last_activity'])) {
    $inactivitat = time() - $_SESSION['last_activity'];
    if ($inactivitat > $inactivitat_maxima) {
        session_unset();
        session_destroy();
        header("Location: index.php"); // redirigeix a l'índex després d'inactivitat
        exit();
    }
}
$_SESSION['last_activity'] = time();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include "Controlador/db_connection.php";
include "Controlador/id_manager.php";

// Comprovar si l'usuari està connectat
$loggedIn = isset($_SESSION['user']) || (isset($_COOKIE['user']) && !empty($_COOKIE['user']));
$usuari = $loggedIn ? ($_SESSION['user'] ?? $_COOKIE['user']) : null;

// Configuració de la paginació
$articlesPerPagina = 5; // Nombre d'articles per pàgina
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $articlesPerPagina;

// Obtenir el número total d'articles
$stmt = $pdo->prepare("SELECT COUNT(*) FROM articles");
$stmt->execute();
$totalArticles = $stmt->fetchColumn();
$totalPagines = ceil($totalArticles / $articlesPerPagina);

// Obtenir els articles de la pàgina actual
$stmt = $pdo->prepare("SELECT * FROM articles LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $articlesPerPagina, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$articles = $stmt->fetchAll();
?>

<div class="header">
    <?php if ($loggedIn): ?>
        <h1>Benvingut, <?php echo htmlspecialchars($usuari); ?>!</h1>
        <a href="Login/logout.php" class="button logout">Tancar Sessió</a>
    <?php endif; ?>
</div>

<div class="container">
    <h1>Llista d'articles</h1>
    <div class="articles">
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <h2><?php echo htmlspecialchars($article['titol'] ?? 'Títol no disponible'); ?></h2>
                <p><?php echo htmlspecialchars($article['cos'] ?? 'Contingut no disponible'); ?></p>
                
                <?php if ($loggedIn): ?>
                    <div class="article-actions">
                        <a href="Controlador/modificar.php?id=<?php echo htmlspecialchars($article['ID']); ?>" class="button modify">Modificar</a>
                        <a href="Controlador/esborrar.php?id=<?php echo htmlspecialchars($article['ID']); ?>" class="button delete">Esborrar</a>
                    </div>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>

    <!-- Navegació de Paginació -->
    <div class="pagination">
        <?php if ($paginaActual > 1): ?>
            <a href="?pagina=<?php echo $paginaActual - 1; ?>" class="button">Anterior</a>
        <?php endif; ?>

        <span class="page-info">Pàgina <?php echo $paginaActual; ?> de <?php echo $totalPagines; ?></span>

        <?php if ($paginaActual < $totalPagines): ?>
            <a href="?pagina=<?php echo $paginaActual + 1; ?>" class="button">Següent</a>
        <?php endif; ?>
    </div>

    <?php if (!$loggedIn): ?>
        <div class="login-register">
            <a href="Login/register.php" class="button">Registrar-se</a>
            <a href="Login/login.php" class="button">Iniciar Sessió</a>
        </div>
    <?php else: ?>
        <div class="insert-article">
            <a href="Controlador/inserir.php" class="button">Inserir Article</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
