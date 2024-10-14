<!-- Daniel Torres Sanchez -->
<?php
// Funció per mostrar els detalls de  l'artícle
function mostrarDetallsArticle($article) {
    if ($article) {
        echo "<h3>Detalls de l'Article:</h3>";
        echo "<table border='1' cellpadding='10'>
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>Cos</th>
                <th>Títol</th>
            </tr>
            <tr>
                <td>" . htmlspecialchars($article['ID']) . "</td>
                <td>" . htmlspecialchars($article['DNI']) . "</td>
                <td>" . htmlspecialchars($article['cos']) . "</td>
                <td>" . htmlspecialchars($article['titol']) . "</td>
            </tr>
        </table>";
    }
}
?>
