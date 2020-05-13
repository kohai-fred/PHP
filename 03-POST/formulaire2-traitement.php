<?php

echo '<pre>';
print_r($_POST);
echo '</pre>';
  
if(!empty($_POST)){ 

    echo '<p>Adresse : ' . $_POST['adresse'] . '</p>';
    echo '<p>Code postale : ' . $_POST['codePostale'] . '</p>';
    echo '<p>Ville : ' . $_POST['ville'] . '</p>';

    //---------------------------------------------
    // Ecrire dans un fichier TXT dynamiquement :
    //---------------------------------------------

    $file = fopen('adresse.txt', 'a');  // fopen() en mode "a" crée le fichier "adresse.txt" s'il n'existe pas, ou l'ouvre s'il existe.

    $adresse = $_POST['adresse'] . ' - ' . $_POST['codePostale'] . ' - ' . $_POST['ville'] . "\n";  // contenu à écrire dans notre fichhier. "\n" permet de faire un saut de ligne dans le fichier txt.

    fwrite($file, $adresse);    // écrit le contenu de $adresse dans le fichier représenté par $file.

    fclose($file);  // ferme le fichier pour libérer de la ressource serveur.


}

