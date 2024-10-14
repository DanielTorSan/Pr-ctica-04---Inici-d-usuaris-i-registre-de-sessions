<!-- Daniel Torres Sanchez -->
<link rel="stylesheet" href="Estils/estils.css">
<?php
// Incloure la connexió a la base de dades
include "db_connection.php";

// Nombre d'articles per pàgina
$articlesPerPage = 5;

// Establir el número de pàgina actual, per defecte a 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Obtenim el número de pàgina actual de la query string
$page = max($page, 1); // Assegurar que la pàgina sigui com a mínim 1

// Calcular l'índex de l'article inicial per a la consulta
$offset = ($page - 1) * $articlesPerPage; // Calculem l'offset per a la consulta SQL

// Consultar la base de dades per obtenir el nombre total d'articles
$totalArticlesQuery = "SELECT COUNT(*) as total FROM articles"; // Consulta SQL per comptar els articles
$totalArticlesStmt = $pdo->query($totalArticlesQuery);
$totalArticles = $totalArticlesStmt->fetch(PDO::FETCH_ASSOC)['total']; // Obtenim el total d'articles

// Calcular el número total de pàgines
$totalPages = ceil($totalArticles / $articlesPerPage); // Calculem el total de pàgines a mostrar

// Si no hi ha articles, redirigir a l'index
if ($totalArticles === 0) {
    header("Location: index.php"); // Redirigim si no hi ha articles
    exit();
}

// Consultar els articles per la pàgina actual
$sql = "SELECT ID, titol, cos FROM articles LIMIT :limit OFFSET :offset"; // Consulta SQL per obtenir articles, excloent DNI
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':limit', $articlesPerPage, PDO::PARAM_INT); // Vincular el nombre màxim d'articles
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT); // Vincular l'offset
$stmt->execute(); // Executar la consulta

$articles = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtenim tots els articles

// Incloure l'HTML per mostrar els articles
include "Vista/mostrar_articles.html"; // Arxiu HTML que mostrarà els articles
?>
