<?php
// Funció per obtenir el següent ID disponible
function obtenirIDMinim($pdo) {
    // Obtenir el ID més alt existent
    $sql = "SELECT IFNULL(MAX(ID), 0) AS max_id FROM articles";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $row['max_id'] + 1; // Retorna el següent ID disponible
}

// Funció per reajustar els IDs dels articles
function reajustarIDs($pdo) {
    // Obtenir tots els articles
    $sql = "SELECT * FROM articles ORDER BY ID";
    $stmt = $pdo->query($sql);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Reassignar els IDs
    foreach ($articles as $index => $article) {
        $newID = $index + 1; // Nou ID basat en la posició (1, 2, 3, ...)
        
        // Actualitzar el ID només si és necessari
        if ($article['ID'] != $newID) {
            $updateSql = "UPDATE articles SET ID = :newID WHERE ID = :oldID";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':newID', $newID);
            $updateStmt->bindParam(':oldID', $article['ID']);
            $updateStmt->execute();
        }
    }
}

// Funció per inserir un nou article
function inserirArticle($pdo, $dni, $cos, $titol) {
    // Obtenir el següent ID disponible
    $nouID = obtenirIDMinim($pdo);

    // Insertar el nou article
    $sqlInsert = "INSERT INTO articles (ID, DNI, cos, titol) VALUES (:id, :dni, :cos, :titol)";
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->bindParam(':id', $nouID);
    $stmt->bindParam(':dni', $dni);
    $stmt->bindParam(':cos', $cos);
    $stmt->bindParam(':titol', $titol);
    $stmt->execute();

    // Reajustar els IDs després d'inserir
    reajustarIDs($pdo);
}
?>
