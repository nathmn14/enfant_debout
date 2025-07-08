<?php
// Inclure la fonction getAll depuis request_bdd.php
require_once '../../Backend/request_bdd.php';

// Ajoutez ceci si $pdo n'est pas déjà défini dans request_bdd.php


$evenements = getAll();
$dernier_evenement = count($evenements) > 0 ? $evenements[0] : null;

// Fonction pour tronquer le texte proprement
function resume_texte($texte, $limite = 350) {
    $texte = strip_tags($texte);
    if (mb_strlen($texte) > $limite) {
        $texte = mb_substr($texte, 0, $limite) . '...';
        return $texte;
    }
    return $texte;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Enfant Debout - ONG</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#1e40af',
                    secondary: '#2563eb',
                    accent: '#f1f5f9',
                },
            },
        },
        plugins: [tailwindcssLineClamp],
    }
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=line-clamp"></script>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* Custom scrollbar for gallery */
        ::-webkit-scrollbar {
            width: 8px;
            background: #e0e7ef;
        }
        ::-webkit-scrollbar-thumb {
            background: #2563eb;
            border-radius: 4px;
        }
        /* Mobile menu overlay */
        #mobile-menu.active {
            display: block !important;
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
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

<body class="bg-gray-50 font-sans text-gray-900">
    <!-- Navbar -->
    <header class="bg-blue-800 text-white shadow-md sticky top-0 z-30">
        <div class="container mx-auto flex items-center justify-between px-4 py-4">
            <div class="flex items-center space-x-4">
                <img src="../assets/logo.png" alt="Logo Enfant Debout" class="h-10 w-auto sm:h-12">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold">Enfant Debout</h1>
                    <p class="text-xs sm:text-sm">ONG pour l’enfant et la femme</p>
                </div>
            </div>
            <nav class="hidden md:flex space-x-4 lg:space-x-6 text-base">
                <a href="#a-propos" class="hover:text-blue-200 transition">À propos</a>
                <a href="#evenements" class="hover:text-blue-200 transition">Événements</a>
                <a href="#education" class="hover:text-blue-200 transition">Éducation</a>
                <a href="#sante" class="hover:text-blue-200 transition">Santé</a>
                <a href="#protection" class="hover:text-blue-200 transition">Protection</a>
                <a href="#contact" class="hover:text-blue-200 transition">Contact</a>
            </nav>
            <button class="md:hidden focus:outline-none" id="menu-button" aria-label="Ouvrir le menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <!-- Menu mobile -->
        <div class="md:hidden hidden bg-blue-700 px-4 pb-4 transition-all duration-300 ease-in-out" id="mobile-menu">
            <nav class="flex flex-col space-y-2 text-white text-lg">
                <a href="#a-propos" class="py-2 hover:text-blue-200">À propos</a>
                <a href="#evenements" class="py-2 hover:text-blue-200">Événements</a>
                <a href="#education" class="py-2 hover:text-blue-200">Éducation</a>
                <a href="#sante" class="py-2 hover:text-blue-200">Santé</a>
                <a href="#protection" class="py-2 hover:text-blue-200">Protection</a>
                <a href="#contact" class="py-2 hover:text-blue-200">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative min-h-[70vh] sm:min-h-[85vh] flex items-center justify-center overflow-hidden text-white" id="hero-carousel">
        <div id="carousel-container"
            class="absolute inset-0 w-full h-full transition-opacity duration-1000 bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-black bg-opacity-60 z-0"></div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
            <h2 id="carousel-title"
                class="text-2xl sm:text-3xl md:text-5xl font-bold mb-4 opacity-0 transform translate-y-5 transition-all duration-1000 drop-shadow-lg">
                Pour un avenir digne pour chaque enfant
            </h2>
            <p id="carousel-description"
                class="text-base sm:text-lg md:text-xl mb-6 opacity-0 transform translate-y-5 transition-all duration-1000 delay-200 drop-shadow">
                Ensemble, construisons un monde plus juste pour les plus vulnérables.
            </p>
            <a href="#contact"
                class="bg-white text-blue-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition transform hover:scale-105 shadow-lg">
                Nous contacter
            </a>
        </div>
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white animate-bounce z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
    </section>

    <main>
        <!-- À propos -->
        <section id="a-propos" class="py-16 sm:py-20 bg-gray-100 text-center">
            <div class="container mx-auto px-4 sm:px-6 max-w-6xl">
                <h2 class="text-3xl sm:text-4xl font-bold text-blue-800 mb-8" data-aos="fade-up">À propos de l'ONG</h2>
                <div class="md:flex items-center gap-8">
                    <img src="../assets/apropos.jpg" alt="À propos"
                        class="rounded-lg shadow-lg w-full md:w-1/2 mb-6 md:mb-0 object-cover max-h-80" data-aos="fade-right">
                    <div class="text-left md:w-1/2 space-y-4" data-aos="fade-left">
                        <p class="text-base sm:text-lg text-gray-700">
                            <span class="font-semibold text-blue-700">Historique :</span>
                            Créée le 10 mai 2021 à Kinshasa par Madame Mandey Mobiani Daddy Rosalie, l’association <strong>Enfant Debout (ED)</strong> œuvre sans but lucratif pour la défense des droits des enfants et des femmes en République Démocratique du Congo.
                        </p>
                        <p class="text-base sm:text-lg text-gray-700">
                            <span class="font-semibold text-blue-700">Siège social :</span>
                            N°4 avenue Équateur, 12<sup>ème</sup> Rue Résidentiel, quartier général Masiala, commune de Limeté, Kinshasa. Représentation à Goma, boulevard Sake, Quartier Katindo n°219.
                        </p>
                        <p class="text-base sm:text-lg text-gray-700">
                            <span class="font-semibold text-blue-700">Durée & domaines d’intervention :</span>
                            L’ONG est créée pour une durée indéterminée et intervient dans l’éducation, la santé, la protection, les affaires sociales et l’humanitaire.
                        </p>
                        <p class="text-base sm:text-lg text-gray-700">
                            Nous croyons qu’un enfant debout aujourd’hui est un peuple debout demain.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Présentation -->
        <section id="presentation" class="bg-white py-16 sm:py-20 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto text-center">
                <h2 class="text-3xl sm:text-4xl font-bold text-indigo-700 mb-4" data-aos="fade-up">Qui sommes-nous ?</h2>
                <p class="text-base sm:text-lg text-gray-700 mb-6 sm:mb-8 leading-relaxed" data-aos="fade-up" data-aos-delay="100">
                    <strong>Enfant Debout</strong> est une organisation sans but lucratif engagée dans la défense des droits et du bien-être des enfants et des communautés vulnérables en République Démocratique du Congo.
                </p>
                <p class="text-base sm:text-lg text-gray-700 mb-6 sm:mb-8 leading-relaxed" data-aos="fade-up" data-aos-delay="150">
                    Fondée par madame <strong>MANDEY MOBIANI DADDY Rosalie</strong> à Kinshasa, le <strong>10 mai 2021</strong>, avec la vision de bâtir une société plus équitable pour les plus jeunes.
                </p>
                <p class="text-base sm:text-lg text-gray-700 mb-6 sm:mb-8 leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                    Siège social : N°4 avenue Équateur, 12<sup>ème</sup> Rue Résidentiel, quartier général Masiala, commune de Limeté. Représentation à Goma, boulevard Sake, Quartier Katindo N°219.
                </p>
            </div>
            <!-- Domaines d’intervention -->
            <div class="max-w-6xl mx-auto mb-12">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center" data-aos="zoom-in">Domaines d’intervention</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div class="bg-indigo-50 p-4 sm:p-6 rounded-xl shadow hover:shadow-xl transition transform hover:scale-105"
                        data-aos="zoom-in-up">
                        <h4 class="text-base sm:text-lg font-semibold text-indigo-700">📘 Éducation</h4>
                    </div>
                    <div class="bg-indigo-50 p-4 sm:p-6 rounded-xl shadow hover:shadow-xl transition transform hover:scale-105"
                        data-aos="zoom-in-up" data-aos-delay="100">
                        <h4 class="text-base sm:text-lg font-semibold text-indigo-700">🛡️ Protection de l’Enfant</h4>
                    </div>
                    <div class="bg-indigo-50 p-4 sm:p-6 rounded-xl shadow hover:shadow-xl transition transform hover:scale-105"
                        data-aos="zoom-in-up" data-aos-delay="200">
                        <h4 class="text-base sm:text-lg font-semibold text-indigo-700">🏥 Santé</h4>
                    </div>
                    <div class="bg-indigo-50 p-4 sm:p-6 rounded-xl shadow hover:shadow-xl transition transform hover:scale-105"
                        data-aos="zoom-in-up" data-aos-delay="300">
                        <h4 class="text-base sm:text-lg font-semibold text-indigo-700">🥗 Nutrition</h4>
                    </div>
                    <div class="bg-indigo-50 p-4 sm:p-6 rounded-xl shadow hover:shadow-xl transition transform hover:scale-105"
                        data-aos="zoom-in-up" data-aos-delay="400">
                        <h4 class="text-base sm:text-lg font-semibold text-indigo-700">👩 Droit de la femme</h4>
                    </div>
                    <div class="bg-indigo-50 p-4 sm:p-6 rounded-xl shadow hover:shadow-xl transition transform hover:scale-105"
                        data-aos="zoom-in-up" data-aos-delay="500">
                        <h4 class="text-base sm:text-lg font-semibold text-indigo-700">🕊️ Paix & Démocratie</h4>
                    </div>
                </div>
            </div>
            <!-- Domaine d'intervention détaillé -->
            <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-8 mt-8">
                <div class="text-left bg-gray-50 rounded-xl p-6 shadow" data-aos="fade-right">
                    <h3 class="text-xl font-semibold text-indigo-700 mb-2">Éducation et Formation</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>Promouvoir l'éducation des enfants</li>
                        <li>Insertion sociale et initiatives pratiques</li>
                    </ul>
                </div>
                <div class="text-left bg-gray-50 rounded-xl p-6 shadow" data-aos="fade-left">
                    <h3 class="text-xl font-semibold text-indigo-700 mb-2">Santé</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>Éducation sanitaire (formations infirmiers A1/A2)</li>
                        <li>Assainissement, construction de latrines</li>
                        <li>Autres besoins sanitaires</li>
                    </ul>
                </div>
                <div class="text-left bg-gray-50 rounded-xl p-6 shadow" data-aos="fade-right">
                    <h3 class="text-xl font-semibold text-indigo-700 mb-2">Affaires Sociales</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>Apprentissage de métiers (couture, maçonnerie, mécanique, électricité, etc.)</li>
                    </ul>
                </div>
                <div class="text-left bg-gray-50 rounded-xl p-6 shadow" data-aos="fade-left">
                    <h3 class="text-xl font-semibold text-indigo-700 mb-2">Humanitaire</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        <li>Protection des enfants face aux enjeux actuels</li>
                        <li>Aide aux filles vulnérables (violées, mères, non scolarisées)</li>
                    </ul>
                </div>
            </div>
            <!-- Mission & Vision -->
            <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mt-16">
                <div class="bg-gray-100 p-8 rounded-xl shadow" data-aos="fade-right">
                    <h3 class="text-xl sm:text-2xl font-semibold text-indigo-700 mb-4">🎯 Notre mission</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Apporter un soutien moral, psychologique et une protection aux enfants désœuvrés et en situation difficile, en impliquant toutes les parties prenantes pour améliorer les conditions de vie des couches vulnérables.
                    </p>
                </div>
                <div class="bg-gray-100 p-8 rounded-xl shadow" data-aos="fade-left">
                    <h3 class="text-xl sm:text-2xl font-semibold text-indigo-700 mb-4">🚀 Notre vision</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Être une organisation de référence pour les personnes vulnérables et les communautés les plus défavorisées de la RDC, en leur offrant un moyen d'améliorer leurs conditions de vie.
                    </p>
                </div>
            </div>
        </section>

        <!-- Actualités -->
        <section id="actualites" class="py-12 sm:py-16 bg-gradient-to-b from-blue-50 to-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-8" data-aos="fade-up">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-10 mb-10">
                    <div class="md:w-1/2 text-center md:text-left">
                        <h2 class="text-3xl sm:text-4xl font-bold text-blue-800 mb-4">Actualités</h2>
                        <?php if ($dernier_evenement): ?>
                            <h3 class="text-2xl font-semibold text-blue-700 mb-2"><?= htmlspecialchars($dernier_evenement['title']) ?></h3>
                            <?php
                                $texte = $dernier_evenement['description'];
                                $limite = 350;
                                $texte_resume = resume_texte($texte, $limite);
                                $texte_long = mb_strlen(strip_tags($texte)) > $limite;
                            ?>
                            <p class="text-lg text-gray-700 mb-6">
                                <?= nl2br(htmlspecialchars($texte_resume)) ?>
                                <?php if ($texte_long): ?>
                                    <br>
                                    <a href="evenement.php?id=<?= $dernier_evenement['id'] ?>" class="inline-block bg-blue-700 text-white px-4 py-2 rounded-md font-semibold shadow hover:bg-blue-800 transition mt-2">En savoir plus</a>
                                <?php endif; ?>
                            </p>
                            <?php if (!$texte_long): ?>
                                <a href="evenement.php?id=<?= $dernier_evenement['id'] ?>" class="inline-block bg-blue-700 text-white px-6 py-3 rounded-md font-semibold shadow hover:bg-blue-800 transition">En savoir plus</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-lg text-gray-700 mb-6">Aucune actualité disponible pour le moment.</p>
                        <?php endif; ?>
                    </div>
                    <div class="md:w-1/2 grid grid-cols-2 gap-4">
                        <?php if ($dernier_evenement): ?>
                            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100 col-span-2">
                                <img src="../Admin/uploads/<?= htmlspecialchars($dernier_evenement['image']) ?>" alt="<?= htmlspecialchars($dernier_evenement['title']) ?>" class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-105 group-hover:brightness-90" />
                            </div>
                        <?php else: ?>
                            <!-- ...images statiques si pas d'événement... -->
                            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                                <img src="../assets/slides/slide1.jpg" alt="Actualité 1" class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-105 group-hover:brightness-90" />
                            </div>
                            <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                                <img src="../assets/slides/slide2.jpg" alt="Actualité 2" class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-105 group-hover:brightness-90" />
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galerie -->
        <div class="max-w-6xl mx-auto px-4 sm:px-0" data-aos="fade-up">
            <h3 class="text-2xl font-semibold text-gray-800 text-center mb-6">🖼️ Galerie</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 md:gap-5">
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide1.jpg" alt="Image 1" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide1.jpg', 'Image de la galerie')" />
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide2.jpg" alt="Image 2" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide2.jpg', 'Image de la galerie')" />
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide3.jpg" alt="Image 3" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide3.jpg', 'Image de la galerie')" />
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide4.jpg" alt="Image 4" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide4.jpg', 'Image de la galerie')" />
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide6.jpg" alt="Image 5" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide6.jpg', 'Image de la galerie')" />
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide7.jpg" alt="Image 6" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide7.jpg', 'Image de la galerie')" />
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide8.jpg" alt="Image 7" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide8.jpg', 'Image de la galerie')" />
                </div>
                <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all aspect-[4/3] bg-gray-100">
                    <img src="../assets/slides/slide9.jpg" alt="Image 8" 
                         class="w-full h-full object-cover rounded-2xl transition-transform duration-300 group-hover:scale-110 group-hover:brightness-90 image-gallery cursor-pointer"
                         onclick="openModal('../assets/slides/slide9.jpg', 'Image de la galerie')" />
                </div>
            </div>
            <center>
                <div class="mt-10">
                    <a href="photos.php"
                        class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition shadow">
                        Voir toutes les photos
                    </a>
                </div>
            </center>
        </div>

        <!-- Événements dynamiques -->
        <section id="evenements" class="pt-20 pb-10 bg-white text-center">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">

                <h2 class="text-4xl font-bold text-blue-800 mb-10" data-aos="fade-up">Événements & Activités</h2>

                <?php if (count($evenements) > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                    <?php
                        $compteur = 0;
                        foreach ($evenements as $evenement):
                            if ($compteur >= 4)
                                break;
                            $compteur++;
                            ?>
                    <div class="flex flex-col bg-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1"
                        data-aos="zoom-in">
                        <?php
                        // Récupérer les images secondaires
                        $images = [];
                        $stmt = $bdd->prepare("SELECT image FROM activity_images WHERE activity_id = ?");
                        $stmt->execute([$evenement['id']]);
                        $images = $stmt->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <img src="../Admin/uploads/<?= htmlspecialchars($evenement['image']) ?>" alt="<?= htmlspecialchars($evenement['title']) ?>" 
                             class="w-full h-56 object-cover image-gallery cursor-pointer"
                             onclick="openModal('../Admin/uploads/<?= htmlspecialchars($evenement['image']) ?>', '<?= htmlspecialchars($evenement['title']) ?>')">
                        <?php if ($images): ?>
                            <div class="flex gap-2 mt-2">
                                <?php foreach ($images as $img): ?>
                                    <img src="../Admin/uploads/<?= htmlspecialchars($img) ?>" alt="Image secondaire" 
                                         class="w-16 h-16 object-cover rounded image-gallery cursor-pointer"
                                         onclick="openModal('../Admin/uploads/<?= htmlspecialchars($img) ?>', 'Image de l\'événement')">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="p-5 flex flex-col justify-between flex-1">
                            <div>
                                <h3 class="text-xl font-semibold text-blue-700 mb-2"><?= $evenement['title'] ?></h3>
                                <p class="text-gray-600 text-sm line-clamp-4">
                                    <?= nl2br($evenement['description']) ?>
                                </p>
                            </div>
                            <a href="evenement.php?id=<?= $evenement['id'] ?>"
                                class="mt-4 inline-block text-blue-600 font-semibold hover:underline transition">
                                En savoir plus →
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Bouton Tout voir -->
                <div class="mt-10">
                    <a href="liste_evenements.php"
                        class="inline-block bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 transition">
                        Voir tous les événements
                    </a>
                </div>

                <?php else: ?>
                <p class="text-gray-600">Aucun événement disponible pour le moment.</p>
                <?php endif; ?>
            </div>
        </section>


        <!-- Éducation -->
        <section id="education" class="pt-10 pb-20 bg-white text-center">

            <div class="container mx-auto px-6 max-w-6xl">
                <h2 class="text-4xl font-bold text-blue-800 mb-8" data-aos="fade-up">Éducation</h2>
                <p class="text-lg text-gray-700 mb-8 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Nous garantissons l'accès à une éducation inclusive et de qualité pour les enfants, en
                    particulier
                    les filles,
                    afin qu'ils puissent construire leur avenir et briser le cycle de la pauvreté.
                </p>
                <div class="grid md:grid-cols-2 gap-6">
                    <img src="../assets/education1.jpg" alt="Éducation" class="rounded-lg shadow-md" data-aos="zoom-in">
                    <div class="text-left flex flex-col justify-center" data-aos="fade-left">
                        <p class="text-gray-700 mb-4">
                            Grâce à nos partenariats avec les écoles locales, nous distribuons du matériel scolaire,
                            finançons les frais
                            de scolarité, et organisons des ateliers éducatifs innovants centrés sur les compétences
                            de
                            vie.
                        </p>
                        <p class="text-gray-700">
                            Notre objectif est de faire de chaque salle de classe un lieu d’éveil, de savoir, mais
                            aussi
                            de protection.
                        </p>
                    </div>
                </div>
            </div>
        </section>


        <!-- Santé -->
        <section id="sante" class="py-20 bg-gray-100 text-center">
            <div class="container mx-auto px-6 max-w-6xl">
                <h2 class="text-4xl font-bold text-blue-800 mb-8" data-aos="fade-up">Santé</h2>
                <p class="text-lg text-gray-700 mb-8 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Parce qu’un enfant en bonne santé est un enfant qui peut apprendre, jouer et rêver, notre ONG
                    œuvre
                    pour l’accès équitable aux soins médicaux essentiels.
                </p>
                <div class="grid md:grid-cols-2 gap-6 items-center">
                    <div class="text-left" data-aos="fade-right">
                        <p class="text-gray-700 mb-4">
                            En partenariat avec des centres de santé communautaires, nous menons des campagnes de
                            vaccination,
                            des consultations mobiles et des programmes de sensibilisation à l’hygiène et à la
                            nutrition.
                        </p>
                        <p class="text-gray-700">
                            Nous mettons l’accent sur la santé mentale, souvent négligée, mais cruciale pour le
                            développement harmonieux des enfants.
                        </p>
                    </div>
                    <img src="../assets/sante1.jpg" alt="Santé" class="rounded-lg shadow-md" data-aos="zoom-in">
                </div>
            </div>
        </section>


        <!-- Protection -->
        <section id="protection" class="py-20 bg-white text-center">
            <div class="container mx-auto px-6 max-w-6xl">
                <h2 class="text-4xl font-bold text-blue-800 mb-8" data-aos="fade-up">Protection</h2>
                <p class="text-lg text-gray-700 mb-8 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Nous luttons contre toutes les formes de violence, d'exploitation et de négligence à l’encontre
                    des
                    enfants et des femmes.
                </p>
                <div class="md:flex items-center gap-6">
                    <img src="../assets/protection1.jpg" alt="Protection"
                        class="rounded-lg shadow-md md:w-1/2 mb-6 md:mb-0" data-aos="zoom-in">
                    <div class="text-left md:w-1/2" data-aos="fade-left">
                        <p class="text-gray-700 mb-4">
                            Nos programmes comprennent des activités de sensibilisation, des prises en charge
                            psychologiques, et un accompagnement
                            juridique pour les victimes.
                        </p>
                        <p class="text-gray-700">
                            Nous travaillons main dans la main avec les autorités locales pour faire respecter les
                            droits et créer un environnement
                            sûr pour chaque enfant.
                        </p>
                    </div>
                </div>
            </div>
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
    <footer class="bg-gray-800 text-white py-6 mt-0">
        <div class="container mx-auto text-center px-4">
            <p class="text-sm">&copy; 2025 Enfant Debout. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Modal pour les images -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
        <div class="nav-arrow prev" onclick="changeImage(-1)">&#10094;</div>
        <div class="nav-arrow next" onclick="changeImage(1)">&#10095;</div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
    const swiper = new Swiper(".mySwiper", {
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        autoplay: {
            delay: 5000,
        },
    });
    </script>

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
        
        // Initialiser la galerie au chargement de la page
        document.addEventListener('DOMContentLoaded', initializeGallery);
    </script>

    <script>
    //Carousel Hero
    const slides = [{
            image: "../assets/carousel/hero.jpg",
            title: "Pour un avenir digne pour chaque enfant",
            description: "Ensemble, construisons un monde plus juste pour les plus vulnérables.",
        },
        {
            image: "../assets/carousel/hero2.jpg",
            title: "Éduquer, soigner, protéger",
            description: "Chaque action compte pour redonner le sourire à un enfant.",
        },
        {
            image: "../assets/carousel/hero3.jpg",
            title: "Votre engagement peut changer des vies",
            description: "Rejoignez notre mission pour bâtir un avenir meilleur.",
        },
    ];

    let currentSlide = 0;

    const container = document.getElementById("carousel-container");
    const title = document.getElementById("carousel-title");
    const description = document.getElementById("carousel-description");

    function showSlide(index) {
        const slide = slides[index];

        // Image : transition fondue
        container.style.opacity = 0;
        setTimeout(() => {
            container.style.backgroundImage = `url('${slide.image}')`;
            container.style.opacity = 1;
        }, 500);

        // Texte : retrait + ajout de classe pour animer
        title.classList.add("opacity-0", "translate-y-5");
        description.classList.add("opacity-0", "translate-y-5");

        setTimeout(() => {
            title.textContent = slide.title;
            description.textContent = slide.description;

            title.classList.remove("opacity-0", "translate-y-5");
            description.classList.remove("opacity-0", "translate-y-5");
        }, 600);
    }

    // Lancer le premier slide
    showSlide(currentSlide);
    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }, 6000); // toutes les 6 secondes
    </script>

    <!-- Fin carrousel -->


    <script>
    document.getElementById("menu-button").addEventListener("click", function() {
        const menu = document.getElementById("mobile-menu");
        menu.classList.toggle("hidden");
        menu.classList.toggle("active");
    });
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000, // Durée plus fluide
        easing: 'ease-in-out', // Animation plus douce
        once: true, // Ne se rejoue pas au scroll
        offset: 100 // Déclenche plus tôt
    });
    </script>


</body>

</html>