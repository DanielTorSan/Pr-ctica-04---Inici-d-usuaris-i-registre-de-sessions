<!-- Daniel Torres Sanchez -->
<?php
// Funció per obtenir el ID més baix disponible
function obtenirIDMinim($pdo) {
    // Obtenir el ID més baix disponible
    $sql = "SELECT IFNULL(MIN(ID) + 1, 1) AS next_id FROM articles";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $next_id = $row['next_id']; // Si no hi ha files, el ID comença des de l'1
    
    // Assegurar-se que el ID no existeixi a la base de dades
    while (true) {
        $sql = "SELECT COUNT(*) AS count FROM articles WHERE ID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $next_id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count == 0) {
            break; // El ID no existeix, es pot fer servir
        }
        $next_id++; // Provar el següent ID
    }
    
    return $next_id;
}

// Funció per reajustar els IDs dels articles
function reajustarIDs($pdo) {
    // Obtenir tots els articles
    $sql = "SELECT * FROM articles ORDER BY ID";
    $stmt = $pdo->query($sql);
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Reassignar els IDs
    foreach ($articles as $index => $article) {
        $newID = $index + 1; // Nou ID basat en la posició
        if ($article['ID'] != $newID) {
            // Actualitzar el ID només si és necessari
            $updateSql = "UPDATE articles SET ID = :newID WHERE ID = :oldID";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindParam(':newID', $newID);
            $updateStmt->bindParam(':oldID', $article['ID']);
            $updateStmt->execute();
        }
    }
}
?>
