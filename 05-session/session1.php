<?php
//----------------------------------------------------------
//  La SUPERGLOBALE $_SESSION
//----------------------------------------------------------

/*
    Principe des sessions :
    un fichier temporaire apellé session est créé sur le serveur, avec un identifiant unique. Cette session est lié à un internaute, car dans le même temps un cookie est déposé sur le poste de cet internaute avec l'identifiant dedans (ce cookie s'appelle PHPHSESSID). Ce cookie se détruit quand on quitte le navigateur.

    Tous les sites qui fonctionnent sur le principe de connexion ou ceux qui ont besoin de suivre un internaute de page en page (par exemple avec son panier) utilisent les sessions.

    Le ficjier de session peut contenir toutes sortes d'informations, y compris sensibles, car il n'est pas accessible par l'internaute, donc pas modifiable par celui-ci. On y met par exemple les logins/mdp, les paniers ou les infos de paiement.

    Les données du fichier de session sont accessibles et manipulables à partir de la superglobale $_SESSION.

*/

// Ouverture ou création d'une session :
session_start();  // permet de créer un fichier session OU de l'ouvrir s'il existe déjà. 

// Remplissage de la session :
$_SESSION['pseudo'] = 'goku';
$_SESSION['mdp'] = 'son';  // $_SESSION étant une superglobale, il s'agit d'un array. On accède donc à ses valeurs en passant par les indices écrits entre []. 


echo '1 - La session après remplissage : ';
print_r($_SESSION);  // array

// On peut visualiser le contenu ds fichiers de session dans le dossier /tmp/ de notre serveur local.

// Vider une partie de la session :
unset($_SESSION['mdp']);  // nous pouvons supprimer une partie de la session avec "unset", ici le mot de passe.

echo'<br> 2- La session après suppression du mdp : ';
print_r($_SESSION);

// Supprimer entièrement une session :
// session_destroy();  // supprime le fichier de session : mais il faut savoir que le session_destroy() est d'abord lu puis executé plus tard à la fin du script. 

echo '<br> 3 - La session après suppression totale : ';
print_r($_SESSION);  // on voit encore le contenu de notre session, car le session_destroy() ne s'execute qu'après. 

// Les sessions ont l'avantage d'être disponible partout sur le site  (voir par exemple session2.php).

echo '<p><a href="session2.php">Aller page 2</a></p>';

