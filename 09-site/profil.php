<?php

require_once 'inc/init.php';
$commandes = '';
$test = '';

// 1- On redirige le membre NON connecté vers la page de connexion :
if(!estConnecte()){
    header('location:connexion.php');  // le membre non connecté ne doit pas avoir accès à la page profil. Onle redirige donc vers le formulaire de connexion.
    exit;  // et on quitte le script
}
//debug($_SESSION);


// 2- Exercice :
// Affichez le profil du membre connecté avec les informations suivante : email, adresse, code postal et ville.


// Exercice : afficher l'historique des commandes du membre dans une liste de <ul><li> (1 <li> par commande). Vous y mettez l'id_commande, la date de la commande et son état. S'il n'y a pas de commande, on affiche "aucune commande en cours".




$resultat = executeRequete("SELECT id_commande, date_enregistrement, etat FROM commande WHERE id_membre = :id_membre", array(':id_membre'=>$_SESSION['membre']['id_membre']));
//$commande = $resultat->fetch(PDO::FETCH_ASSOC);


if($resultat->rowCount() == 0){

    $commandes .= '<p>Vous n\'avez pas encore effectué de commande.</p>';

}else{

    $commandes .= '<ul>';
        while($maCommande = $resultat->fetch(PDO::FETCH_ASSOC)){
            $date = new DateTime($maCommande['date_enregistrement']);
            $frenchDate = $date->format('d-m-Y');
            //debug($frenchDate);
            //debug($maCommande['date_enregistrement']);


            $commandes .= '<li>N° de commande : '.$maCommande['id_commande'].'<br> effectuée le '.$frenchDate.'<br> état : '.$maCommande['etat'].'.</li><br>';

        }
    $commandes .= '</ul>';

}

//-------------------
// Exercice : Vous complétez le href du lien "supprimer mon compte". Vous devez demandez la confirmation au membre en Javvascript. Puis vous supprimez le compte en BDD, supprimez la session, et redirigez le membre vers la page d'inscription.php. 

//debug($_GET);
//debug($_SESSION);


if(isset($_GET['action']) && $_GET['action'] == 'supprimer_membre'){

    $resultat = executeRequete("DELETE FROM membre WHERE id_membre = :id_membre", array(':id_membre'=> $_SESSION['membre']['id_membre']));
    session_destroy();
    header('location:inscription.php');
    exit;
    /* debug($resultat);
    $test .= 'toto';
 */
}

//-----------------------------

require_once 'inc/header.php';
?>
<h1 class="mt-4 text-center">Profil</h1>

<h2>Bonjour <?php echo $_SESSION['membre']['nom'] . ' ' . $_SESSION['membre']['prenom']; ?></h2>

<!-- s'affiche au besoin -->
<?php if($_SESSION['membre']['statut'] == 1){
    echo '<p>Vous êtes un administrateur</p>';
} ?>
<!--  -->
<hr>

<h3>Vos coordonnées</h3>
<p>Votre email : <?php echo $_SESSION['membre']['email']; ?></p>
<p>Votre adresse : <?php echo $_SESSION['membre']['adresse']; ?></p>
<p>Votre code postal : <?php echo $_SESSION['membre']['code_postal']; ?></p>
<p>votre ville : <?php echo $_SESSION['membre']['ville'];  ?></p>


<hr>
<h3>Historique de vos commandes</h3>

<?php
echo $commandes;
?>

<hr>
<h3>Supprimer mon compte</h3>

<p>
    <a onclick="return confirm('Etes vous sur de vouloir supprimer votre compte définitivement ?')" href="?action=supprimer_membre">   Supprimer mon compte définitivement.</a>
</p>


<?php
require_once 'inc/footer.php';