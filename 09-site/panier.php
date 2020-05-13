<?php
require_once 'inc/init.php';

//debug($_POST);

// 1- Ajout d'un produit au panier :
if(isset($_POST['ajout_panier'])){  // si existe l'indice "ajout_panier" dans $_POST, c'est qu'on a cliqué sur le bouton d'ajout au panier (et pas sur le bouton de validation du panier)

    // on fait une requête en BDD pour sélectionner le titre et le prix du produit. En effet, on ne met pas le prix dans les formulaires d'ajout au panier car ils seraiant côté client et peuvent être modifiés par l'internaute.
    $resultat = executeRequete("SELECT id_produit, reference, titre, prix FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_POST['id_produit']));

    $produit = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de boucle while, car il y a qu'un seul produit par ID dans notre requête.
    debug($produit);

    ajoutProduit($produit['id_produit'], $produit['titre'], $produit['reference'], $_POST['quantite'], $produit['prix']);  // on appel notre fonction aujoutProduit() pour ajouter un produit dans la session donc dans le panier.

    // 6- Modale de confirmation d'ajout au panier
    header('location:fiche_produit.php?statut_produit=ajoute&id_produit='. $_POST['id_produit']);  // on redirige du panier vers le détails du produit qu l'internaute vient d'ajoute au panier.
    exit;
}


// 3- Vider le panier :
//debug($_GET);

if(isset($_GET['action']) && $_GET['action'] == 'vider'){  // si "action" existe dans l'URL et que sa valuer est "vider", c'est qu'on a cliqué sur "vider le panier". 

    unset($_SESSION['panier']);  // on ne supprime que le panier en conservant l'éventuel $_SESSION['membre'].

}


// 4- Supprimer un article :
//debug($_GET);

if(isset($_GET['action']) && $_GET['action'] == 'supprimer_article' && isset($_GET['id_produit'])){  // si dans l'URL nous avons l'indice "action" de valeur "supprimer_article" c'est qu'on a demandé la suppression de l'article du panier. On verifie alors que l'id_produit est aussi dans l'URL.

    retirerProduit($_GET['id_produit']);

}


// 5- Validation du panier
//debug($_POST);
//debug(montantTotal());

if(isset($_POST['valider']) && isset($_SESSION['panier'])){  // si on a cliqué sur "valider le panier" et que le panier existe toujours, on peut le valider (cas du F5).

    // Pour remplir la TABLE "commande", il nous faut l'id_membre et le montant total du panier :
    //debug($_SESSION);
    $id_membre = $_SESSION['membre']['id_membre'];
    $montantTotal = montantTotal();

    // Insertion de la commande en BDD :
    executeRequete("INSERT INTO commande (id_membre, montant, date_enregistrement) VALUES (:id_membre, :montant, NOW())", array(':id_membre' => $id_membre, ':montant' => $montantTotal));

    // Insertion détail de la commande en BDD :
    $id_commande = $pdo->lastInsertId();  // on récupère l'identifiant de la commande qui a été généré dans le INSERT précédent.

    // On parcourt le panier pour insérer chaque produit dans la TABLE "details_commande". 
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++){

        $id_produit = $_SESSION['panier']['id_produit'][$i];
        $quantite = $_SESSION['panier']['quantite'][$i];
        $prix = $_SESSION['panier']['prix'][$i];

        executeRequete("INSERT INTO details_commande(id_commande, id_produit, quantite, prix) VALUES (:id_commande, :id_produit, :quantite, :prix)", array(':id_commande'=> $id_commande, ':id_produit' => $id_produit,':quantite' => $quantite, ':prix' => $prix));  // on insère 1 seul produit par tour de boucle FOR.


        // Diminuer le stock du produit commandé :
        executeRequete("UPDATE produit SET stock = stock - :quantite WHERE id_produit = :id_produit", array(':quantite' => $quantite, ':id_produit' => $id_produit));

    }

    unset($_SESSION['panier']);  // on supprime le panier dès que laboucle est finie et que tous les produits sont dans la table details_commande en BDD.

    $contenu = '<div class="alert alert-success">Merci pour votre commande. Elle est enregistrée sous le numéro : ' . $id_commande . '</div>';

}   // FIN du (isset($_POST['valider']))

require_once 'inc/header.php';
//debug($_SESSION);  // pour visualiser rapidement le contenu du panier

// 2- Afficher le panier HTML :
echo '<h1 class=mt-4>Votre panier</h1>';


echo $contenu;

if(empty($_SESSION['panier']['id_produit'])){  // si le panier est vide

    echo '<p class="btn alert-danger">Votre panier est vide.</p>';

} else{

    echo '<table class="table">';
        // Ligne d'entête :
        echo '<tr class="info text-center">
                <th>Titre</th>
                <th>Réference</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Action</th>
            </tr>';

        // Ligne de chaque produit :
        
        for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++){  // on fait autant de tour de boucle que d'id_produit comptés dans le panier.

            echo '<tr class="text-center">';
                echo '<td>'. $_SESSION['panier']['titre'][$i] .'</td>';
                echo '<td>'. $_SESSION['panier']['reference'][$i] .'</td>';
                echo '<td>'. $_SESSION['panier']['quantite'][$i] .'</td>';
                echo '<td>'. number_format($_SESSION['panier']['prix'][$i], 2, ',','') .'€</td>';
                echo '<td>';
                    echo '<a href="?action=supprimer_article&id_produit=' . $_SESSION['panier']['id_produit'][$i] . '" class="btn alert-danger">Supprimer l\'article</a>';
                echo '</td>';
            echo '</tr>';

        }

        // Ligne du total panier :
        echo '<tr class="font-weight-bold">';
            echo '<td colspan="3">TOTAL</td>';
            echo '<td colspan="2" class="text-left">'. number_format(montantTotal(), 2, ',', '') .'€</td>';
        echo '</tr>';


        // Ligne du bouton de validation du panier :
        if(estConnecte()){  // si le membre est connecté, on lui affiche le bouton de validation du panier

            echo '<tr class="text-center">';
                echo 
                '<td colspan="5">
                    <form method="post">
                        <input type="submit" name="valider" value="Valider le panier" class="btn btn-info">
                    </form>
                </td>';
            echo '</tr>';

        } else{  // sinon on l'invite à s'inscire ou à se connecter

            echo '<tr>';
                echo '<td colspan="5">';
                
                    echo 'Veuillez vous <a href="inscription.php">inscrire</a> ou vous <a href="connexion.php">connecter</a> afin de pouvoir valider le panier.';
                    
                echo '</td>';
            echo '</tr>';

        }

        // Ligne vider le panier :
        echo '<tr class="text-center">';
            echo '<td colspan="5">';
                echo '<a href="?action=vider">Vider mon panier</a>';
            echo '</td>';
        echo '</tr>';

    echo '</table>';

} // fin du panier









require_once 'inc/footer.php';