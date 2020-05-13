<?php

require_once 'inc/init.php';
$message = '';  // pour afficher le message de déconnexion

// 2- Deconnexion du membre
//debug($_GET);  // on a mis dans le header.php un lien en GET "connexion.php?action=deconnexion"

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion'){  // si on a reçu une demande de déconnexion du membre
    unset($_SESSION['membre']);  // on vide la session de sa partie membre tout en conservant l'éventuel panier.
    $message = '<div class="alert alert-info">Vous êtes déconnecté.</div>';
}

// 3- On vérifie que le membre n'est pas connecté. S'il l'est on le redirige vers son profil :
if(estConnecte()){
    header('location:profil.php');  // on autorise pas le membre à accéder au formulaire de connexion quand il est déjà connecté. 
    exit;
}



// 1- Traitement du formulaire de connexion
//debug($_POST);

if(!empty($_POST)){  // si le formulaire a été envoyé

    // Contrôle du formulaire :
    if(empty($_POST['pseudo']) || empty($_POST['mdp'])){  // si le pseudo ou le mdp est vide
        $contenu .= '<div class="alert alert-danger">Les identifiants sont obligatoires.</div>';
    }

    // Si les champs sont bien remplis, on vérifie le pseudo et le mdp en BDD :
    if (empty($contenu)){  // si la variable est vide, c'est qu'il n'y a pas d'erreur

        $resultat = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo", array(':pseudo' => $_POST['pseudo']));

        if($resultat->rowCount() == 1){  // si il y a 1 ligne de résultat, c'est que le pseudo est bien dans la BDD : on peut alors vérifier le mdp

            $membre = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de boucle car il n'y a qu'un seul pseudo dans la BDD.
            // debug($membre);  // tableau associatif
            if(password_verify($_POST['mdp'], $membre['mdp'])){  // vérifie si le hash de la BDD correspond au mdp du formulaire, password_verify retourne true

                // Connection de l'internaute :
                $_SESSION['membre'] = $membre;  // on créé une $_SESSION[membre] avec les infos $membre provenant de la BDD.

                header('location:profil.php');  // les identifiants étant corrects, on redirige l'internaute vers la page profil.php.
                exit;  // on quite ce script

            } else{  // sinon les mdp ne correspondent pas.
                $contenu .= '<div class="alert alert-danger">Erreur sur les identifiants.</div>';
            }

        } else{  // si il y a 0 ligne, le pseudo n'est pas dans la BDD.
            $contenu .= '<div class="alert alert-danger">Erreur sur les identifiants.</div>';
        }
    }

}  // FIN du if(!empty($_POST))





require_once 'inc/header.php';
?>
<h1 class="mt-4">Connexion</h1>

<?php
    echo $message;  // pour le message de déconnexion. 
    echo $contenu;  // pour les autres messages.
?>
<form method="POST" action="">

    <div>
        <div><label for="pseudo">Pseudo</label></div>
        <div><input type="text" name="pseudo" id="pseudo"></div>
    </div>

    <div>
        <div><label for="mdp">Mot de passe</label></div>
        <div><input type="password" name="mdp" id="mdp"></div>
    </div>

    <div>
        <input type="submit" value="Se connecter" class="btn">
    </div>

</form>
<?php
require_once 'inc/footer.php';