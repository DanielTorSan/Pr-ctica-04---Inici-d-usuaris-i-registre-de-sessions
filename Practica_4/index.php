<!-- Daniel Torres Sanchez -->
<link rel="stylesheet" href="Estils/estils.css">

<?php
// Incloure la connexió a la base de dades
include "db_connection.php";

// Incloure les funcions de gestió d'IDs
include "id_manager.php";

// Incloure les funcions separades
include "inserir.php";
include "modificar.php";
include "esborrar.php";
include "buscar_article.php";
include "mostrar_detalls_article.php";

// Incloure la vista principal
include "Vista/index.html";

// Afegir un enllaç a mostrar_articles.php
echo "<h2><a href='mostrar_articles.php'>Mostrar Articles</a></h2>";

// Processar les sol·licituds
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accio = $_POST['accio'] ?? null;
    $dni = $_POST['dni'] ?? null; // Obtenir el DNI de forma global

    switch ($accio) {
        case 'inserir':
            $cos = $_POST['cos'];
            $titol = $_POST['titol'];
            
            if (buscarArticle($pdo, $dni)) {
                echo "<p>L'article amb DNI $dni ja existeix. No es pot inserir un nou article amb el mateix DNI.</p>";
            } else {
                inserirArticle($pdo, $dni, $cos, $titol);
                $articleInsertat = buscarArticle($pdo, $dni); // Recuperar l'article inserit
                mostrarDetallsArticle($articleInsertat); // Mostrar els detalls
            }
            break;

        case 'modificar':
            $nou_cos = $_POST['cos'];
            $nou_titol = $_POST['titol'];

            $article = buscarArticle($pdo, $dni);
            if ($article) {
                if ($article['cos'] === $nou_cos && $article['titol'] === $nou_titol) {
                    echo "<p>No s'han detectat canvis. Els nous valors són iguals als existents.</p>";
                } else {
                    modificarArticle($pdo, $dni, $nou_cos, $nou_titol);
                    $articleModificat = buscarArticle($pdo, $dni); // Recuperar l'article modificat
                    mostrarDetallsArticle($articleModificat); // Mostrar els detalls
                }
            } else {
                echo "<p>Article no trobat amb DNI $dni.</p>";
            }
            break;

        case 'esborrar':
            $article = buscarArticle($pdo, $dni);
            if ($article) {
                esborrarArticle($pdo, $dni);
                echo "<p>Article esborrat correctament.</p>";
            } else {
                echo "<p>No s'ha trobat cap article amb el DNI $dni per esborrar.</p>";
            }
            break;

        case 'mostrar':
            $article = buscarArticle($pdo, $dni);
            if ($article) {
                mostrarDetallsArticle($article); // Mostrar els detalls
            } else {
                echo "<p>No s'ha trobat cap article amb el DNI $dni.</p>";
            }
            break;
    }
}
?>
