<?php
//------------------------------------------------------
//Validation de formulaire
//------------------------------------------------------

$message = '';  //  variable qui contiendra les messages à l'internaute

// 2- Connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=entreprise',  // driver MySQL, nom du serveur, nom de la BDD
                'root',  // Login de la BDD
                '',  // mot de passe de la BDD
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  // pour afficher les erreurs SQL dans le navigateur
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // définit le jeu de caractères des échanges avec la BDD
                )
);

// 3- Quand le formulaire st envoyé, nous prenons tous les champs :
echo '<pre>';
    print_r ($_POST);
echo '</pre>';

if (!empty($_POST)){  // si le formulaire a été envoyé
    // Contrôle des 6 champs :
    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) < 2 || strlen($_POST['prenom']) > 20){
        $message .= '<div>Le prénom doit comporter entre 2 et 20 caractères.</div>';
    }  // on vérifie : si n'existe pas le "prenom" dans $_POST (c'est que le formulaire a été modifié dans l'inspecteur) OU alors si la longueur du prénom est inférieur à 3 OU si la longueur du prénom est supérieur à 20 (imposé par la BDD).

    if(!isset($_POST['nom']) || strlen($_POST['nom']) < 2 || strlen($_POST['nom']) > 20){
        $message .= '<div>Le nom doit comporter entre 2 et 20 caractères.</div>';
    }

    if(!isset($_POST['service']) || strlen($_POST['service']) < 2 || strlen($_POST['service']) > 30){
        $message .= '<div>Le service doit comporter entre 2 et 30 caractères.</div>';
    }

    if(!isset($_POST['sexe']) || ($_POST['sexe'] != 'm' && $_POST['sexe'] != 'f')){
        $message .= '<div>Le sexe n\'est pas valide.</div>';
    }  // si n'existe "sexe" dans $_POST OU que sa valeur est différente de "m" et de "f" simultanément.

    $_POST['salaire'] = str_replace(',' , '.' , $_POST['salaire']); //  permet de rester en numérique et non en chaîne de caractères
    if(!isset($_POST['salaire']) || !is_numeric($_POST['salaire']) || $_POST['salaire'] <= 0 || $_POST['salaire'] >=1000000){
        $message .= '<div>Le salaire doit être un nombre compris entre 1 et 1000000.</div>';
    }

    if(!isset($_POST['date_embauche']) || !preg_match('#^[0-9]{2}/[0-9]{2}/[0-9]{4}$#', $_POST['date_embauche']) || !checkdate(substr($_POST['date_embauche'],3,2),substr($_POST['date_embauche'],0,2), substr($_POST['date_embauche'],6,4))){
        $message .= '<div>La date n\'est pas valide.</div>';
    }  // 22/04/2020  
    // preg_match() retourne true si la date fournie est bien au format "2 chiffres/2 chiffres/4 chiffres".
    /*
        L'expression régulière (regex est définie de la manière suivante : 
        ^ définie le début 
        $ définit la fin
        [0-9] définit l'intervalle des chiffres de 0 à 9 autorisés
        {2} définit la quantité de ces chiffres
        / définit un slash
    */
    // checkdate(mois, jour, année) retourne true si la date fournie existe bien.
    // substr() découpe une chaîne de caractère à partir de la position indiquée (on compte à partir de 0) et sur le nombre de caractères indiqué. 


    // 4- Une fois le formulaire totalement validé, on échappe les données et on les insère en BDD :
    if (empty($message)){ // s'il n'y a pas de message d'erreur, c'est que le formulaire est validé. 
        // On échappe les valeurs de $_POST :
        foreach($_POST as $indice => $valeur){  // on parcourt $_POST en prenant chaque indice et chaque valeur
            $_POST[$indice] = htmlspecialchars($valeur, ENT_QUOTES);  // on échappe chacune des valeurs à chaque tour de boucle que l'on range à leur indice. Exemple "John" est échappé puis réaffecté à $_POST['prenom'] au 1er tour de boucle.
        }

        // on reformate la date pour respecter le format de la BDD (Y-m-d) :
        $date = new DateTime(str_replace('/', '-', $_POST['date_embauche']));  // on créer un objet $date avec la classe DateTime en lui indiquant une date au format d-m-Y avec des tirets. Pour cela on remplace dans la date d'embauche les "/" par des "-" avec la fonction "str_replace()".  
        $date_embauche = $date->format('Y-m-d');  // avec la méthode "format()" on reformate la date au format Y-m-d pour aaaa-mm-jj (pour être compatible avec notre BDD).
        print_r($date_embauche);

        // Insertion an BDD avec une requ^te préparée :
        $resultat = $pdo->prepare("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) VALUES(:prenom, :nom, :sexe, :service, :date_embauche, :salaire)");
        $succes = $resultat->execute(array(
            ':prenom' => $_POST['prenom'],
            ':nom' => $_POST['nom'],
            ':sexe' => $_POST['sexe'],
            ':service' => $_POST['service'],
            ':date_embauche' => $date_embauche,
            ':salaire' => $_POST['salaire']
        ));  // la méthode execute() retourne true en cas de succès de la requ^te, false en cas d'échec.


        // 5- Afficher un message de réussite ou d'échec :
        if($succes){
            $message .= '<div>L\'employé a bien été ajouté.</div>';
        }else{
            $message .= '<div>Erreur lors de l\'enregistrement...</div>';
        }

    }  // FIN du if(empty($message))


}  // FIN de if(!empty($_POST))



// 1- Formulaire HTML :
?>

<h1>Nouvel employé</h1>
<?php echo $message; ?>

<form method="post" action="">

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
            <label for="service">Service</label>
        </div>
        <div>
            <input type="text" name="service" id="service" value="<?php echo $_POST['service'] ?? ''; ?>">
        </div>
    </div>
    <div>
            <label for="date_embauche">Date d'embauche</label>
        </div>
        <div>
            <input type="text" name="date_embauche" id="date_embauche" value="<?php echo $_POST['date_embauche'] ?? ''; ?>" placeholder="jj/mm/aaaa">
        </div>
    </div>
    <div>
            <label for="salaire">Salaire</label>
        </div>
        <div>
            <input type="text" name="salaire" id="salaire" value="<?php echo $_POST['salaire'] ?? ''; ?>">
        </div>
    </div>
    <div>
        <div>
            <label for="">Sexe</label>
        </div>
        <div>
            <input type="radio" name="sexe" id="sexe" value="m" checked> Masculin
            <input type="radio" name="sexe" id="sexe" value="f" <?php if(isset($_POST['sexe']) && $_POST['sexe'] == 'f') echo 'checked' ?> > Feminin
        </div>
    </div>
    <div>
        <input type="submit" value="Envoyer">
    </div>

</form>