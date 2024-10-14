<!-- Daniel Torres Sanchez -->
<?php
// Funció per esborrar l'article
function esborrarArticle($pdo, $dni) {
    // Borrem l'article depenent del seu dni
    $sql = "DELETE FROM articles WHERE DNI = :dni";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':dni', $dni);
    $stmt->execute();
    
    // Tracta l'id despres de la modificació a la bdd
    reajustarIDs($pdo);
}
?>
