<?php

require_once 'inc/init.php';

//debug($_GET);


if(isset($_GET['id_logement'])){  // si existe l'indice "id_produit" c'est qu l'on a demandé le détail d'un produit.

    // 2- Contrôle de l'existence du produit (un produit en favori a pu être supprimé) :
    $resultat = executeRequete("SELECT * FROM logement WHERE id_logement = :id_logement", array(':id_logement' => $_GET['id_logement']));

    if($resultat->rowCount() == 0){  // si il n'y a pas de produit de cette id en BDD, on oriente le membre vers la boutique
        header('location:index.php');
        exit;
    }

    // 3- Le produit existe, je peux donc l'afficher :
    $bien = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de boucle car il n'y a qu'un seul produit par id_produit
    //debug($produit);
    extract($bien);  // crée des variables nommées comme les indices du tableau et qui prennet la valeur correspondante.



} else {  // si l'indice "id_produit" n'existe pas dans l'URL, on a accédé à cette page sans avoir demandé un produit. On redirige donc le mebre vers la boutique.
    header("location:index.php");
	exit();
}


require_once 'inc/header.php';
?>
    <!-- produit -->
    <div class="row mb-5 align-items-center">
        <div class="col-12">
            <h1 class="text-center my-5"><?php echo ucfirst($titre);?></h1>
        </div>
    
        <div class="col-md-8">
            <img src="<?= $photo; ?>" alt="<?php echo $titre ?>" class="img-fluid">  <!-- on peut remplacer l'ouverture PHP suivi d'un echo par (< ? =)  sans espace -->
        </div> 

        <div class="col-md-4">
            

            <h3>Détails</h3>

                <ul style="list-style-type: none">
                    <li><?php echo $adresse ?></li>
                    <li><?php echo $cp ?></li>
                    <li><?php echo $ville ?></li>
                </ul>

            <div><b>Superficie : </b><?php echo $surface; ?> m²</div>
            <div><b>Prix : </b><?php echo $prix; ?> €</div>
            <p>
                <a href="gestion_bien.php?categorie=<?php echo $categorie ?>">Retour vers la catégorie <?php echo $categorie; ?></a>
            </p>
            

        </div><!-- .col-md-4 -->
        </div><!-- .row -->
        <div>
            <h3>Description</h3>
            <p><?php echo $description; ?></p>
        </div>
    

<?php
require_once 'inc/footer.php';