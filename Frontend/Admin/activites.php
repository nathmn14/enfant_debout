<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

include('../../Backend/request_bdd.php');

// Récupération des événements
$events = getAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Événements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-blue-800 text-white w-full">
        <div class="container mx-auto flex flex-wrap items-center justify-between px-4 py-4">
            <div class="flex items-center space-x-4">
                <img src="../assets/logo.png" alt="Logo Enfant Debout" class="h-10 w-auto sm:h-12" />
                <div>
                    <h1 class="text-lg sm:text-xl font-bold">Enfant Debout</h1>
                    <p class="text-xs sm:text-sm">ONG pour l’enfant et la femme</p>
                </div>
            </div>
            <nav class="hidden md:flex space-x-6 text-sm sm:text-base">
                <a href="#a-propos" class="hover:text-blue-200">À propos</a>
                <a href="#evenements" class="hover:text-blue-200">Événements</a>
                <a href="#education" class="hover:text-blue-200">Éducation</a>
                <a href="#sante" class="hover:text-blue-200">Santé</a>
                <a href="#protection" class="hover:text-blue-200">Protection</a>
                <a href="#contact" class="hover:text-blue-200">Contact</a>
            </nav>
            <button class="md:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-white" id="menu-button"
                aria-label="Ouvrir le menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div id="menu" class="md:hidden hidden px-4 pb-4 space-y-2 bg-blue-700">
            <a href="#a-propos" class="block py-2 text-white hover:text-blue-200">À propos</a>
            <a href="#evenements" class="block py-2 text-white hover:text-blue-200">Événements</a>
            <a href="#education" class="block py-2 text-white hover:text-blue-200">Éducation</a>
            <a href="#sante" class="block py-2 text-white hover:text-blue-200">Santé</a>
            <a href="#protection" class="block py-2 text-white hover:text-blue-200">Protection</a>
            <a href="#contact" class="block py-2 text-white hover:text-blue-200">Contact</a>
        </div>
    </header>

    <div class="bg-white shadow">
        <div class="container mx-auto p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-800">Administration des Événements</h2>
            <form method="POST" action="logout.php" class="w-full md:w-auto">
                <button type="submit"
                    class="w-full md:w-auto bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl transition">
                    Déconnexion
                </button>
            </form>
        </div>
    </div>

    <main class="max-w-4xl mx-auto p-4 space-y-6 flex-1 w-full">

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded-xl">
                Événement supprimé avec succès.
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded-xl">
                Erreur lors de la suppression.
            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <input id="searchInput" type="text" placeholder="Rechercher un événement..."
                class="w-full sm:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <a href="ajouter.php" class="w-full sm:w-auto">
                <button
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl transition">
                    + Ajouter un événement
                </button>
            </a>
        </div>

        <div id="eventsList" class="mt-10">
            <?php if (empty($events)): ?>
                <div id="noEventsMessage" class="text-center text-gray-600 bg-white p-6 rounded-2xl shadow">
                    Aucune activité encore disponible, veuillez en ajouter une.
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($events as $event): ?>
                        <div class="flex flex-col bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1"
                            data-aos="zoom-in">
                            <img src="uploads/<?= htmlspecialchars($event['image']) ?>"
                                alt="<?= htmlspecialchars($event['title']) ?>" class="w-full h-56 object-cover">

                            <div class="p-5 flex flex-col justify-between flex-1">
                                <div>
                                    <h3 class="text-xl font-semibold text-blue-700 mb-2">
                                        <?= htmlspecialchars($event['title']) ?>
                                    </h3>
                                    <p class="text-gray-600 text-sm line-clamp-4">
                                        <?= nl2br(htmlspecialchars($event['description'])) ?>
                                    </p>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-3">
                                    <a href="modifier.php?id=<?= urlencode($event['id']) ?>" class="flex-1">
                                        <button
                                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-xl font-medium transition duration-200">
                                            Modifier
                                        </button>
                                    </a>
                                    <a href="supprimer.php?id=<?= urlencode($event['id']) ?>"
                                        onclick="return confirm('Supprimer cet événement ?');" class="flex-1">
                                        <button
                                            class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-xl font-medium transition duration-200">
                                            Supprimer
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </main>

    <script>
        const menuButton = document.getElementById('menu-button');
        const menu = document.getElementById('menu');

        menuButton.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        const searchInput = document.getElementById('searchInput');
        const eventsList = document.getElementById('eventsList');
        const eventItems = Array.from(eventsList.getElementsByClassName('eventItem'));
        const noEventsMessage = document.getElementById('noEventsMessage');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();

            let visibleCount = 0;
            eventItems.forEach(item => {
                const title = item.querySelector('.eventTitle').textContent.toLowerCase();
                const description = item.querySelector('.eventDescription').textContent.toLowerCase();

                if (title.includes(query) || description.includes(query)) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                if (noEventsMessage) {
                    noEventsMessage.style.display = 'block';
                    noEventsMessage.textContent = 'Aucune activité correspondant à votre recherche.';
                } else {
                    const msg = document.createElement('div');
                    msg.id = 'noEventsMessage';
                    msg.className = 'text-center text-gray-600 bg-white p-6 rounded-2xl shadow';
                    msg.textContent = 'Aucune activité correspondant à votre recherche.';
                    eventsList.appendChild(msg);
                }
            } else {
                if (noEventsMessage) noEventsMessage.style.display = 'none';
            }
        });
    </script>

</body>

</html>