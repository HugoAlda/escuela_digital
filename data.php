<?php
// Configuració de la base de dades (MySQL)
// Ajusta aquests valors segons la teva instal·lació de WAMP/XAMPP.

define('DB_HOST', 'localhost');
define('DB_NAME', 'escuela_digital');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // En un entorn real, seria millor registrar l'error en lloc de mostrar-lo.
    die('Error de connexió amb la base de dades: ' . htmlspecialchars($e->getMessage()));
}

