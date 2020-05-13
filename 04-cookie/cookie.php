<?php
//----------------------------------------------------------
//  La SUPERGLOBALE $_COOKIE
//----------------------------------------------------------

/* Un cookie est un petite fichier (4Ko max) déposé par le serveur du site sur le poste de l'internaute, et qui peut contenir des indformations. Les cokkies sont automatiquement renvoyés au serveur web quand l'internaute navigue dans les pages concernées par les cookies. PHP permet de récupérer très facilement les données contenues dans un cookie : ses informations sont stockées dans la superglobale $_COOKIE.

    Précaution à prendre avec les cookies :
    Un cookie étant suavegardé sur le poste de de l'interanute, il peut être volé ou détourné, au encore modifié. On y mettra donc des informations mineurs comme des préférences ou des traces de visite (par exemple les produits visités). En revanche, nous n'y mettons pas d'information sensible comme des mots de passe, des réferences bancaires ou des paniers d'acahts.

*/

// CAS pratique : nous allons stockerla langue sélectionnée par l'internaute dans un cookie, afin de lui afficher le site dans la langue qu'il aura choisie.

// 2 - Déterminer la langue d'affichage du site.
print_r($_GET);

/*  Trois scénarios possibles :
          1° internaute a cliqué sur un langue
          2° interanute n'a pas cliqué mais on a reçu un cookie avec la langue
          3° internaute n'a pas cliqué, on n'a pas reçu de cookie, on lui affiche donc "fr" par défaut.
*/

if(isset($_GET['langue'])){ // si une langue est passée dans l'URL c'est que l'internaute a cliqué sur un lien. On affecte donc son choix à $langue.
    $langue = $_GET['langue'];
} elseif(isset($_COOKIE['langue'])){  // on entre dans le "elseif" si l'internaute n' pas cliqué sur un lien et que l'on a reçu un cookie dant le nom est "langue".
    $langue = $_COOKIE['langue'];  // ici "langue" correspond au nom reçu.
}else{
    $langue = 'fr';  // si les deux scénarios précédents ne se déclenchent pas, on entre dans le "else" qui est le cas par défaut.
}


// 3 - Envoie du cookie :
$un_an = time() + 365*24*60*60;  // timestamp de maintenant (time()) au quel on ajoute 1 an exprimé en secondes (365 jours * 24 h * 60minutes * 60 secondes).

setcookie('langue', $langue, $un_an);  // ce "setcookie" n'est pas dans une condition : on envoies donc ce cookie quelque soit la circonstance. Les paramètres sont : le nom du cookie, sa valeur, sa date d'expiration exprimée en timestamp.


// 4 - Affichage de la langue du site :
echo '<h2> Langue du site : ' . $langue . '</h2>';


// setcookie() permet de créer un cookie, mais il n'y pas de fonction prédéfinie qui permette de le supprimer. Pour invalider un cookie, on le met à jour avce la fonction setcookie() avec une date périmée ( exemple : timme() -3600), ou avec une date à 0, ou sans argument date directement.

// Pour visualiser un cookie dans le navigateur :
// Inspecteur > onglet Stockage (Firefox) ou Application (Chrome) > menu Cookies à gauche > choisir le domaine concerné (localhost pour nous en local).


// 1 - le HTML :
?>

<h1>Votre langue</h1>
<ul>
    <li><a href="?langue=fr">Français</a></li>
    <li><a href="?langue=es">Espagnole</a></li>
    <li><a href="?langue=en">Anglais</a></li>
    <li><a href="?langue=it">Italien</a></li>
</ul>