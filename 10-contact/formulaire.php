<?php

require_once 'inc/init.php';
//debug($_POST);
//debug($_FILES);
// 3- Vérification :

if(!empty($_POST)){

    if(!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) >50){

        $contenu .= '<div class="alert alert-danger">Le nom doit contenir entre 2 et 20 caractères.</div>';
    }


    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) >50){

        $contenu .= '<div class="alert alert-danger">Le prénom doit contenir entre 2 et 20 caractères.</div>';
    }

    if(!isset($_POST['telephone']) || !preg_match('#^[0-9]{10}$#', $_POST['telephone'])){
        $contenu .= '<div class="alert alert-danger">Le numéro de téléphone doit comporter 10 chiffres.</div>';
    }

    if(!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $contenu .= '<div class="alert alert-danger">L\'email n\'est pas valide</div>';
    }

    //---------- photo :
    if(!empty($_FILES['photo']['name'])){ 
        $photo_bdd = '';

        $nom_photo = 'ref_' . $_POST['nom'] . '_' . $_FILES['photo']['name'];
        
        $photo_bdd = 'photos/' . $nom_photo; 

        copy($_FILES['photo']['tmp_name'],$photo_bdd);
    }

    

    //-------insertion BDD :

    if(empty($contenu)){



        foreach($_POST as $indice => $valeur){

            $_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);
            
        }

        $resultat = $pdo->prepare("INSERT INTO contact ( type_contact, nom, prenom, telephone, email, photo) VALUES ( :type_contact, :nom, :prenom, :telephone, :email, :photo)");

        $succes = $resultat->execute(array(
            
            ':type_contact' => $_POST['type_contact'],
            ':nom' => $_POST['nom'],
            ':prenom' => $_POST['prenom'],
            ':telephone' => $_POST['telephone'],
            ':email' => $_POST['email'],
            ':photo' => $photo_bdd
        ));

        if($succes){
            $contenu .= '<div class="alert alert-success">Le contact a bien été ajouté.</div>';
        }else{
            $contenu .= '<div class="alert alert-danger">Erreur lors de l\'enregistrement...</div>';
        }

    }

}





require_once 'inc/header.php';

// 2- Formulaire HTML :
?>

<h1 class="my-4 text-center">Nouveau contact</h1>
<?php echo $contenu; ?>

<form method="post" enctype="multipart/form-data" action="" class="mt-4">

    <div>
        <div>
            <label for="type_contact">Choisissez un type de contact :</label>
            <div>
                <select name="type_contact" id="type_contact">
                    <!-- <option value=""></option> -->
                    <option >Ami</option>
                    <option >Famille</option>
                    <option >Professionnel</option>
                    <option >Autre</option>
                </select>
            </div>
        </div>
    </div>

    <div>
        <div>
            <label for="prenom">Prénom</label>
        </div>
        <div>
            <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>">
        </div>
    </div>
    <div>
        <div>
            <label for="nom">Nom</label>
        </div>
        <div>
            <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? ''; ?>">
        </div>
    </div>
    <div>
            <label for="telephone">Téléphone</label>
        </div>
        <div>
            <input type="text" name="telephone" id="telephone" value="<?php echo $_POST['telephone'] ?? ''; ?>">
        </div>
    </div>
    <div>
            <label for="email">Email</label>
        </div>
        <div>
            <input type="text" name="email" id="email" value="<?php echo $_POST['email'] ?? ''; ?>">
        </div>
    </div>
    <div>
            <label for="photo">Photo</label>
        </div>
        <div>
            <input type="file" name="photo">
        </div>
    </div>
    <div>
        <input type="submit" value="Envoyer" class="btn btn-info mt-4">
    </div>

</form>

<?php
require_once 'inc/footer.php';