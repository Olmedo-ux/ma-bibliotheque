<?php
// Paramètres de la base de données
$servername = "localhost";
$username = "root";        
$password = "";            
$dbname = "bibliotheque";  

// Créer la connexion (PDO)
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    die(); 
}
?>