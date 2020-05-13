<?php
//--------------------------------------------------------
//                      La superglobale $_GET
//--------------------------------------------------------

/* 
    $_GET représente les informations qui transitent dans l'URL.

    Il s'agit d'une "superglobale", et donc, comme toutes les superglobales, d'un tableau. Superglobals signifie que cette variable est disponible dans tous les contextes du script, y compris dans les espaces locaux des fonction sans avoir besoin de faire "global $_GET".

    Syntax de l'URL : destination.php?indice1=valeur$indiceN=valeurN

    $_GET reçoit les données sous cette forme :

                array(
                    indice1 => valeur1,
                    indiceN => valeurN,
                )
*/

echo '<pre>';
print_r($_GET); // pour vérifier les données reçues.
echo '</pre>';

if(isset($_GET['article']) && isset($_GET['couleur']) && isset($_GET['prix'])){ // on véfifie qu'existent les indices "article", "couleur", et "prix" dans $_get avant de les afficher.

    echo '<h1>' . $_GET['article'] . '</h1>';
    echo '<p>Couleur :' . $_GET['couleur'] . '</p>';
    echo '<p>Prix :' . $_GET['prix'] . ' euros</p>';
} else {    // sinon on ne peut pas afficher le produit
    echo '<p>Aucun produit sélectionné...</p>';
}

// Dans une boutique, nous passons l'identifiant du produit choisi par l'URL. Il permet de sélectionner les informations du produit choisi en BDD et de les afficher.