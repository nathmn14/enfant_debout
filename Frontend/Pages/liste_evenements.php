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
    <style>
        .historique-section {
            background-color: #f9fafb;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
        }

        .historique-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .historique-item {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .historique-item img {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .historique-item h3 {
            font-size: 1.5rem;
            color: #1e3a8a;
            margin-bottom: 0.5rem;
        }

        .historique-item p {
            font-size: 1rem;
            color: #4b5563;
            margin-bottom: 1rem;
        }

        .historique-item .details-link {
            font-size: 1rem;
            color: #2563eb;
            text-decoration: underline;
            cursor: pointer;
        }
        
        /* Styles pour le modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            animation: fadeIn 0.3s ease-in-out;
        }
        
        .modal-content {
            position: relative;
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 90%;
            top: 50%;
            transform: translateY(-50%);
            animation: zoomIn 0.3s ease-in-out;
        }
        
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1001;
        }
        
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
        }
        
        .image-gallery {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        
        .image-gallery:hover {
            transform: scale(1.05);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes zoomIn {
            from { transform: translateY(-50%) scale(0.8); }
            to { transform: translateY(-50%) scale(1); }
        }
        
        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            padding: 16px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            transition: background-color 0.3s;
        }
        
        .nav-arrow:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        
        .prev {
            left: 20px;
        }
        
        .next {
            right: 20px;
        }
    </style>
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
                        <div class="relative">
                            <img src="../Admin/uploads/<?= $event['image'] ?>" alt="<?= $event['title'] ?>"
                                class="w-full h-48 object-cover image-gallery cursor-pointer"
                                onclick="openModal('../Admin/uploads/<?= $event['image'] ?>', '<?= htmlspecialchars($event['title']) ?>')">
                            <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                <div class="opacity-0 hover:opacity-100 transition-opacity duration-300">
                                    <span class="text-white text-sm bg-black bg-opacity-50 px-2 py-1 rounded">Cliquer pour agrandir</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-blue-700 mb-2"><?= $event['title'] ?></h2>
                            <p class="text-gray-600 text-sm line-clamp-3"><?= strip_tags($event['description']) ?></p>
                            <a href="evenement.php?id=<?= $event['id'] ?>" class="text-blue-600 hover:underline mt-3 inline-block">Voir l'événement →</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600">Aucun événement disponible pour le moment.</p>
        <?php endif; ?>
    </main>

    <!-- Section Historique -->
    <section class="historique-section">
        <h2 class="historique-title">Historique des événements</h2>
        <?php if (count($evenements) > 0): ?>
            <?php foreach ($evenements as $event): ?>
                <div class="historique-item">
                    <img src="../Admin/uploads/<?= $event['image'] ?>" alt="<?= $event['title'] ?>" 
                         class="image-gallery cursor-pointer"
                         onclick="openModal('../Admin/uploads/<?= $event['image'] ?>', '<?= htmlspecialchars($event['title']) ?>')">
                    <h3><?= $event['title'] ?></h3>
                    <p><?= strip_tags($event['description']) ?></p>
                    <a href="evenement.php?id=<?= $event['id'] ?>" class="details-link">Voir les détails →</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600">Aucun événement disponible pour le moment.</p>
        <?php endif; ?>
    </section>

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
    <!-- Modal pour les images -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
        <div class="nav-arrow prev" onclick="changeImage(-1)">&#10094;</div>
        <div class="nav-arrow next" onclick="changeImage(1)">&#10095;</div>
    </div>

    <script>
        // Variables globales pour la galerie
        let currentImageIndex = 0;
        let images = [];
        
        // Récupérer toutes les images de la page
        function initializeGallery() {
            const imageElements = document.querySelectorAll('.image-gallery');
            images = Array.from(imageElements).map(img => ({
                src: img.src,
                alt: img.alt
            }));
        }
        
        // Ouvrir le modal
        function openModal(imageSrc, imageAlt) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            
            // Trouver l'index de l'image cliquée
            currentImageIndex = images.findIndex(img => img.src === imageSrc);
            if (currentImageIndex === -1) currentImageIndex = 0;
            
            modalImg.src = imageSrc;
            modalImg.alt = imageAlt;
            modal.style.display = "block";
            document.body.style.overflow = 'hidden'; // Empêcher le scroll
        }
        
        // Fermer le modal
        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = "none";
            document.body.style.overflow = 'auto'; // Réactiver le scroll
        }
        
        // Changer d'image
        function changeImage(direction) {
            currentImageIndex += direction;
            
            if (currentImageIndex >= images.length) {
                currentImageIndex = 0;
            } else if (currentImageIndex < 0) {
                currentImageIndex = images.length - 1;
            }
            
            const modalImg = document.getElementById('modalImage');
            modalImg.src = images[currentImageIndex].src;
            modalImg.alt = images[currentImageIndex].alt;
        }
        
        // Fermer le modal en cliquant en dehors de l'image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
        
        // Navigation au clavier
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (modal.style.display === 'block') {
                if (e.key === 'Escape') {
                    closeModal();
                } else if (e.key === 'ArrowLeft') {
                    changeImage(-1);
                } else if (e.key === 'ArrowRight') {
                    changeImage(1);
                }
            }
        });
        
        // Menu mobile
        document.getElementById("menu-button").addEventListener("click", function () {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        });
        
        // Initialiser la galerie au chargement de la page
        document.addEventListener('DOMContentLoaded', initializeGallery);
    </script>
</body>

</html>