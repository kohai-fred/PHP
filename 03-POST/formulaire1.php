<?php
//--------------------------------------------------------
//                      La superglobale $_POST
//--------------------------------------------------------
/* 

$_POST est une "superglobale" qui permet de récupérer les données saisies dans un formulaire.

$_POST étant une superglobale, c'est donc un tableau, et est disponible dans tous les contextes du script, y compris au sein des fonctions sans y faire "global $_POST".

Les données sont reçues dans $_POST de la façon suivante :
            array(
                'name1' => 'valeur input 1',
                'nameN' => 'valeur input N',
            ) où les indices sont constitués des "name" du formulaire, et les valeurs des données saisies par l'internaute.

*/

echo '<pre>';
print_r($_POST);    // pour vérifier que le formulaire envoie bien des données
echo '</pre>';
  
if(!empty($_POST)){ // signifie que $_POST n'est pas vide, donc que le formulaire a été envoyé par l'internaute.

    echo '<p>Prénom : ' . $_POST['prenom'] . '</p>';
    echo '<p>Description : ' . $_POST['description'] . '</p>';
}

// Différence entre "F5" et cliquer dans l'"URL + entrée" :
// "F5" rafraîchit la page en renvoyant les données du formulaire vers le serveur.
// Cliquer dans l'"URL + entrée" permet de demanderau server de renvoyer le script complet et de vider le formulaire comme si nous arrivions pour la première fois (important quand on modifie le code d'un formulaire).    

?>

<h1>Formulaire</h1>

<form method="post" action=""><!-- un formulaire doit toujours être dans des <form> pour fonctionner. L'attribut "methode" définit la façon dont les informations vont circuler entre le client et le serveur : ici en POST. l'attribut "action" définit l'URL de destination des données du formulaire (vide, elles vont vers la même page). -->

    <div>
        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom"><!-- l'attribut "name" est essentiel : il constitue l'indice dans le tableau $_POST qui réceptionne la valeur saisie par l'internaute. -->
    </div>

    <div>
        <label for="description">Description</label>
        <input type="text" name="description" id="description"><!-- l'attribut "for" sur le label, est lié à "l'id" de l'input. De cette manière, quand on clique sur le label, le curseur se place dans l'input correspondant. -->
    </div>

    <div>
        <input type="submit" value="envoyer">
    </div>

</form>