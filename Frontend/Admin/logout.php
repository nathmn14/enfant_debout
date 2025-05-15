<?php
session_start();
session_unset();     // Supprime les variables de session
session_destroy();   // Détruit la session

header('Location: ../../index.php');
exit();
