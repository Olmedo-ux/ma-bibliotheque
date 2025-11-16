<?php
// Utilisation des variables d'environnement fournies par Render
$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dbname = getenv('DB_NAME');
$charset = 'utf8mb4';

// Si l'une des variables n'est pas définie, cela évitera une erreur fatale.
if (!$host || !$user || !$pass || !$dbname) {
    die("Erreur de configuration: Les variables d'environnement de la base de données sont manquantes.");
}

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Affiche une erreur générique en production, mais l'erreur complète ici pour le débogage.
     die("Erreur de connexion : " . $e->getMessage()); 
}
?>
