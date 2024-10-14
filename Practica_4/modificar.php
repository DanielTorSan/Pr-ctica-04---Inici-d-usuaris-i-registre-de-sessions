<!-- Daniel Torres Sanchez -->
<?php
// Funció per modificar l'article
function modificarArticle($pdo, $dni, $nou_cos, $nou_titol) {
    // Actualitza l'article amb els nous valors
    $sql = "UPDATE articles SET cos = :cos, titol = :titol WHERE DNI = :dni";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cos', $nou_cos);
    $stmt->bindParam(':titol', $nou_titol);
    $stmt->bindParam(':dni', $dni);
    $stmt->execute();
}
?>