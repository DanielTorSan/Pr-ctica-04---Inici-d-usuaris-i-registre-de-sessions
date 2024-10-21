<!-- index.php -->
<link rel="stylesheet" href="Estils/estils.css">

<?php
// Iniciar sesión
session_start();

// Establecer el tiempo máximo de inactividad (20 segundos)
$inactividad_maxima = 20; // segundos

// Verificar si el usuario ha estado inactivo
if (isset($_SESSION['last_activity'])) {
    $inactividad = time() - $_SESSION['last_activity']; // Calcular tiempo de inactividad
    if ($inactividad > $inactividad_maxima) {
        // Si el usuario ha estado inactivo más de 20 segundos, destruir la sesión
        session_unset();
        session_destroy();
        header("Location: index.php"); // Redireccionar después de destruir la sesión
        exit();
    }
}

// Actualizar el tiempo de la última actividad
$_SESSION['last_activity'] = time();

// Habilitar el reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir la conexión a la base de datos
include "Controlador/db_connection.php"; // Verifica que esta ruta sea correcta
include "Controlador/id_manager.php"; // Incluir id_manager.php para usar funciones de gestión de IDs

// Verificar si el usuario está logueado
$loggedIn = isset($_SESSION['user']) || isset($_COOKIE['user']);
$usuario = $loggedIn ? ($_SESSION['user'] ?? $_COOKIE['user']) : null;

if ($loggedIn) {
    echo "<h1>Benvingut, " . htmlspecialchars($usuario) . "!</h1>";
    echo "<p>Pots veure i editar els teus articles.</p>";
    echo "<a href='Login/logout.php' class='button'>Tancar Sessió</a>"; // Botón para cerrar sesión
} else {
    echo "<h2>Ets un usuari anònim. Només pots veure els articles.</h2>";
}

// Consultar todos los artículos de la base de datos
$stmt = $pdo->prepare("SELECT * FROM articles");
$stmt->execute();
$articles = $stmt->fetchAll();
?>

<div class="container">
    <h1>Llista d'articles</h1>
    <div class="articles">
        <?php foreach ($articles as $article): ?>
            <div class="article">
                <h2><?php echo htmlspecialchars($article['titol'] ?? 'Título no disponible'); ?></h2>
                <p><?php echo htmlspecialchars($article['cos'] ?? 'Contenido no disponible'); ?></p>
                
                <!-- Si el usuario está logueado, mostrar las opciones de modificar o borrar -->
                <?php if ($loggedIn): ?>
                    <a href="Controlador/modificar.php?id=<?php echo htmlspecialchars($article['ID']); ?>" class="button">Modificar</a>
                    <a href="Controlador/esborrar.php?id=<?php echo htmlspecialchars($article['ID']); ?>" class="button">Esborrar</a>
                <?php endif; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    </div>
</div>

<!-- Si el usuario no está logueado, mostrar los botones de login/registro -->
<?php if (!$loggedIn): ?>
    <div class="login-register">
        <a href="Login/register.php" class="button">Registrar-se</a>
        <a href="Login/login.php" class="button">Iniciar Sessió</a>
    </div>
<?php else: ?>
    <!-- Si el usuario está logueado, permitir la inserción de artículos -->
    <div class="insert-article">
        <a href="Controlador/inserir.php" class="button">Inserir Article</a>
    </div>
<?php endif; ?>
