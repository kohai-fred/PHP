<?php

// debug :
function debug($variable){
    echo '<pre>';
        print_r($variable);
    echo '</pre>';
}

// Fonction qui indique si le membre est connecté :
function estConnecte(){

    if(isset($_SESSION['membre'])){  // si existe l'indice "membre" dans la session, c'est que l'internaute est passé par la pge de connexion avec les bons identifiants.
        return true;  // il est connecté. 
    } else{
        return false;  // il n'est pas connecté. 
    }
}


// Fonction qui indique si le membre est admin connecté :
function estAdmin(){

    if(estConnecte() && $_SESSION['membre']['statut'] == 1){  // si le membre est conncté, alors on regarde si son statut dans la $_SESSION['membre'] a la valeur 1, auquel cas il est admin et connecté.
        return true;
    } else{
        return false;  // il n'est pas connecté ou pas admin.
    }
}


// Fonction qui réalise des requêtes préparées pour nous :
function executeRequete($requete, $param = array()){  // le paramètre $requete attend de recevoir une requête SQL sous forme de string, et $param attend un array avec les marqueurs associés à leur valeur. Ce paramètre est optionnel, car on lui a affecté un array() vide par défaut.

    // Echapper les donnés de $param car elles proviennent de l'internaute :
    foreach($param as $indice => $valeur){
        $param[$indice] = htmlspecialchars($valeur, ENT_QUOTES);  // évite les injections XSS ET CSS.
    }  // à chaque tour de boucle, on prend la valeur du tableau $param que l'on échappe et que l'on réaffecte à son emplacement d'origine.


    // requête préparée :
    global $pdo;  // on accède à la variable globale définie à l'extérieur de cette fonction dans le fichier init.php. 
    $resultat = $pdo->prepare($requete);  // on prépare la requête envoyée à notre fonction

    $succes = $resultat->execute($param);  // puis on exécute la requête en lui passant le tableau qui associe les marqueurs et leur valeur. "execute()"  retourne toujours un booléen (true en cas de succès, false en cas d'échec).

    if($succes){
        return $resultat;  // on retourne l'objet PDOStatement en cas de succès, car nous en avons besoin quand on fait des requêtes de sélection.
    } else{
        return false;  // on retourne false en cas d'erreur sur la requête.
    }

}

// fonction qui crée le panier :
function creationPanier(){

    if(!isset($_SESSION['panier'])){  // si le panier n'existe pas, on le crée (vide)

        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['reference'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}



// Fonction aui ajoute un produit au panier :

function ajoutProduit($id_produit, $titre, $reference, $quantite, $prix){  // réception des valeurs lors de l'appel de la fonction dans panier.php

    creationPanier();  // crée le panier s'il n'existe pas.

    // Nous devons savoir si l'id_produit que l'on souhaite ajouter est déjà présent dans le panier pour ne pas ajouter une nouvelle fois ce produit, mais lui ajouter la nouvelle quantité :
    $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);  // cette fonction retourne l'indice de l'élément recherché. Ici on obtient la position du produit "id_produit dans le tableau $_SESSION['panier']['id_produit']. Si le produit n'y est pas, array_search retourne "false". 

    if($position_produit === false){  // si le produit n'est pas encore dans le panier, on l'y ajoute :

        $_SESSION['panier']['id_produit'][] = $id_produit;  // les [] vides permettent d'ajouter l'élément à la fin du tableau
        $_SESSION['panier']['titre'][] = $titre;
        $_SESSION['panier']['reference'][] = $reference;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;

    } else{  // sinon on ajoute la nouvelle quantité à la quantité du produit déjà présent dans le panier :

        if($_SESSION['panier']['quantite'][$position_produit] + $quantite <= 5){  // si on ne dépase 5 exemplaires au total

            $_SESSION['panier']['quantite'][$position_produit] += $quantite; // nous alons précisément à l'indice du produit déjà présent et lui ajoutons la nouvelle quantité. 
        } else{  // sinon on limite à 5
            $_SESSION['panier']['quantite'][$position_produit] = 5;
        }

    }
}


// Fonction qui calcul le total du panier :
function montantTotal(){

    $total = 0;

    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++){  // tant que $i est inférieur au nombre de produit dans le panier, on additione le prix du produit multiplié par sa quantité

        $total += $_SESSION['panier']['quantite'][$i] * $_SESSION['panier']['prix'][$i];  // on ajoute dans la variable $total avec l'opérateur += le résultat de la quantité par le prix de chaque produit.

    }
    
    return $total;  // on retourne le résultat du calcul à l'ndroit où la fonction est appelée
}


// Fonction pour retirer un produit du panier :
function retirerProduit($id_produit){
    
    // On détermine la position (=indice) du produit dans le panier :
    $position_produit = array_search($id_produit, $_SESSION['panier']['id_produit']);  // retourne l'indice du produit dans le panier ou "false" s'il n'y est pas.

    if($position_produit !== false){  // si le produit est dans le panier, on peut le couper.

        array_splice($_SESSION['panier']['id_produit'], $position_produit, 1);  // on coupe et remplace la portion du tableau qui débute à l'indice $position_produitet sur 1 élément (= 1 seul produit).
        array_splice($_SESSION['panier']['titre'], $position_produit, 1);
        array_splice($_SESSION['panier']['reference'], $position_produit, 1);
        array_splice($_SESSION['panier']['quantite'], $position_produit, 1);
        array_splice($_SESSION['panier']['prix'], $position_produit, 1);
    }
}


//----------------------------
// Exercice : créer une fonction qui retourne le nombre de produits DIFERENTS (nombre de lignes dans le panier). Puis afficher le résultat à côté du lien "panier" dans le menu de navigation. Exemple : panier(2). En l'absence de produit, on affiche panier(0).

//debug($_SESSION['panier']['id_produit']);


function numeroPanier(){
    //$resultat = count($_SESSION['panier']['id_produit']);


    if(isset($_SESSION['panier'])){
        $resultat = count($_SESSION['panier']['id_produit']);
        return $resultat;

    }else{
        return 0;
    }

    
    //debug($resultat);
}

// Si on avait voulu compter la totalité des produits:
/* function totalQuantite(){
    
    if(isset($_SESSION['panier'])){
        $resultat = array_sum($_SESSION['panier']['quantite']);
        return $resultat;

    }else{
        return 0;
    }
} */
