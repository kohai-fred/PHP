<?php

// Exercice : 
// Vous affichez trois liens : bananes, kiwis et cerises.
// Quand on clique sur un fruit, vous passez dans l'URL le nom du fruit uniquement vers la page exercice1.php.
// Quand un fruit est demandé, vous affichez son prix selon l'exemple suivant : "Le prix des ... est de ... euros." dans cette même page.



echo '<h1>Nos fruits</h1>
<div>
    <a href="exercice1.php?article=bananes">Bananes</a>
</div>
<div>
    <a href="exercice1.php?article=kiwis">Kiwis</a>
</div>
<div>
    <a href="?article=cerises">Cerises</a>
</div>';

$fruits = [
    
    'bananes' => 1,
    'kiwis' => 2,
    'cerises' => 5,
];



if(isset($_GET['article']) && (isset($fruits[$_GET['article']]))){

    echo '<p>Le prix des '. $_GET['article'] . ' est de : ' . $fruits[$_GET['article']] . ' euros</p>';
} else { 
    echo '<p>Aucun produit sélectionné...</p>';
}


// Version Longue :

/*
    if (isset($_GET['article']) && $_GET['article'] == 'bananes'){
        echo "Le prix des $_GET[article] est de 1.5 euros.";
    } elseif (isset($_GET['article']) && $_GET['article'] == 'kiwis'){
        echo "Le prix des $_GET[article] est de 2.5 euros.";
    } elseif (isset($_GET['article']) && $_GET['article'] == 'cerises'){
        echo "Le prix des $_GET[article] est de 3.5 euros.";
    } else{
        echo "Ce produit n'est pas disponible.";
    } 
*/



