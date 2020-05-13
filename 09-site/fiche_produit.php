<?php
require_once 'inc/init.php';

// variable d'affichage :
$panier = '';  // pour le panier
$suggestion = '';  // pour la suggestion de produits
$modale = '';  // la modale de confirmation d'ajout au panier



// 1- Si on a demandé un produit :
//debug($_GET);  // il y a un indice "id_produit"

if(isset($_GET['id_produit'])){  // si existe l'indice "id_produit" c'est qu l'on a demandé le détail d'un produit.

    // 2- Contrôle de l'existence du produit (un produit en favori a pu être supprimé) :
    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

    if($resultat->rowCount() == 0){  // si il n'y a pas de produit de cette id en BDD, on oriente le membre vers la boutique
        header('location:index.php');
        exit;
    }

    // 3- Le produit existe, je peux donc l'afficher :
    $produit = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de boucle car il n'y a qu'un seul produit par id_produit
    //debug($produit);
    extract($produit);  // crée des variables nommées comme les indices du tableau et qui prennet la valeur correspondante.


    // 4- Bouton d'ajout au panier
    if($stock > 0){  // si le stock est disponible, on met le bouton.

        // Pour le script panier.php, il nous faut 2 infos : l'id du produit a jouté et la quantité ajoutée au panier.
        $panier .= '<form method="post" action="panier.php" class="my-4">';

            // id_produit :
            $panier .= '<input type="hidden" name="id_produit" value="' . $id_produit . '">';  // on envoie l'id du produit dans $_POST. Champ de type caché pour ne pas pouvoir le modifier.

            // Sélecteur de quantité de  produit.
            $panier .= '<select name="quantite" class="custom-select col-3" >';

                for($i = 1; $i<=$stock && $i<=5; $i++){  // on fait 5 tours de boucle maximum à concurrence du stock disponible (si le stock est inférieur à 5, on s'arrête à la quantité en stock)
                    $panier .= "<option>$i</option>";
                }
            $panier .= '</select>';

            // Bouton submit
            $panier .= '<input type="submit" name="ajout_panier" value="ajouter au panier" class="btn btn-info col-8 offset-1">';

        $panier .= '</form>';

    } else{  // sinon on affiche "rupture de stock
        $panier .= '<p>Produit en rupture de stock.</p>';
    }


} else {  // si l'indice "id_produit" n'existe pas dans l'URL, on a accédé à cette page sans avoir demandé un produit. On redirige donc le mebre vers la boutique.
    header("location:index.php");
	exit();
}

// 4- Affichage de la modale de confirmation d'ajout au panier :

//debug($_GET);

if(isset($_GET['statut_produit']) && $_GET['statut_produit'] == 'ajoute'){

    $modale =
    '<div class="modal fade" id="modal-panier" role="dialog"> 
        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"> Produit ajouté au panier !</h4>
                </div><!-- .modal-header -->

                <div class="modal-body">
                    <p><a href="panier.php">Voir le panier</a></p>
                    <p><a href="index.php">Continuer mes achats</a></p>
                </div><!-- .modal-body -->

            </div><!-- .modal-content -->

        </div><!-- .modal-dialog -->
    </div><!-- .modal -->';
}

//-------------------------------------------
// Exercice :
// Créer une suggestion de produits:
// - Afficher 2 produits (photo et titre) aléatoirement appartenant à la catégorie du produit actuellement affiché dans la fiche produit. Ces produits doivent être différents du produit affiché dans la fiche. La photo est cliquable et amène au détail du produit. Vous utilisez la variable $suggestion pour afficher le contenu.

// trouver le code afficher en SQL random
//........


$meme_categorie = executeRequete("SELECT id_produit, categorie, titre, photo FROM produit WHERE categorie = :categorie AND id_produit <> $id_produit ORDER BY RAND() LIMIT 2", array(':categorie' => $categorie));  // id_produit <> $id_produit est la même chose que id_produit != $id_produit


while ($produit = $meme_categorie->fetch(PDO::FETCH_ASSOC)){

    //debug($produit);
    //if($_GET['categorie']){

        $suggestion .= '<div class="col-sm-4 mb-4">';
            $suggestion .= '<div class="card">';
    
                // photo cliquable :
                $suggestion .= 
                '<a href="fiche_produit.php?id_produit=' . $produit['id_produit'] . '">
                    <img src="' . $produit['photo'] . '" class="card-img-top" alt="' . $produit['titre'] . '">
                </a>';
    
                // infos du produits :
                $suggestion .= '<div class="card-body">';
                    $suggestion .= '<h4 class="text-center">' . ucfirst($produit['titre']) . '</h4>';
    
                $suggestion .= '</div>';  // .card-body
    
            $suggestion .= '</div>';  // .card
        $suggestion .= '</div>';  // .col-sm4 mb-4
    //}

}



require_once 'inc/header.php';
echo $modale;
?>
    <!-- produit -->
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mt-4 mb-4"><?php echo ucfirst($titre);?></h1>
        </div>
    
        <div class="col-md-8">
            <img src="<?= $photo; ?>" alt="<?php echo $titre ?>" class="img-fluid">  <!-- on peut remplacer l'ouverture PHP suivi d'un echo par (< ? =)  sans espace -->
        </div> 

        <div class="col-md-4">
            <h3>Description</h3>
            <p><?php echo $description; ?></p>

            <h3>Détails</h3>
            <ul>
                <li>Catégorie : <?php echo $categorie; ?></li>
                <li>Couleur : <?php echo $couleur; ?></li>
                <li>Taille : <?php echo $taille; ?></li>
            </ul>

            <h4>Prix : <?php echo number_format($prix, 2, ',', ''); ?>€</h4>
            <?php echo $panier; ?>

            <p>
                <a href="index.php?categorie=<?php echo $categorie ?>">Retour vers la catégorie <?php echo $categorie; ?></a>
            </p>
            

        </div><!-- .col-md-4 -->
    
    
    </div><!-- .row -->

    <!-- Exercice suggestion de produits -->
    <hr>
    <div class="row">
        <div class="col-12">
            <h3>Suggestion de produits</h3>
        </div>
    
        <?php echo $suggestion; ?>
    
    </div>


    <script>
        // Script d'affichage de la modale d'ajout au panier
        $(function(){
            $('#modal-panier').modal('show');  // pour déclencher son affichage


        });
        


    </script>
<?php
require_once 'inc/footer.php';