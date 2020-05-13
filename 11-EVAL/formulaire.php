<?php

require_once 'inc/init.php';
debug($_POST);
debug($_FILES);

if(!empty($_POST)){
    
    //Vérification de la photo:
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $extension = strrchr($_FILES['photo']['name'], '.');
        if($_FILES['photo']['name'] == !array($extension, $extensions)){
            $contenu .= '<div class="alert alert-danger">Veuillez choisir une photo avec une extension valide (.png, .gif, .jpg ou jpeg).</div>';
        }

        /*  $taille_maxi = 500000;
        $taille = filesize($_FILES['photo']['tmp_name']);
        if($_FILES['photo']['name'] == $taille>$taille_maxi)
        {
            $contenu .= '<div class="alert alert-danger">Le fichier est trop gros... 500ko maximum</div>';
        } */
        if($_FILES['photo']['size'] >= 500000){
            $contenu .= '<div class="alert alert-danger">Le fichier est trop gros... 500ko maximum</div>';
        }
    // fin de la vérification photo.

    if(!isset($_POST['titre']) || strlen($_POST['titre']) <= 0){
        $contenu .= '<div class="alert alert-danger">Le titre est obligatoire.</div>';
    }

    if(!isset($_POST['adresse']) || strlen($_POST['adresse']) < 4 || strlen($_POST['adresse']) > 50) {
        $contenu .= '<div class="alert alert-danger">L\'adresse doit contenir entre 4 et 50 caractères.</div>';
    }

    if(!isset($_POST['ville']) || strlen($_POST['ville']) < 1 || strlen($_POST['ville']) > 20) {
        $contenu .= '<div class="alert alert-danger">La ville doit contenir entre 1 et 20 caractères.</div>';
    }

    if(!isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp'])){
        $contenu .= '<div class="alert alert-danger">Le code postale n\'est pas valide.</div>';
    }

    
    /* if(!isset($_POST['surface']) || !preg_match('#^[0-9]$#', $_POST['surface']) && !filter_var($_POST['surface'], FILTER_VALIDATE_INT) || strlen($_POST['ville']) < 1){
        $contenu .= '<div class="alert alert-danger">La surface doit être un chiffre entier et suppérieur à 1.</div>';
    } */
    if(!isset($_POST['surface']) || !ctype_digit($_POST['surface'])<= 0){
        $contenu .= '<div class="alert alert-danger">La surface doit être un chiffre entier et suppérieur à 1.</div>';
    }

    /* if(!isset($_POST['prix']) || !preg_match('#^[0-9]$#', $_POST['prix']) && !filter_var($_POST['prix'], FILTER_VALIDATE_INT) || strlen($_POST['prix']) < 1){
        $contenu .= '<div class="alert alert-danger">Le doit être un chiffre entier et supprérieur à 1.</div>';
    } */
    if(!isset($_POST['prix']) || !ctype_digit($_POST['surface'])<= 0){
        $contenu .= '<div class="alert alert-danger">Le doit être un chiffre entier et supprérieur à 1.</div>';
    }

    if(!isset($_POST['type']) || !array()){

    }


    $photo_bdd = '';
    
    //if(!is_dir('photo')) mkdir('photo'); // si le dossier n'existe pas, on le créé.

    if(!empty($_FILES['photo']['name'])){

        $nom_photo = 'logement_' . time() . '.jpg';
        
        //$photos3;
        //$photo_bdd = 'photos3/' . $nom_photo; 

        /* if(is_dir($photo_bdd = 'photos4/' . $nom_photo)){
            copy($_FILES['photo']['tmp_name'], $photo_bdd);

        } else{
            $photo_bdd = mkdir('photos4/') . $nom_photo; 
            copy($_FILES['photo']['tmp_name'], $photo_bdd);
        } */
        
        $photo_bdd = 'photos/' . $nom_photo; 

        copy($_FILES['photo']['tmp_name'], $photo_bdd);
    }

    if(empty($contenu)){

    

        $requete = executeRequete("REPLACE INTO logement VALUES (:id_logement, :titre, :adresse, :ville, :cp, :surface, :prix, :photo, :type, :description)", array(
            ':id_logement' => $_POST['id_logement'],
            ':titre' => $_POST['titre'],
            ':adresse' => $_POST['adresse'],
            ':ville' => $_POST['ville'],
            ':cp' => $_POST['cp'],
            ':surface' => $_POST['surface'],
            ':prix' => $_POST['prix'],
            ':photo' => $photo_bdd,
            ':type' => $_POST['type'],
            ':description' => $_POST['description']
        ));

        if($requete){
            $contenu .= '<div class="alert alert-success">Le logement a été enregistré.</div>';
        } else{
            $contenu .= '<div class="alert alert-danger">Un erreur est survenue...</div>';
        }
    }
}




require_once 'inc/header.php';

?>

<h1 class="mt-4 mb-4 text-center">Inscription logement</h1>

<?php
echo $contenu;
?>

<!-- formulaire HTML -->

<form method="post" enctype="multipart/form-data" action="">

    <div>
        <input type="hidden" name="id_logement" value="">
    </div>

    <div>
        <div><label for="titre">Titre</label></div>
        <div><input type="text" name="titre" id="titre" value=""></div>
    </div>

    <div>
        <div><label for="adresse">Adresse</label></div>
        <div><input type="text" name="adresse" id="adresse" value=""></div>
    </div>

    <div>
        <div><label for="ville">Ville</label></div>
        <div><input type="text" name="ville" id="ville" value=""></div>
    </div>

    <div>
        <div><label for="cp">Code postale</label></div>
        <div><input type="text" name="cp" id="cp" value=""></div>
    </div>

    <div>
        <div><label for="surface">Surface</label></div>
        <div><input type="text" name="surface" id="surface" value=""></div>
    </div>

    <div>
        <div><label for="prix">Prix</label></div>
        <div><input type="text" name="prix" id="prix" value=""></div>
    </div>

    <div>
        <div><label>Type de logement</label></div>
        <div>
            <input type="radio" name="type" value="Location" checked>Location
            <input type="radio" name="type" value="Vente">Vente
        </div>
    </div>

    <div>
        <div><label>Photo</label></div>
        <div><input type="file" name="photo"></div>
    </div>


    <div>
        <div><label for="description">Description</label></div>
        <div><textarea name="description" id="description" cols="30" rows="10"><?php echo $produit_actuel['description'] ?? ''; ?></textarea></div>
    </div>


    <div>
        <input type="submit" value="Enregistrer le produit" class="btn mt-4 btn-info">
    </div>

</form>




<?php

require_once 'inc/footer.php';