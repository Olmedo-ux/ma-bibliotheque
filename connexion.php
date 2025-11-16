<?php
session_start();
$page_title = "Connexion";
require 'config.php';
$message = '';

// rediréction si déjà connecté
if (isset($_SESSION['lecteur_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id, nom, prenom, mot_de_passe FROM Lecteurs WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Vérification du mot de passe haché
        if (password_verify($password, $user['mot_de_passe'])) {
            // Connexion réussie : stockage des informations en session
            $_SESSION['lecteur_id'] = $user['id'];
            $_SESSION['lecteur_nom'] = $user['nom'];
            $_SESSION['lecteur_prenom'] = $user['prenom'];
            
            header("Location: index.php"); // Redirection vers la page d'accueil
            exit;
        } else {
            $message = "<p class='message error'>Email ou mot de passe incorrect.</p>";
        }
    } else {
        $message = "<p class='message error'>Email ou mot de passe incorrect.</p>";
    }
}
$conn = null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> -Bibliothèque Book Sanctuary </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="login-register-page">

    <section class="admin-form">
        <h2>Connexion</h2>
        <?php echo $message; ?>
        <form action="connexion.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" required><br>
            
            <button type="submit" class="btn-primary">Se connecter</button>
        </form>
        <p>Pas encore de compte? <a href="inscription.php">S'inscrire</a></p>
    </section>

    </main>
</body>
</html>