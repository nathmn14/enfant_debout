<?php
// Configuration de la base de données
$host = 'localhost';
$db   = 'enfant_debout';
$user = 'root';
$pass = ''; // Mot de passe par défaut sur XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (\PDOException $e) {
    exit('Erreur de connexion : ' . $e->getMessage());
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!empty($email) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");

        try {
            $stmt->execute([$email, $hashed_password]);
            $message = "Inscription réussie !";
        } catch (PDOException $e) {
            $message = "Erreur : cet email est peut-être déjà utilisé.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h2>Créer un compte</h2>
    <?php if (!empty($message)) echo "<p style='color:" . ($message === 'Inscription réussie !' ? 'green' : 'red') . ";'>$message</p>"; ?>
    <form method="POST">
        <label>Email :</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
