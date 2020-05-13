<?php
require_once 'inc/init.php';
$affichage_top = '';


// 1- Affichage des catégories
$resultat = executeRequete("SELECT DISTINCT categorie FROM produit");

$contenu_gauche .= '<div class="list-group mb-4">';

    // Lien "tous les produits" :
    $contenu_gauche .= '<a href="?categorie=all" class="list-group-item">Tous les produits</a>';

    //debug($resultat);// objet PDOStatement : il faut donc le "fetcher"

    // les autre catégories provenent de la BDD :
    while ($categorie = $resultat->fetch(PDO::FETCH_ASSOC)){
        //debug($categorie); // il y a un indice ['categorie'] dans le tableau $categorie

        $contenu_gauche .= '<a href="?categorie='. $categorie['categorie'] .'" class="list-group-item"> ' . ucfirst($categorie['categorie']) . ' </a>';  // ucfirst() met la première lettre en majuscule. On passe en GET dans l'URL vers le même script que la "catégorie" choirsie est égale à la valeur du tableau $categorie['categorie'].
    }

$contenu_gauche .= '</div>';

// 2- Affiche des produits de la catégorie choisie :
//debug($_GET);  // on a l'indice "catégorie" dans $_GET

if (isset($_GET['categorie']) && $_GET['categorie'] != 'all'){  // si existe "categorie" dans l'URL et qu'elle est différente de "all", c'est qu'on a cliqué sur une catégorie particulière existant en BDD. On séléctionne donc les produits de cette catégorie.

    $resultat = executeRequete("SELECT id_produit, reference, titre, photo, prix, description FROM produit WHERE categorie = :categorie", array(
        ':categorie' => $_GET['categorie']
    ));

} else{  // si "catégorie" n'est pas dans l'URL c'est que l'on a pas cliqué, ou si elle est égale à "all", on veut tous les produits : onséléctionne donctous les produits de la BDD.
    $resultat = executeRequete("SELECT id_produit, reference, titre, photo, prix, description FROM produit"); // pas de WHERE car on veut tous les produits.

}

while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)){

    //debug($produit);

    $contenu_droite .= '<div class="col-sm-4 mb-4">';
        $contenu_droite .= '<div class="card">';

            // photo cliquable :
            $contenu_droite .= 
            '<a href="fiche_produit.php?id_produit=' . $produit['id_produit'] . '">
                <img src="' . $produit['photo'] . '" class="card-img-top" alt="' . $produit['titre'] . '">
            </a>';

            // infos du produits :
            $contenu_droite .= '<div class="card-body">';
                $contenu_droite .= '<h4 class="text-center">' . $produit['titre'] . '</h4>';
                $contenu_droite .= '<h5>' . number_format($produit['prix'], 2, ',', '') . '€</h5>';  // number_format() reformate un nombre avec ici 2 décimales, une virgule comme séparateur des décimales, et un vide comme séparateur des milliers.
                $contenu_droite .= '<p>' . $produit['description'] . '</p>';

            $contenu_droite .= '</div>';  // .card-body

        $contenu_droite .= '</div>';  // .card
    $contenu_droite .= '</div>';  // .col-sm4 mb-4

}


//---------------------
// Exercice : afficher sous la boutique le top 3 des ventes en quantités (photo, titre, prix), avec un lien sur la photo ainsi qu'un lien "voir le produit" qui mènent à la fiche détaillé du produit. Note il faut faire une requête sur les tables produit et details_commande. 


$resultat = executeRequete("SELECT SUM(d.quantite), p.photo, p.titre, p.prix, p.id_produit FROM produit p INNER JOIN details_commande d ON p.id_produit = d.id_produit GROUP BY d.id_produit ORDER BY SUM(d.quantite) DESC limit 3");
//debug($resultat);

//$topProduit = $resultat->fetch(PDO::FETCH_ASSOC);
//debug($topProduit);
//debug($_SESSION);


while($topProduit = $resultat->fetch(PDO::FETCH_ASSOC)){

    //debug($topProduit);
    //$affichage_top .= '<div>'.$topProduit['titre'].$topProduit['photo'].$topProduit['prix'].'€</div>';
    $affichage_top .= '<div class="col-sm-3 mb-4">';
        $affichage_top .= '<div class="card">';
            $affichage_top .= '<a href="fiche_produit.php?id_produit=' . $topProduit['id_produit'] . '">
            <img src="' . $topProduit['photo'] . '" class="img-fluid" alt="' . $topProduit['titre'] . '">
            </a>';

                $affichage_top .= '<div class="card-body">';
                    $affichage_top .= '<h4 >' . $topProduit['titre'] . '</h4>';
                    $affichage_top .= '<h5>' . number_format($topProduit['prix'], 2, ',', '') . '€</h5>';
                    $affichage_top .= '<a href="fiche_produit.php?id_produit=' . $topProduit['id_produit'] . '">Voir le produit</a>';
                $affichage_top .= '</div>';

        $affichage_top .= '</div>';
    $affichage_top .= '</div>';

}




//-----------------------
require_once 'inc/header.php';
?>
<h1 class="mt-4 mb-4">Boutique</h1>

<div class="row">

    <div class="col-md-3">
        <?php echo $contenu_gauche;  // pour afficher les catégories de produits ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php echo $contenu_droite;  // pour afficher les produits  ?>    
        </div>
    </div>

</div><!-- .row -->

<hr>

<div class="row">
    <h4 class="col-12">Le TOP des ventes</h4>
    <?php echo $affichage_top; ?>

</div>



<?php
require_once 'inc/footer.php';