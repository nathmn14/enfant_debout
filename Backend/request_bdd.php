<?php
// Connexion à la BDD
include('connect_bdd.php');
$bdd = connecterBDD();

if ($bdd) {
    // echo 'Connexion à la BDD réussie';
}

// -------------------------
// 1. Ajouter un événement
// -------------------------
function create($title, $description, $image)
{
    global $bdd;
    try {
        $sql = "INSERT INTO activities (title, description, image) VALUES (?, ?, ?)";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$title, $description, $image]);
        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion : " . $e->getMessage();
        return false;
    }
}



// -------------------------
// 2. Lire tous les événements
// -------------------------
function getAll()
{
    global $bdd;
    try {
        $sql = "SELECT * FROM activities ORDER BY id DESC";
        $stmt = $bdd->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération : " . $e->getMessage();
        return [];
    }
}

// -------------------------
// 3. Modifier un événement
// -------------------------
function update($id, $title, $description, $image)
{
    global $bdd;
    try {
        $sql = "UPDATE activities SET title = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$title, $description, $image, $id]);
        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de la modification : " . $e->getMessage();
        return false;
    }
}

// -------------------------
// 4. Supprimer un événement
// -------------------------
function delete($id)
{
    global $bdd;
    try {
        // Récupérer le nom de l'image
        $stmt = $bdd->prepare("SELECT image FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['image'])) {
            $imagePath = __DIR__ . '/../Frontend/admin/uploads/' . $result['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath); // Supprimer l'image
            }
        }

        // Supprimer l'entrée
        $stmt = $bdd->prepare("DELETE FROM activities WHERE id = ?");
        $stmt->execute([$id]);

        return true;
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
        return false;
    }
}

// -------------------------
// 5. Authentification
// -------------------------
function authentifier($email, $password)
{
    global $bdd;
    try {
        $stmt = $bdd->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Succès
        } else {
            return false; // Échec
        }
    } catch (PDOException $e) {
        echo "Erreur lors de l'authentification : " . $e->getMessage();
        return false;
    }
}

// -------------------------
// 6. Récupérer un événement par ID
// -------------------------
function getEventById($id)
{
    global $bdd;
    try {
        $stmt = $bdd->prepare("SELECT * FROM activities WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération de l'événement : " . $e->getMessage();
        return null;
    }
}

// -------------------------
// 7. Récupérer d'autres événements
// -------------------------
function getOtherEvents($excludeId)
{
    global $bdd;
    try {
        $stmt = $bdd->prepare("SELECT * FROM activities WHERE id != ? ORDER BY date DESC LIMIT 3");
        $stmt->execute([$excludeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des autres événements : " . $e->getMessage();
        return [];
    }
}
?>