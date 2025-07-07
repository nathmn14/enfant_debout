<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

require_once('../../Backend/request_bdd.php');

$id = $_GET['id'] ?? null;
$activity = null;
$message = "";

if ($id) {
    $stmt = $bdd->prepare("SELECT * FROM activities WHERE id = ?");
    $stmt->execute([$id]);
    $activity = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$activity) {
        header('Location: activites.php');
        exit();
    }
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $image = "";
    $uploadDir = __DIR__ . '/uploads/';

    // Vérifier et créer le répertoire si nécessaire
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            $message = "Erreur lors de la création du répertoire d'upload.";
        }
    }

    // Vérifier si un nouveau fichier a été uploadé
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
        
        $targetPath = $uploadDir . $imageName;
        
        if (move_uploaded_file($imageTmp, $targetPath)) {
            // Supprimer l'ancienne image si elle existe
            $stmt = $bdd->prepare("SELECT image FROM activities WHERE id = ?");
            $stmt->execute([$id]);
            $oldImage = $stmt->fetchColumn();
            
            if ($oldImage && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }
            
            $image = $imageName;
        } else {
            $message = "Erreur lors du téléversement de la nouvelle image.";
        }
    } else {
        // Garde l'image précédente
        $stmt = $bdd->prepare("SELECT image FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        $image = $stmt->fetchColumn();
    }

    // Traitement des images secondaires
    if (isset($_FILES['secondary_images']) && !empty($_FILES['secondary_images']['name'][0])) {
        foreach ($_FILES['secondary_images']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['secondary_images']['error'][$key] === UPLOAD_ERR_OK && is_uploaded_file($tmp_name)) {
                $file_name = uniqid() . '_' . basename($_FILES['secondary_images']['name'][$key]);
                $secondary_upload_path = $uploadDir . $file_name;
                if (move_uploaded_file($tmp_name, $secondary_upload_path)) {
                    $stmtImg = $bdd->prepare("INSERT INTO activity_images (activity_id, image) VALUES (?, ?)");
                    $stmtImg->execute([$id, $file_name]);
                }
            }
        }
    }

    if (update($id, $title, $description, $image)) {
        $message = "Modification réussie !";
        // Recharge les données
        $stmt = $bdd->prepare("SELECT * FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        $activity = $stmt->fetch(PDO::FETCH_ASSOC);
        header("Location: activites.php");
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
            <h2 class="text-xl font-bold text-gray-800">Modifier un événement</h2>
            <a href="activites.php">
                <button
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl transition duration-200">Retour</button>
            </a>
        </div>
    </div>

    <main class="container mx-auto p-6 max-w-md flex-grow">
        <?php if (!empty($message)): ?>
            <div
                class="mb-6 rounded-xl p-4 text-center font-medium <?= strpos($message, 'réussie') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
            <div class="mb-6 rounded-xl p-4 text-center font-medium bg-green-100 text-green-700">
                Image secondaire supprimée avec succès.
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-6 rounded-xl p-4 text-center font-medium bg-red-100 text-red-700">
                <?php 
                switch($_GET['error']) {
                    case 'image_not_found':
                        echo "Image non trouvée.";
                        break;
                    case 'delete_failed':
                        echo "Erreur lors de la suppression de l'image.";
                        break;
                    default:
                        echo "Une erreur s'est produite.";
                }
                ?>
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
                <label for="secondary_images" class="block text-sm font-medium text-gray-700">Ajouter des images
                    secondaires</label>
                <input type="file" name="secondary_images[]" id="secondary_images" multiple accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-700
                           file:mr-4 file:py-2 file:px-4 file:rounded-full
                           file:border-0 file:text-sm file:font-semibold
                           file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" />
                <p class="mt-2 text-xs text-gray-500">Ajouter plusieurs images si nécessaire.</p>
            </div>

            <!-- Afficher les images secondaires existantes avec option de suppression -->
            <div class="mt-4">
                <h3 class="text-sm font-medium text-gray-700">Images secondaires actuelles</h3>
                <?php
                if ($id) {
                    $images = $bdd->prepare("SELECT * FROM activity_images WHERE activity_id = ?");
                    $images->execute([$id]);
                    $secondaryImages = $images->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (!empty($secondaryImages)) {
                        foreach ($secondaryImages as $img):
                            $imagePath = __DIR__ . "/uploads/" . $img['image'];
                            $imageExists = file_exists($imagePath);
                        ?>
                            <div class="flex items-center justify-between mt-2 p-2 border rounded-lg <?= !$imageExists ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200' ?>">
                                <div class="flex items-center">
                                    <?php if ($imageExists): ?>
                                        <img src="uploads/<?= htmlspecialchars($img['image']) ?>" alt="Image secondaire"
                                            class="h-20 w-20 object-cover rounded-md mr-3" />
                                    <?php else: ?>
                                        <div class="h-20 w-20 bg-red-100 border-2 border-red-300 rounded-md mr-3 flex items-center justify-center">
                                            <span class="text-red-500 text-xs text-center">Image manquante</span>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <span class="text-sm text-gray-800"><?= htmlspecialchars($img['image']) ?></span>
                                        <?php if (!$imageExists): ?>
                                            <br><span class="text-xs text-red-500">Fichier manquant sur le serveur</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <a href="supprimer_image.php?id=<?= $img['id'] ?>&activity_id=<?= $id ?>"
                                    class="text-red-600 hover:text-red-800 text-sm font-semibold ml-4"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?')">
                                    Supprimer
                                </a>
                            </div>
                        <?php endforeach;
                    } else {
                        echo '<p class="text-sm text-gray-500 mt-2">Aucune image secondaire pour le moment.</p>';
                    }
                }
                ?>
            </div>

            <div>
                <button type="submit" name="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-xl w-full transition duration-200">
                    Mettre à jour
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
                        href="mailto:safalaniayaya@gmail.com" class="underline">safalaniayaya@gmail.com</a></span>
            </p>
            <br>
            <p>Téléphone : <strong>+243 820 846 828</strong></p>
            <br>
            <p>Adresse : Province du Nord Kivu, Ville de Goma/ Quartier Katindo/ boulevard SAKE, Commune de Goma
                N°19</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Enfant Debout. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        // Menu mobile toggle
        const menuButton = document.getElementById('menu-button');
        const menu = document.getElementById('menu');
        menuButton.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
        
        // Validation du formulaire
        document.querySelector('form').addEventListener('submit', function(e) {
            const titre = document.getElementById('titre').value.trim();
            const description = document.getElementById('description').value.trim();
            
            if (!titre || !description) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires.');
                return false;
            }
        });
    </script>

</body>

</html>