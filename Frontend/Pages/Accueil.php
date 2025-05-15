<?php
// Inclure la fonction getAll depuis request_bdd.php
require_once '../../Backend/request_bdd.php';

$evenements = getAll();
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
                extend: {},
            },
            plugins: [tailwindcssLineClamp],
        }
    </script>
    <script src="https://cdn.tailwindcss.com?plugins=line-clamp"></script>


</head>


<body class="bg-gray-50 font-sans text-gray-900">

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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <!-- Menu mobile -->
        <!-- Menu mobile -->
        <div class="md:hidden hidden bg-blue-700 px-4 pb-4 transition-all duration-300 ease-in-out" id="mobile-menu">

            <nav class="flex flex-col space-y-2 text-white">
                <a href="#a-propos">À propos</a>
                <a href="#evenements">Événements</a>
                <a href="#education">Éducation</a>
                <a href="#sante">Santé</a>
                <a href="#protection">Protection</a>
                <a href="#contact">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative h-[95vh] overflow-hidden text-white" id="hero-carousel">
        <!-- Conteneur des slides -->
        <div id="carousel-container"
            class="absolute inset-0 w-full h-full transition-opacity duration-1000 bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-black bg-opacity-60 z-0"></div>

        <!-- Contenu -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
            <h2 id="carousel-title"
                class="text-3xl md:text-5xl font-bold mb-4 opacity-0 transform translate-y-5 transition-all duration-1000">
                Pour un avenir digne pour chaque enfant
            </h2>
            <p id="carousel-description"
                class="text-lg md:text-xl mb-6 opacity-0 transform translate-y-5 transition-all duration-1000 delay-200">
                Ensemble, construisons un monde plus juste pour les plus vulnérables.
            </p>
            <a href="#contact"
                class="bg-white text-blue-800 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition transform hover:scale-105">
                Nous contacter
            </a>
        </div>
    </section>
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>


    </section>


    <main>
        <!-- À propos -->
        <section id="a-propos" class="py-20 bg-gray-100 text-center">
            <div class="container mx-auto px-6 max-w-6xl">
                <h2 class="text-4xl font-bold text-blue-800 mb-8" data-aos="fade-up">À propos de l'ONG</h2>
                <div class="md:flex items-center gap-8">
                    <img src="../assets/apropos.jpg" alt="À propos"
                        class="rounded-lg shadow-lg w-full md:w-1/2 mb-6 md:mb-0" data-aos="fade-right">
                    <div class="text-left md:w-1/2" data-aos="fade-left">
                        <p class="text-lg text-gray-700 mb-4">
                            L’ONG <strong>Enfant Debout</strong> est née d’une volonté farouche de défendre les droits
                            fondamentaux
                            des enfants et des femmes en République Démocratique du Congo.
                        </p>
                        <p class="text-lg text-gray-700 mb-4">
                            Depuis sa création, elle s’est donnée pour mission d’intervenir dans les domaines clés que
                            sont l’éducation,
                            la santé et la protection des droits, pour que chaque enfant et chaque femme vive dans la
                            dignité, l’égalité et la sécurité.
                        </p>
                        <p class="text-lg text-gray-700">
                            Nous croyons qu’un enfant debout aujourd’hui est un peuple debout demain.
                        </p>
                    </div>
                </div>
            </div>
        </section>


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
                                <img src="../Admin/uploads/<?= $evenement['image'] ?>" alt="<?= $evenement['title'] ?>"
                                    class="w-full h-56 object-cover">

                                <div class="p-5 flex flex-col justify-between flex-1">
                                    <div>
                                        <h3 class="text-xl font-semibold text-blue-700 mb-2"><?= $evenement['title'] ?></h3>
                                        <p class="text-gray-600 text-sm line-clamp-4"><?= nl2br($evenement['description']) ?>
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
                    Nous garantissons l'accès à une éducation inclusive et de qualité pour les enfants, en particulier
                    les filles,
                    afin qu'ils puissent construire leur avenir et briser le cycle de la pauvreté.
                </p>
                <div class="grid md:grid-cols-2 gap-6">
                    <img src="../assets/education1.jpg" alt="Éducation" class="rounded-lg shadow-md" data-aos="zoom-in">
                    <div class="text-left flex flex-col justify-center" data-aos="fade-left">
                        <p class="text-gray-700 mb-4">
                            Grâce à nos partenariats avec les écoles locales, nous distribuons du matériel scolaire,
                            finançons les frais
                            de scolarité, et organisons des ateliers éducatifs innovants centrés sur les compétences de
                            vie.
                        </p>
                        <p class="text-gray-700">
                            Notre objectif est de faire de chaque salle de classe un lieu d’éveil, de savoir, mais aussi
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
                    Parce qu’un enfant en bonne santé est un enfant qui peut apprendre, jouer et rêver, notre ONG œuvre
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
                    Nous luttons contre toutes les formes de violence, d'exploitation et de négligence à l’encontre des
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
                <p>Email : <a href="mailto:contact@enfantdebout.org" class="underline">contact@enfantdebout.org</a></p>
                <p>Téléphone : <strong>+243 000 000 000</strong></p>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Enfant Debout. Tous droits réservés.</p>
        </div>
    </footer>

    <!--Carrousel  -->

    <script>
        const slides = [
            {
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
        document.getElementById("menu-button").addEventListener("click", function () {
            const menu = document.getElementById("mobile-menu");
            menu.classList.toggle("hidden");
            menu.classList.toggle("animate-slide-down");
        });

    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,       // Durée plus fluide
            easing: 'ease-in-out',// Animation plus douce
            once: true,           // Ne se rejoue pas au scroll
            offset: 100           // Déclenche plus tôt
        });
    </script>


</body>

</html>