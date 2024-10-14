<!-- Daniel Torres Sanchez -->
<?php
// Funció per inserir article
function inserirArticle($pdo, $dni, $cos, $titol) {
    // Busquem l'id mes baix
    $id = obtenirIDMinim($pdo);
    
    // Inserta el nuevo artículo con el ID encontrado
    $sql = "INSERT INTO articles (ID, DNI, cos, titol) VALUES (:id, :dni, :cos, :titol)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':cos', $cos);
    $stmt->bindParam(':titol', $titol);
    $stmt->execute();
}
?>
