<?php
include('../../Backend/request_bdd.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    if (delete($id)) {
        header("Location: activites.php?success=1");
        exit;
    } else {
        header("Location: activites.php?error=1");
        exit;
    }
} else {
    header("Location: activites.php");
    exit;
}
