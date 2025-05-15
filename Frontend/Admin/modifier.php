<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

include('../../Backend/request_bdd.php');

$id = $_GET['id'] ?? null;
$activity = null;
$message = "";

if ($id) {
    $stmt = $bdd->prepare("SELECT * FROM activities WHERE id = ?");
    $stmt->execute([$id]);
    $activity = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $image = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = __DIR__ . '/uploads/' . $imageName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image = $imageName;
        }
    } else {
        // Garde l'image précédente
        $stmt = $bdd->prepare("SELECT image FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetchColumn();
    }

    if (update($id, $title, $description, $image)) {
        $message = "Modification réussie !";
        // Recharge les données
        $stmt = $bdd->prepare("SELECT * FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        $activity = $stmt->fetch(PDO::FETCH_ASSOC);
        header("Location:activites.php");
        exit();
    } else {
        $message = "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modifier un événement - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar identique -->
    <header class="bg-blue-800 text-white w-full">
        <div class="container mx-auto flex items-center justify-between px-4 py-4">
            <div class="flex items-center space-x-4">
                <img src="../assets/logo.png" alt="Logo Enfant Debout" class="h-12 w-auto" />
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
            <button class="md:hidden" id="menu-button" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div id="menu" class="md:hidden hidden px-4 pb-4">
            <a href="#a-propos" class="block py-2 hover:text-blue-200">À propos</a>
            <a href="#evenements" class="block py-2 hover:text-blue-200">Événements</a>
            <a href="#education" class="block py-2 hover:text-blue-200">Éducation</a>
            <a href="#sante" class="block py-2 hover:text-blue-200">Santé</a>
            <a href="#protection" class="block py-2 hover:text-blue-200">Protection</a>
            <a href="#contact" class="block py-2 hover:text-blue-200">Contact</a>
        </div>
    </header>

    <!-- Barre supérieure admin -->
    <div class="bg-white shadow">
        <div class="container mx-auto p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h2 class="text-xl font-bold text-gray-800">Modifier un événement</h2>
            <a href="activites.php">
                <button
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl transition duration-200">Retour</button>
            </a>
        </div>
    </div>

    <main class="container mx-auto p-6 max-w-md flex-grow">
        <?php if ($message): ?>
            <div
                class="mb-6 rounded-xl p-4 text-center font-medium <?= strpos($message, 'réussie') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl shadow-md space-y-5">
            <input type="hidden" name="id" value="<?= htmlspecialchars($activity['id'] ?? '') ?>" />

            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($activity['title'] ?? '') ?>"
                    required
                    class="mt-1 block w-full rounded-xl border border-gray-300 p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" required
                    class="mt-1 block w-full rounded-xl border border-gray-300 p-3 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($activity['description'] ?? '') ?></textarea>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Changer l'image</label>
                <input type="file" id="image" name="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-700
                           file:mr-4 file:py-2 file:px-4 file:rounded-full
                           file:border-0 file:text-sm file:font-semibold
                           file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" />
                <p class="mt-2 text-xs text-gray-500">Laisser vide si vous ne souhaitez pas changer l'image.</p>

                <?php if (!empty($activity['image'])): ?>
                    <div class="mt-3">
                        <img src="uploads/<?= htmlspecialchars($activity['image']) ?>" alt="Image actuelle"
                            class="max-h-40 mx-auto rounded-lg shadow" />
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <button type="submit" name="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-xl w-full transition duration-200">
                    Mettre à jour
                </button>
            </div>
        </form>
    </main>

    <script>
        // Menu mobile toggle
        const menuButton = document.getElementById('menu-button');
        const menu = document.getElementById('menu');
        menuButton.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>

</html>