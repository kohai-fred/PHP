<?php

// Ouverture de la session :
session_start();  // quand on effectue un session_start(), et que l'on reçoit un cookie avec un identifiant, la session n'est pas recréée (elle a été créée dans la page session1.php). On y accède seulement.

echo 'La session est accessible dans tous les scripts du site, comme ici : ';
print_r($_SESSION);

echo '<p><a href="session1.php">Aller à la page 1</a></p>';

// Ce fichier "session2.php" n'a rien avoir avec le fichier "session1.php". Il n'y a pas d'inclusion, il pourrait être dans n'importe quel dossier, les informations contenues dans la session restent accessibles.