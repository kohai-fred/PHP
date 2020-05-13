<?php
require_once '../inc/init.php';

// 1- Vérifier que le membre est bien administrateur :

if(!estAdmin()){
    header('location:../connexion.php');  // si le membre n'est pas admin, on le redirige sur la page de connexion.
    exit;
}
// 7- Suppression produit :
//debug($_GET);

if(isset($_GET['id_produit'])){  // si existe id_produit dans l'URL c'est qu'on a demandé sa suppression.

    $resultat = executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));

    //debug($resultat->rowCount());  // on obtient 1 lors de la suppression d'un ligne.

    if($resultat->rowCount() == 1){  // si le DELETE retourne une ligne c'est que la requête a bien marché.
        $contenu .= '<div class="alert alert-success">Le produit a bien été supprimé</div>';


    } else{  // sinon le DELETE retourne 0 ligne, c'est que l'id_produit n'est pas en BDD :
        $contenu .= '<div class="alert alert-danger">Le produit n\'a pas pu être supprimé</div>';

    }
}



// 6- Affichage des produits dans le BO (Back Office) :
$resultat = executeRequete("SELECT * FROM produit");  // $resultat est un objet PDOStatement

$contenu .= '<p class="mt-3">Nombre de produits dans la boutique : '. $resultat->rowCount() .' </p>';

$contenu .= '<div class="table-responsive">';
$contenu .= '<table class="table">';

    // Les entêtes du <table> :
    $contenu .= '<tr>';

        $contenu .= '<th>id</th>';
        $contenu .= '<th>référence</th>';
        $contenu .= '<th>catégorie</th>';
        $contenu .= '<th>titre</th>';
        $contenu .= '<th>description</th>';
        $contenu .= '<th>couleur</th>';
        $contenu .= '<th>taille</th>';
        $contenu .= '<th>public</th>';
        $contenu .= '<th>photo</th>';
        $contenu .= '<th>prix</th>';
        $contenu .= '<th>stock</th>';
        $contenu .= '<th>action</th>';

    $contenu .= '</tr>';
    //debug($resultat); // c'est un objet, il faut donc aller chercher le contenu dans le tableau avec :
    while ($produit = $resultat->fetch(PDO::FETCH_ASSOC)){
        //debug($produit);  // $produit est un tableau associatif avec les champs de la requête en indices. Il contient 1 seul produit à chaque tour de boucle.

        $contenu .= '<tr>';

            foreach($produit as $indice => $information){  // cette boucle parcourt 1 prduit pour en récupérer les informations 
                if($indice == 'photo'){  // quand je suis sur l'indice "photo", j'ajoute une balise <img>. 
                    $contenu .= '<td><img src="../' . $information . '" style="width:90px"></td>';  // ce script se trouvant dans le sous dossier admin, il nous faut remonter vers le dossier parent avec le "../" pour ensuite descendre dans le dossier "photos" qui contient nos images.
                } else{  // sinon, je ne suis pas sur l'indice "photo", je ne mets donc pas de balise <img>. 
                    $contenu .= '<td>' . $information  . '</td>';
                }
            } // fin de foreach

            // On ajoute les liens "action" :
            $contenu .= '<td>';

                $contenu .= '<div><a href="formulaire_produit.php?id_produit='. $produit['id_produit'] .'">Modifier</a></div>';
                $contenu .= '<div><a href="?id_produit='. $produit['id_produit'] .' " onclick="return(confirm(\'Etes-vous certain de supprimer ce produit ?\'))" >Supprimer</a></div>';  // confirm() retourne true quand on valide, ou false quand on annule. "return false" bloque le lien et donc ne déclenche pas l'action de suppression. 

            $contenu .= '</td>';


        $contenu .= '</tr>';
    }



$contenu .= '</td>';
$contenu .= '</table>';
$contenu .= '</div>';
require_once '../inc/header.php';
// 2- Onglets de navigation :
?>
<h1 class="mt-4 mb-4">Gestion boutique</h1>

<ul class="nav nav-tabs">

    <li><a href="gestion_boutique.php" class="nav-link active">Affichage des produits</a></li>
    <li><a href="formulaire_produit.php" class="nav-link">Formulaire produit</a></li>

</ul>

<?php
echo $contenu;
require_once '../inc/footer.php';