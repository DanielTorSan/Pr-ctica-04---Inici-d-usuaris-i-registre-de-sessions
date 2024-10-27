<!-- Daniel Torres Sanchez -->
<?php
// Funció per buscar un article pel seu dni
function buscarArticle($pdo, $dni) {
    // Consultem pel dni de l'article
    $sql = "SELECT * FROM articles WHERE DNI = :dni LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':dni', $dni);
    $stmt->execute();
    
    // Retorna l'article
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
