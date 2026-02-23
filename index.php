<?php
require_once 'data.php';

// Simple Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Endpoint AJAX específic per al menjador abans de pintar cap HTML
if ($page === 'demo_canteen' && isset($_GET['ajax'])) {
    $file = "pages/{$page}.php";
    if (file_exists($file)) {
        include $file;
        exit;
    }
}

// Pàgines vàlides (eliminades les de diagnòstic/objectius/accions/implementació/seguiment)
$allowed_pages = [
    'home',
    'demo',
    'demo_canteen',
    'demo_comm',
    'demo_docs',
    'demo_academic',
];

if (!in_array($page, $allowed_pages, true)) {
    $page = 'home';
}

require_once 'includes/header.php';
?>

<main>
    <?php
    $file = "pages/{$page}.php";
    if (file_exists($file)) {
        include $file;
    } else {
        echo "<div class='container section-title'><h2>Pàgina no trobada</h2><p>Estem treballant en aquesta secció...</p></div>";
    }
    ?>
</main>

<?php
require_once 'includes/footer.php';
?>
