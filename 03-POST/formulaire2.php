<?php
//Exercice
/* 
- Créer un formulaire avec les champs ville, code postal et une zonde texte adresse.
- Afficher les valeurs saisies par l'internaute dans la page formulaire2-traitement.php.
*/

?>

<h1>Formulaire</h1>

<form method="post" action="formulaire2-traitement.php"><!-- un formulaire doit toujours être dans des <form> pour fonctionner. L'attribut "methode" définit la façon dont les informations vont circuler entre le client et le serveur : ici en POST. l'attribut "action" définit l'URL de destination des données du formulaire (vide, elles vont vers la même page). -->

    <div>
        <label for="ville">Ville</label>
        <input type="text" name="ville" id="ville"><!-- l'attribut "name" est essentiel : il constitue l'indice dans le tableau $_POST qui réceptionne la valeur saisie par l'internaute. -->
    </div>

    <div>
        <label for="codePostale">Code postal</label>
        <input type="text" name="codePostale" id="codePostale"><!-- l'attribut "for" sur le label, est lié à "l'id" de l'input. De cette manière, quand on clique sur le label, le curseur se place dans l'input correspondant. -->
    </div>
    <div>
        <label for="adresse">Adresse</label>
        <textarea name="adresse" id="adresse" cols="30" rows="1"></textarea>
    </div>

    <div>
        <input type="submit" value="envoyer">
    </div>

</form>