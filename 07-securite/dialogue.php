<?php
//----------------------------------------------
// Sécuriser une requête dont les données (sql) proviennent de l'internaute
//----------------------------------------------

/* Modélisation de la BDD "dialogue"

    Table : commentaire
    Champs : id_commentaire         INT PK AI
             pseudo                 VARCHAR(20)
             message                TEXT
             date_enregistrement    DATETIME

*/

// 2- Connexion à la BDD et traitement de $_POST :

$pdo = new PDO('mysql:host=localhost;dbname=dialogue',  // driver MySQL, nom du serveur, nom de la BDD
                'root',  // Login de la BDD
                '',  // mot de passe de la BDD
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  // pour afficher les erreurs SQL dans le navigateur
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // définit le jeu de caractères des échanges avec la BDD
                )
);

//print_r($_POST);

if (!empty($_POST)){  // si le formulaire a été envoyé



    // 5- Traitement contre les failles JS (encore appelées XSS) ou les injections CSS : on parle d'echapper les données reçues.
    // Nous faison l'injection CSS suivante dans le message :
    // <style> body {display: none;} </style> 
    
    // Pour s'en prémunir nous faisons un échappent de toutes les données venant du formulaire :
    $_POST['pseudo'] = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
    $_POST['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);  // cette fonction transform les caractères suivants en entité HTML : le < devient &lt;  le > devient&gt;  le & devient &amp;   les " deviennent &quot;
    // Les chevrons des balises <style> et des balises <script> sont donc neutralisées dans le navigateur (on voit les entités HTML dans le BDD via PHPMyAdmin).


    /*******************************/


    // Nous faisons une première requête d'insertion qui n'est pas protégée contre les injections SQL et qui n'accepte pas les apostrophes :
    //$resultat = $pdo->query("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES ('$_POST[pseudo]', NOW(), '$_POST[message]')");


    // 4- Nous faison l'injection SQL suivante dans le champs message :
    // '); DELETE FROM commentaire; #
    // Elle a pour effet de vider la table "commentaire". 
    // Pour se prémunir des injections SQL, nous faisons une requête préparée :
    $resultat = $pdo->prepare("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES (:pseudo, NOW(), :message)");
    $resultat->execute(array(
        ':pseudo' => $_POST['pseudo'],
        ':message' => $_POST['message']

    ));
    // Avec cette requête préparée, on constate que l'injection SQL est neutralisée. Par ailleurs les apostrophes sont désormais acceptées.
    // Comment ça marche ? Le fait de mettre des marqueurs vides dans la requête permet de ne pas concaténer les instructions SQL qui les rend directement exécutables. Par ailleurs, en associant les marqueurs à leur valeur dans le "execute()", on neutralise les instructions SQL avec PDO qui les transfome en chaîne de caractères inoffensives. La BDD reçoit donc du texte qui n'est pas du code à exécuter.



}  // FIN du if(!empty($_POST))





// 1- Formulaire HTML :
?>

<h1> Votre Message </h1>

<form method="post" action="">

    <div>
        <input type="text" name="pseudo" placeholder="Votre pseudo" value="<?php echo $_POST['pseudo'] ?? '';  ?>">
    </div>   
    <div>
        <textarea name="message" placeholder="Votre message"><?php echo $_POST['message'] ?? '';   ?></textarea>
    </div>
    <div>
        <input type="submit">
    </div>

</form>

<?php
// 3- Affichage des commentaires :
$resultat = $pdo->query("SELECT pseudo, message, date_enregistrement FROM commentaire ORDER BY date_enregistrement DESC");

echo '<h2>' . $resultat->rowCount() . ' commentaires posté(s).</h2>';

while($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)){

    //print_r($commentaire);

    echo '<div>Par ' . $commentaire['pseudo'] . ' le ' . $commentaire['date_enregistrement'] . '</div>';
        echo '<div>' . $commentaire['message'] . '</div>';
    echo '</div><hr>';

}