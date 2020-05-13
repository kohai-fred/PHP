<?php


function debug($variable){
    echo '<pre>';
        print_r($variable);
    echo '</pre>';
}

function estConnecte(){

    if(isset($_SESSION['membre'])){  // si existe l'indice "membre" dans la session, c'est que l'internaute est passé par la pge de connexion avec les bons identifiants.
        return true;  // il est connecté. 
    } else{
        return false;  // il n'est pas connecté. 
    }
}

function estAdmin(){

    if(estConnecte() && $_SESSION['membre']['statut'] == 1){  // si le membre est conncté, alors on regarde si son statut dans la $_SESSION['membre'] a la valeur 1, auquel cas il est admin et connecté.
        return true;
    } else{
        return false;  // il n'est pas connecté ou pas admin.
    }
}