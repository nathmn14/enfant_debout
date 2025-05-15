<?php
require_once '../../Backend/request_bdd.php';

// Récupérer tous les événements
$evenements = getAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tous les événements - Enfant Debout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Navbar identique -->

    <header class="bg-blue-800 text-white shadow">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between py-4">
            <div class="flex items-center space-x-4">
                <img src="../assets/logo.png" alt="Logo Enfant Debout" class="h-12 w-auto">
                <div>
                    <h1 class="text-xl font-bold">Enfant Debout</h1>
                    <p class="text-sm">ONG pour l’enfant et la femme</p>
                </div>
            </div>
            <nav class="hidden md:flex space-x-6">
                <a href="Accueil.php" class="hover:text-blue-200">Accueil</a>
                <a href="#contact" class="hover:text-blue-200">Contact</a>
            </nav>
            <button class="md:hidden" id="menu-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div class="md:hidden hidden bg-blue-700 px-4 pb-4" id="mobile-menu">
            <nav class="flex flex-col space-y-2 text-white">
                <a href="Accueil.php" class="hover:text-blue-200">Accueil</a>
                <a href="#contact" class="hover:text-blue-200">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Liste complète des événements -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-blue-800 mb-8">Tous les événements</h1>
        <?php if (count($evenements) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($evenements as $event): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <a href="evenement.php?id=<?= $event['id'] ?>">
                            <img src="../Admin/uploads/<?= $event['image'] ?>" alt="<?= $event['title'] ?>"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h2 class="text-xl font-semibold text-blue-700 mb-2"><?= $event['title'] ?></h2>
                                <p class="text-gray-600 text-sm line-clamp-3"><?= strip_tags($event['description']) ?></p>
                                <span class="text-blue-600 hover:underline mt-3 inline-block">Voir l'événement →</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Aucun événement disponible pour le moment.</p>
        <?php endif; ?>
    </main>

    <!-- Contact & Footer identiques -->

    <section id="contact" class="py-16 bg-blue-800 text-white text-center">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-4">Contactez-Nous</h2>
            <p class="text-lg mb-4">Ensemble, redonnons espoir aux enfants et aux femmes.</p>
            <p>Email : <a href="mailto:contact@enfantdebout.org" class="underline">contact@enfantdebout.org</a></p>
            <p>Téléphone : <strong>+243 000 000 000</strong></p>
        </div>
    </section>

    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center px-4">
            <p>&copy; 2025 Enfant Debout. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        document.getElementById("menu-button").addEventListener("click", function () {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });
    </script>
</body>

</html>