<?php
require_once '../inc/init.php';

// 1- Vérifier que le membre est bien administrateur :

if(!estAdmin()){
    header('location:../connexion.php');  // si le membre n'est pas admin, on le redirige sur la page de connexion.
    exit;
}

// 4-Enregistrement du produit :
//debug($_POST);

if(!empty($_POST)){  // si le formulaire de création de produit a été envoyé

    // ici il faudrait mettre tous les contrôles sur le formulaire dans un site abouti.

    $photo_bdd = '';  // par défaut le champ photo est vide en BDD.

    // 9- Suite de la modification de la photo :
    if(isset($_POST['photo_actuelle'])){
        $photo_bdd = $_POST['photo_actuelle'];  // quand on est en modification, on remet le chemin de la photo qui est actuellement dans le formulaire en BDD
    }





    //Traitement de la photo du produit :
    //debug($_FILES);  // $_FILES est une SUPERGLOBALE générée par le type="file" du champ "photo" du formulaire. Le premier indice ['photo'] de $_FILES correspond au "name" de cet input. A cet indice, se trouve un sous-tableau avec notamment l'indice "name" qui contient le nom du fichier en cours de téléchargement, l'indice "type" qui contient le type du fichier (exemple img/png), l'indice "size" qui contient la taille du fichier en octet.

    if(!empty($_FILES['photo']['name'])){  // s'il y a un nom de fichier dans $_FILES, c'est que nous sommes en train de télécharger un fichier.

        $nom_photo = 'ref' . $_POST['reference'] . '_' . $_FILES['photo']['name'];  // on ajoute au nom du fichier en cours de téléchargement la référence de notre produit afinde créer un nom de fichier unique.
        
        $photo_bdd = 'photos/' . $nom_photo;  // cet variable contient le chemin relatif du fichier photo qui est inséré en BDD un peu plus bas, et qui correspond au fichier photo physique que l'on sauvegarde sur notre serveur juste après.  Cette valeur sera utilisée dans les attributs "src" des balises <img>. 

        copy($_FILES['photo']['tmp_name'], '../' . $photo_bdd);  // on suvegarde le fichier en cours de téléchargement temporairement stocké à l'adresse $_FILES['photo']['name'] vers l'ndroit défini par la variable $photo_bdd, autrement dit dans notre dossier "photos/" du site.
    }


    // Insertion du produit en BDD
    $requete = executeRequete("REPLACE INTO produit VALUES(:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)", array(
        ':id_produit'       => $_POST['id_produit'], // vaut 0 par défaut pour que le REPLACE fasse une insertion. Dans le cas où l'id existe en BDD, le REPLACE fera un update du produit.
        ':reference'        => $_POST['reference'],
        ':categorie'        => $_POST['categorie'],
        ':titre'            => $_POST['titre'],
        ':description'      => $_POST['description'],
        ':couleur'          => $_POST['couleur'],
        ':taille'           => $_POST['taille'],
        ':public'           => $_POST['public'],
        ':photo'            => $photo_bdd,  // vide par défaut.
        ':prix'             => $_POST['prix'],
        ':stock'            => $_POST['stock'],
    ));

    if($requete){  // si la variable a reçu un objet PDOStatment, implicitement évalué à true, c'est que la requête a marché. 
        $contenu .= '<div class="alert alert-success">Le produit a été enregistré.</div>';
    } else{  // sinon si on a reçu false, il y a erreur lors de l'enregistrement.
        $contenu .= '<div class="alert alert-danger">Un erreur est survenue...</div>';
    }



} // FIN if(!empty($_POST))

// 8- Modification d'un produit : remplissage du formulaire :
//debug($_GET);

if(isset($_GET['id_produit'])){  // si existe id_produit dans l'URL, c'est qu'on a demandé sa modification. On séléctionne donc ce produit en BDD pour remplir le formulaire de modification.

    $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit", array(':id_produit' => $_GET['id_produit']));
    //debug($resultat);  // objet PDOStatement

    $produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);  // on "fetche" les données du produit en cours de modification sans boucle car il est unique par id_produit
    debug($produit_actuel);
}

require_once '../inc/header.php';
?>

<!-- 2- Onglets de navigation : -->

<h1 class="mt-4 mb-4 text-center">Gestion boutique</h1>

<ul class="nav nav-tabs">

    <li><a href="gestion_boutique.php" class="nav-link">Affichage des produits</a></li>
    <li><a href="formulaire_produit.php" class="nav-link active">Formulaire produit</a></li>

</ul>

<?php
echo $contenu;  // pour afficher les messages
?>

<!-- 3- formulaire HTML -->

<form method="post" enctype="multipart/form-data" action=""><!-- l'attribut enctype spécifie que le formulaire envoie des données binaires (fichier) et du texte (champs). Cela nous permettra de télécharger une photo du produit -->

    <div>
        <input type="hidden" name="id_produit" value="<?php echo $produit_actuel['id_produit'] ?? 0;  ?>"><!-- champ de type "hidden" nécessaire pour la modification d'un produit car on aura besoin de ID pour la requête SQL de modification. Quand on met une valeur à 0 pour l'identifiant, le REPLACE en BDD va se comporter comme un INSERT, c'est-à-dire qu'il va créer le produit. -->
    </div>

    <div>
        <div><label for="reference">Référence</label></div>
        <div><input type="text" name="reference" id="reference" value="<?php echo $produit_actuel['reference'] ?? '';  ?>"></div>
    </div>

    <div>
        <div><label for="categorie">Catégorie</label></div>
        <div><input type="text" name="categorie" id="categorie" value="<?php echo $produit_actuel['categorie'] ?? '';  ?>"></div>
    </div>

    <div>
        <div><label for="titre">Titre</label></div>
        <div><input type="text" name="titre" id="titre" value="<?php echo $produit_actuel['titre'] ?? '';  ?>"></div>
    </div>

    <div>
        <div><label for="description">Description</label></div>
        <div><textarea name="description" id="description" cols="30" rows="10"><?php echo $produit_actuel['description'] ?? ''; ?></textarea></div>
    </div>

    <div>
        <div><label for="couleur">Couleur</label></div>
        <div><input type="text" name="couleur" id="couleur" value="<?php echo $produit_actuel['reference'] ?? '';  ?>"></div>
    </div>

    <div>
        <div><label>Taille</label></div>
        <div>
            <select name="taille">
                <option <?php if(isset($produit_actuel['taille']) && $produit_actuel['taille'] == 'S') echo 'selected'; ?> >S</option>
                <option <?php if(isset($produit_actuel['taille']) && $produit_actuel['taille'] == 'M') echo 'selected'; ?> >M</option>
                <option <?php if(isset($produit_actuel['taille']) && $produit_actuel['taille'] == 'L') echo 'selected'; ?> >L</option>
                <option <?php if(isset($produit_actuel['taille']) && $produit_actuel['taille'] == 'XL') echo 'selected'; ?> >XL</option>
            </select>
        </div>
    </div>

    <div>
        <div><label>Public</label></div>
        <div>
            <input type="radio" name="public" value="m" checked>Masculin
            <input type="radio" name="public" value="f" <?php if(isset($produit_actuel['public']) && $produit_actuel['public'] == 'f') echo 'checked'; ?> >Feminin
            <input type="radio" name="public" value="mixte" <?php if(isset($produit_actuel['public']) && $produit_actuel['public'] == 'mixte') echo 'checked'; ?> >Mixte
        </div>
    </div>

    <div>
        <div><label>Photo</label></div>
        <div><input type="file" name="photo"></div><!-- ne pas oublié de mettre l'attribut enctype="multipart/form-data" sur la balise <form>.-->
    </div>
    <!-- 9- modification de la photo -->
    <?php 
        if(isset($produit_actuel['photo'])){  // en cas de mmodification du produit, nous en affichons la photo actuelle
            echo '<p>photo actuelle</p>';
            echo '<p><img src="../' . $produit_actuel['photo'] . '" style="width:90px"></p>';  // attention nous sommes dans le sous dossier "admin" donc "../". 
            echo '<input type="hidden" name="photo_actuelle" value="'. $produit_actuel['photo'] .'" >';  // on met cechamp (caché pour ne pas la modifier) pour remplir $_POST lors de l'envoi du formulaire et remettre sa valeur en BDD à la place d'un string vide.
        }
    
    
    
    ?>
    <div>
        <div><label for="prix">Prix</label></div>
        <div><input type="text" name="prix" id="prix" value="<?php echo $produit_actuel['prix'] ?? '';  ?>"></div>
    </div>

    <div>
        <div><label for="stock">Stock</label></div>
        <div><input type="text" name="stock" id="stock" value="<?php echo $produit_actuel['stock'] ?? '';  ?>"></div>
    </div>

    <div>
        <input type="submit" value="Enregistrer le produit" class="btn mt-4">
    </div>

</form>




<?php
require_once '../inc/footer.php';