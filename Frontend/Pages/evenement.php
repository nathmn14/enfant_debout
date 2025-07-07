<?php
require_once '../../Backend/request_bdd.php';

// Ajoutez ceci si $pdo n'est pas déjà défini dans request_bdd.php
if (!isset($pdo)) {
    $pdo = new PDO('mysql:host=localhost;dbname=enfant_debout;charset=utf8mb4', 'root', '');
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location:Accueil.php");
    exit();
}

$evenement = getEventById($id);
$autres = getOtherEvents($id);

// Récupérer les images secondaires
$images = [];
$stmt = $pdo->prepare("SELECT image FROM activity_images WHERE activity_id = ?");
$stmt->execute([$evenement['id']]);
$images = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $evenement['title'] ?> - Enfant Debout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
                
                <!-- Image principale -->
                <img src="../Admin/uploads/<?= $evenement['image'] ?>" alt="<?= $evenement['title'] ?>"
                    class="w-full rounded-lg shadow mb-6 max-h-[500px] object-cover image-gallery cursor-pointer"
                    onclick="openModal('../Admin/uploads/<?= $evenement['image'] ?>', '<?= htmlspecialchars($evenement['title']) ?>')">
                
                <p class="text-gray-700 leading-relaxed text-lg"><?= nl2br($evenement['description']) ?></p>
                
                <!-- Images secondaires -->
                <?php if ($images): ?>
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-blue-700 mb-4">Galerie d'images</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            <?php foreach ($images as $img): ?>
                                <img src="../Admin/uploads/<?= htmlspecialchars($img) ?>" alt="Image secondaire"
                                    class="w-full h-32 object-cover rounded-lg shadow image-gallery cursor-pointer"
                                    onclick="openModal('../Admin/uploads/<?= htmlspecialchars($img) ?>', 'Image de l\'événement')">
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Autres événements -->
            <aside>
                <h2 class="text-2xl font-semibold text-blue-700 mb-4">Autres événements</h2>
                <div class="space-y-4">
                    <?php foreach ($autres as $ev): ?>
                        <div class="bg-white border rounded-lg shadow hover:shadow-md transition overflow-hidden">
                            <a href="evenement.php?id=<?= $ev['id'] ?>" class="flex space-x-4">
                                <img src="../Admin/uploads/<?= $ev['image'] ?>" alt="<?= $ev['title'] ?>"
                                    class="h-24 w-24 object-cover image-gallery cursor-pointer"
                                    onclick="event.preventDefault(); openModal('../Admin/uploads/<?= $ev['image'] ?>', '<?= htmlspecialchars($ev['title']) ?>')">
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