<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

include('../../Backend/request_bdd.php');

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
        $uploadDir = __DIR__ . "/uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($imageTmp, $imagePath)) {
            if (create($titre, $description, $imageName)) {
                $message = "Événement ajouté avec succès.";
            } else {
                $message = "Erreur lors de l'ajout de l'événement.";
                // Supprimer l'image uploadée si insertion en BDD échoue
                unlink($imagePath);
            }
            header("Location:activites.php");
            exit();
        } else {
            $message = "Erreur lors du téléversement de l'image.";
        }
    } else {
        $message = "Veuillez sélectionner une image valide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ajouter un événement - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <a href="../../index.php" class="hover:text-blue-200">Retourner à la page d'Accueil</a>
            </nav>
            <button class="md:hidden" id="menu-button">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <!-- Mobile menu -->
        <div id="menu" class="md:hidden hidden px-4 pb-4">
            <a href="../../index.php" class="hover:text-blue-200">Retourner à la page d'Accueil</a>
        </div>
    </header>


    <!-- Barre supérieure admin -->
    <div class="bg-white shadow">
        <div class="container mx-auto p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-800">Ajouter un événement</h2>
            <a href="activites.php">
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl transition">Retour</button>
            </a>
        </div>
    </div>

    <main class="container mx-auto p-6 max-w-md flex-grow">
        <?php if ($message): ?>
            <div
                class="mb-6 rounded-xl p-4 text-center font-medium <?= str_contains($message, 'succès') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded-2xl shadow-md space-y-5">
            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" id="titre" name="titre" placeholder="Entrez un titre" required
                    class="mt-1 block w-full rounded-xl border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Entrez une description" required
                    class="mt-1 block w-full rounded-xl border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" id="image" name="image" accept="image/*" required class="mt-1 block w-full text-sm text-gray-700
                    file:mr-4 file:py-2 file:px-4 file:rounded-full
                    file:border-0 file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-xl w-full transition duration-200">
                    Soumettre
                </button>
            </div>
        </form>
    </main>

    <!-- Contact -->
    <section id="contact" class="py-16 bg-blue-800 text-white text-center">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold mb-4">Contactez-Nous</h2>
            <p class="text-lg mb-4">Ensemble, redonnons espoir aux enfants et aux femmes.</p>
            <p>Email : <span><a href="mailto:edenfantdebout@gmail.com"
                        class="underline">edenfantdebout@gmail.com</a></span> / <span><a
                        href="mailto:safalaniayaya@gmail.com" class="underline">safalaniayaya@gmail.com</a></span></p>
            <p>Téléphone : <strong>+243 820 846 828</strong></p>
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
        const menuButton = document.getElementById('menu-button');
        const menu = document.getElementById('menu');

        menuButton.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>