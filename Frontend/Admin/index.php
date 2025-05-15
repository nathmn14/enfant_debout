<?php
session_start(); // Pour gérer la session
include('../../Backend/request_bdd.php');

$connexionErrorMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $connexion = authentifier($email, $password);

    if ($connexion === false) {
      $connexionErrorMessage = 'Email ou mot de passe incorrect';
    } else {
      // Création de la session admin
      $_SESSION['admin'] = [
        'id' => $connexion['id'], // adapte selon ce que retourne la fonction `authentifier`
        'email' => $connexion['email'],
        'nom' => $connexion['nom'] ?? '',
      ];

      header('Location: activites.php');
      exit();
    }
  } else {
    $errorMessage = 'Veuillez remplir tous les champs';
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion - Enfant Debout</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    // Menu responsive toggle
    document.addEventListener('DOMContentLoaded', function () {
      const button = document.getElementById('menu-button');
      const menu = document.getElementById('menu');
      button.addEventListener('click', () => {
        menu.classList.toggle('hidden');
      });
    });
  </script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

  <!-- Navbar -->
  <header class="bg-blue-800 text-white">
    <div class="container mx-auto flex items-center justify-between px-4 py-4">
      <div class="flex items-center space-x-4">
        <img src="../assets/logo.png" alt="Logo Enfant Debout" class="h-12 w-auto">
        <div>
          <h1 class="text-xl font-bold">Enfant Debout</h1>
          <p class="text-sm">ONG pour l’enfant et la femme</p>
        </div>
      </div>
      <nav class="hidden md:flex space-x-6">
        <a href="#a-propos" class="hover:text-blue-200">À propos</a>
        <a href="#evenements" class="hover:text-blue-200">Événements</a>
        <a href="#education" class="hover:text-blue-200">Éducation</a>
        <a href="#sante" class="hover:text-blue-200">Santé</a>
        <a href="#protection" class="hover:text-blue-200">Protection</a>
        <a href="#contact" class="hover:text-blue-200">Contact</a>
      </nav>
      <button class="md:hidden" id="menu-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
    <!-- Mobile menu -->
    <div id="menu" class="md:hidden hidden px-4 pb-4">
      <a href="#a-propos" class="block py-2 hover:text-blue-200">À propos</a>
      <a href="#evenements" class="block py-2 hover:text-blue-200">Événements</a>
      <a href="#education" class="block py-2 hover:text-blue-200">Éducation</a>
      <a href="#sante" class="block py-2 hover:text-blue-200">Santé</a>
      <a href="#protection" class="block py-2 hover:text-blue-200">Protection</a>
      <a href="#contact" class="block py-2 hover:text-blue-200">Contact</a>
    </div>
  </header>

  <!-- Formulaire de connexion -->
  <main class="flex-1 flex items-center justify-center px-4 py-10">
    <form method="POST" class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md space-y-6">
      <h2 class="text-2xl font-bold text-center text-gray-800">Connexion</h2>

      <?php if (!empty($errorMessage)): ?>
        <p class="text-red-500 text-sm text-center"><?= $errorMessage; ?></p>
      <?php endif; ?>

      <div>
        <label for="email" class="block text-gray-600 mb-1">Email</label>
        <input type="email" id="email" name="email" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label for="password" class="block text-gray-600 mb-1">Mot de passe</label>
        <input type="password" id="password" name="password" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        <?php if (!empty($connexionErrorMessage)): ?>
          <span class="text-red-500 text-sm"><?= $connexionErrorMessage; ?></span>
        <?php endif; ?>
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
        Se connecter
      </button>
    </form>
  </main>

</body>

</html>