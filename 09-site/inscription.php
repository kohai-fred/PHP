<?php

require_once 'inc/init.php';

// Traitement des données du formulaire
//debug($_POST);
//debug($_SESSION);

if(!empty($_POST)){  // si le formulaire a été envoyé

    // validation du formulaire
    if(!isset($_POST['pseudo']) || strlen($_POST['pseudo']) < 4 || strlen($_POST['pseudo']) > 20){  // si le champs n'existe pas ou que sa longueur est trop courte ou trop longue (selon la BDD), on met un message
        $contenu .= '<div class="alert alert-danger">Le pseudo doit contenir entre 4 et 20 caractères.</div>';
    }

    if(!isset($_POST['mdp']) || strlen($_POST['mdp']) < 4 || strlen($_POST['mdp']) > 20) {
        $contenu .= '<div class="alert alert-danger">Le mot de passe doit contenir entre 4 et 20 caractères.</div>';
    }

    if(!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20) {  // si le champs n'existe pas ou que sa longueur est trop courte ou trop longue (selon la BDD), on met un message
        $contenu .= '<div class="alert alert-danger">Le nom doit contenir entre 2 et 20 caractères.</div>';
    }

    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20) {
        $contenu .= '<div class="alert alert-danger">Le prenom doit contenir entre 2 et 20 caractères.</div>';
    }

    if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $contenu .= '<div class="alert alert-danger">L\'email n\'est pas valide</div>';
    }  // filter_var avec le paramètre FILTER_VALIDATE_EMAIL retourne true si $_POST['email] est bien de format email.

    if(!isset($_POST['civilite']) || ($_POST['civilite'] != 'm' && $_POST['civilite'] != 'f')){
        $contenu .= '<div class="alert alert-danger">La civilité n\'est pas valide</div>';
    }

    if(!isset($_POST['ville']) || strlen($_POST['ville']) < 1 || strlen($_POST['ville']) > 20) {
        $contenu .= '<div class="alert alert-danger">La ville doit contenir entre 1 et 20 caractères.</div>';
    }

    if(!isset($_POST['code_postal']) || !preg_match('#^[0-9]{5}$#', $_POST['code_postal'])){
        $contenu .= '<div class="alert alert-danger">Le code postale n\'est pas valide.</div>';
    }  // preg_match() retourne true si le code postale correspond au format 5 chiffres défini par l'expression régulière.

    if(!isset($_POST['adresse']) || strlen($_POST['adresse']) < 4 || strlen($_POST['adresse']) > 50) {
        $contenu .= '<div class="alert alert-danger">L\'adresse doit contenir entre 4 et 50 caractères.</div>';
    }

    //------------------------
    // S'il n'y a pas d'erreur sur le formulaire, on vérifie que le pseudo est disponible, puis on insère le membre en BDD :

    if(empty($contenu)){  // si la variable est vide, c'est qu'il n'y a pas de message d'erreur sue le formulaire

        // On vérifie que le pseudo est disponible en BDD :
        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));

        if($resultat->rowCount() > 0){ // si la requête retourne 1 ou plusieurs lignes c'est que le pseudo est déjà dans la BDD.
            $contenu .= '<div class="alert alert-danger">Le pseudo est indisponible. Veuillez en choir un autre.</div>';
        } else{  // le pseudo est disponible, on insère le membre dans la BDD.

            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);  // si noous "hashons" le mot de passe (ici avec l'algorithme bcrypt par défaut), il faudra sur la page de connexion comparer le hash de la BDD avec celui du mdp fourni par l'internaute lors de la connexion.
            //debug($mdp);

            $succes = executeRequete(
                "INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) 
                VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, 0)",  // 0 pour membre classique
                array(
                    ':pseudo'       => $_POST['pseudo'],
                    ':mdp'          => $mdp,
                    ':nom'          => $_POST['nom'],
                    ':prenom'       => $_POST['prenom'],
                    ':email'        => $_POST['email'],
                    ':civilite'     => $_POST['civilite'],
                    ':ville'        => $_POST['ville'],
                    ':code_postal'  => $_POST['code_postal'],
                    ':adresse'      => $_POST['adresse'],

                )
            );

            if($succes){  //false ou objet PDOStatement
                $contenu .= '<div class="alert alert-success">Vous êtes inscrit. Pour vous connecter <a href="connexion.php">Cliquez ici</a></div>';  // on affiche ce message si on a reçu un objet de la part de la fonction executeRequete().
            } else{
                $contenu .='<div class="alert alert-danger">Une erreur est survenue lors de l\'enregistrement...</div>';
            }
        }

    }  // FIN de if(empty($contenu))



}  // FIN de if(!empty($_POST))

// 8- Modification d'un produit : remplissage du formulaire :
//debug($_GET);
if(isset($_GET['id_membre'])){  // si existe id_produit dans l'URL, c'est qu'on a demandé sa modification. On séléctionne donc ce produit en BDD pour remplir le formulaire de modification.

    $resultat = executeRequete("SELECT * FROM membre WHERE id_membre = :id_membre", array(':id_membre' => $_GET['id_membre']));
    //debug($resultat);  // objet PDOStatement

    $membre_actuel = $resultat->fetch(PDO::FETCH_ASSOC);  // on "fetche" les données du produit en cours de modification sans boucle car il est unique par id_produit
    debug($membre_actuel);
}

require_once 'inc/header.php';

?>

<h1 class="mt-4">Inscription</h1>
<?php echo $contenu; ?>

<form method="post" action="" class="">
    <div>

        <div><label for="pseudo">Pseudo</label></div>
        <div><input type="text" name="pseudo" id="pseudo" value="<?php echo $_POST['pseudo'] ?? '';  ?>"></div>

        <div><label for="mdp">Mot de passe</label></div>
        <div><input type="password" name="mdp" id="mdp" value="<?php echo $_POST['mdp'] ?? '';  ?>"></div>

        <div><label for="nom">Nom</label></div>
        <div><input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? '';  ?>"></div>

        <div><label for="prenom">Prénom</label></div>
        <div><input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? '';  ?>"></div>

        <div><label for="email">Email</label></div>
        <div><input type="text" name="email" id="email" value="<?php echo $_POST['email'] ?? '';  ?>"></div>

        <div>
            <div><label>Civilité</label></div>
            <div><input type="radio" name="civilite" value="m" checked>Homme</div>
            <div><input type="radio" name="civilite" value="f" <?php if(isset($_POST['civilite']) && $_POST['civilite'] == 'f') echo 'checked'; ?>>Femme</div>
        </div>


        <div><label for="ville">Ville</label></div>
        <div><input type="text" name="ville" id="ville" value="<?php echo $_POST['ville'] ?? '';  ?>"></div>

        <div><label for="code_postal">Code postal</label></div>
        <div><input type="text" name="code_postal" id="code_postal" value="<?php echo $_POST['code_postal'] ?? '';  ?>"></div>

        <div><label for="adresse">Adresse</label></div>
        <div><textarea name="adresse" id="adresse" cols="23" rows="2"><?php echo $_POST['adresse'] ?? "";  ?></textarea></div>

        <div>
            <input type="submit" value="S'inscrire" class="btn">
        </div>

    </div>

</form>

<!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit in minus tempore quas perferendis placeat, magnam quaerat, cupiditate maxime ipsam similique. Molestiae beatae rem id odio natus, dolore atque dolorem.</p> -->

<?php
require_once 'inc/footer.php';
