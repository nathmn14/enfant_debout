<?php
require_once '../../Backend/request_bdd.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location:Accueil.php");
    exit();
}

$evenement = getEventById($id);
$autres = getOtherEvents($id);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $evenement['title'] ?> - Enfant Debout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <header class="bg-blue-800 text-white shadow">
        <div class="max-w-screen-xl mx-auto flex items-center justify-between px-4 py-4">
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

    <!-- Contenu principal -->
    <main class="max-w-screen-xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Événement principal -->
            <div class="lg:col-span-2">
                <h1 class="text-3xl md:text-4xl font-bold text-blue-800 mb-4"><?= $evenement['title'] ?></h1>
                <img src="../Admin/uploads/<?= $evenement['image'] ?>" alt="<?= $evenement['title'] ?>"
                    class="w-full rounded-lg shadow mb-6 max-h-[500px] object-cover">
                <p class="text-gray-700 leading-relaxed text-lg"><?= nl2br($evenement['description']) ?></p>
            </div>

            <!-- ... contenu précédent ... -->

            <!-- Autres événements -->
            <aside>
                <h2 class="text-2xl font-semibold text-blue-700 mb-4">Autres événements</h2>
                <div class="space-y-4">
                    <?php foreach ($autres as $ev): ?>
                        <div class="bg-white border rounded-lg shadow hover:shadow-md transition overflow-hidden">
                            <a href="evenement.php?id=<?= $ev['id'] ?>" class="flex space-x-4">
                                <img src="../Admin/uploads/<?= $ev['image'] ?>" alt="<?= $ev['title'] ?>"
                                    class="h-24 w-24 object-cover">
                                <div class="p-3">
                                    <h3 class="font-semibold text-blue-800 text-sm"><?= $ev['title'] ?></h3>
                                    <p class="text-gray-500 text-xs line-clamp-2"><?= strip_tags($ev['description']) ?></p>
                                    <span class="text-blue-600 text-xs hover:underline block mt-1">Voir plus →</span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Bouton voir tous les événements -->
                <div class="mt-6 text-center">
                    <a href="liste_evenements.php"
                        class="inline-block bg-blue-700 hover:bg-blue-800 text-white font-semibold py-2 px-4 rounded transition">
                        Voir tous les événements
                    </a>
                </div>
            </aside>

            <!-- ... suite ... -->

        </div>
    </main>

    <!-- Contact -->
    <section id="contact" class="py-16 bg-blue-800 text-white text-center">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-4">Contactez-Nous</h2>
            <p class="text-lg mb-4">Ensemble, redonnons espoir aux enfants et aux femmes.</p>
            <p>Email : <span><a href="mailto:edenfantdebout@gmail.com"
                        class="underline">edenfantdebout@gmail.com</a></span> / <span><a
                        href="mailto:safalaniayaya@gmail.com" class="underline">safalaniayaya@gmail.com</a></span>
            </p>
            <br>
            <p>Téléphone : <strong>+243 820 846 828</strong></p>
            <br>
            <p>Adresse : Province du Nord Kivu, Ville de Goma/ Quartier Katindo/ boulevard SAKE, Commune de Goma
                N°19</p>
        </div>
    </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
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