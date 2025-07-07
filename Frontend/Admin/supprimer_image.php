<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../index.php');
    exit();
}

require_once('../../Backend/request_bdd.php');

$id = $_GET['id'] ?? null;
$activity_id = $_GET['activity_id'] ?? null;

if ($id && $activity_id) {
    try {
        // Récupérer le nom de l'image avant de la supprimer
        $stmt = $bdd->prepare("SELECT image FROM activity_images WHERE id = ? AND activity_id = ?");
        $stmt->execute([$id, $activity_id]);
        $image = $stmt->fetchColumn();
        
        if ($image) {
            // Supprimer le fichier physique
            $imagePath = __DIR__ . '/uploads/' . $image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            // Supprimer l'entrée de la base de données
            $stmt = $bdd->prepare("DELETE FROM activity_images WHERE id = ? AND activity_id = ?");
            $stmt->execute([$id, $activity_id]);
            
            header("Location: modifier.php?id=" . $activity_id . "&success=1");
            exit();
        } else {
            header("Location: modifier.php?id=" . $activity_id . "&error=image_not_found");
            exit();
        }
    } catch (Exception $e) {
        error_log("Erreur lors de la suppression de l'image: " . $e->getMessage());
        header("Location: modifier.php?id=" . $activity_id . "&error=delete_failed");
        exit();
    }
} else {
    header("Location: activites.php");
    exit();
}
?> 