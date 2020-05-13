<?php

// debug :
function debug($variable){
    echo '<pre>';
        print_r($variable);
    echo '</pre>';
}



function executeRequete($requete, $param = array()){ 
    foreach($param as $indice => $valeur){
        $param[$indice] = htmlspecialchars($valeur, ENT_QUOTES); 
    } 


    global $pdo;
    $resultat = $pdo->prepare($requete); 

    $succes = $resultat->execute($param);
    if($succes){
        return $resultat;
    } else{
        return false;
    }

}


function reduireChaineMot($chaine, $nb_mots, $delim='...') {
    {
        $stringTab=explode(" ", $chaine) ;
        for($i=0;$i<$nb_mots;$i++){
        $txt.=" ".$stringTab[$i] ;
        }
        if (count($stringTab) > $nb_mots) $txt.= $delim ;
        return $txt ;
    }
}

function couperMots($texte, $nb)     {
    if (strlen($texte) >= $nb) {
        $texte  = trim(substr($texte, 0, $nb));
        $texte .= '...';
    }
    return $texte;
}