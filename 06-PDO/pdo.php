<style>
    table{
        border-collapse: collapse;
    }

    table, tr , td, th{
        border: 1px solid black;
    }
</style>


<?php
//-----------------------------------------------------------------
//                          PDO
//-----------------------------------------------------------------

function debug($variable){
    echo '<pre>';
        print_r($variable);
    echo '</pre>';
}


// Définition de PDO : PDO pour PHP Data Objects, définit une interface pour accéder à une base de données depuis PHP, et d'y effectuer des requêtes SQL.

//--------------------------------------
echo '<h2> Connexion à la BDD </h2>';
//--------------------------------------

$pdo = new PDO('mysql:host=localhost;dbname=entreprise',  // driver MySQL, nom du serveur, nom de la BDD
                'root',  // Login de la BDD
                '',  // mot de passe de la BDD
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  // pour afficher les erreurs SQL dans le navigateur
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // définit le jeu de caractères des échanges avec la BDD
                )
);

// $pdo est un obet issu de la classe prédéfinie PDO. Il représente la connexion à la base de données.


//--------------------------------------
echo '<h2> La méthode exec() </h2>';
//--------------------------------------

$resultat = $pdo->exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) VALUES ('test', 'test', 'm', 'test', '2020-04-20', 500)");

debug($resultat);

/* 
    exec() est utilisée pour la formulation de requêtes ne retournant pas de résultat : INSERT, UPDATE, DELETE.

    Valeur de retour :
        Succès : renvoie le nombre de lignes affectées par la requête
        Echec  : false
*/

echo "Nombre d'enregistrements affectés par la requête : $resultat <br>";
echo 'Dernier id généré en BDD : ' . $pdo->lastInsertID() . "<br>";  // cette méthode retourne le dernier id utilisé par la BDD lors de l'insertion.


//-------

$resultat = $pdo->exec("DELETE FROM employes WHERE prenom = 'test'");
echo "Nombre d'enregistrements affectés par le DELETE : $resultat <br>";


//--------------------------------------
echo '<h2> La méthode query() avec fetch() et 1 seul résultat </h2>';
//--------------------------------------

$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");

debug($resultat);  // avec query() $resultat est un objet issu de la classe prédéfinie PDOStatement.

/* 
    Au contraire d'exec(), query() est utilisée pour formuler des requêtes qui retournent un ou plusieurs résultats : SELECT.

    Valeur de retour :
        Succès : objet PDOStatement
        Echec  : false

    Notez que query() peut être aussi utilisée avec INSERT, UPDATE ou DELETE mais retournera un objet PDOStatement et non pas le nombre de lignes affectées.
*/

// $resultat est le résultat de notre requête de sélection des informations de Daniel. Cependant, dans le debug précédent, nous ne voyons pas les informations de Daniel. Pourtant elles y sont bien. Il faut donc aller les chercher avec une autre méthode qui s'appelle fetch() :

$employe = $resultat->fetch(PDO::FETCH_ASSOC);  // la méthode fetch() avec le paramètre PDO::FETCH_ASSOC retourne un array associatif ($employe) : on trouve dans ce tableau tous les champs de la requête SQL (correspondant à *) sous forme d'indices.
debug($employe);

echo 'Je suis ' . $employe['prenom'] . ' ' . $employe['nom'] . ' du service ' . $employe['service'] . '<br>';
// ou idem :
echo "Je suis $employe[prenom] $employe[nom] du service $employe[service] . <br><hr>";


// On peut aussi utiliser l'une des méthodes suivantes :
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $resultat->fetch(PDO::FETCH_NUM);  // pour obtenir un tableau indexé numériquement

debug($employe);
echo 'Je suis ' . $employe[1] . ' ' . $employe[2] . ' du service ' . $employe[4] . '<br>';
echo "Je suis $employe[1] $employe[2] du service $employe[4] . <br><hr>";

// ou encore :
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $resultat->fetch();  // pour obtenir un tableau à la fois numérique et associatif
debug($employe);  // affiche les deux
// on peut faire indifféremment les deux : 
echo "Je suis $employe[prenom] $employe[nom] du service $employe[service] . <br>";
echo "Je suis $employe[1] $employe[2] du service $employe[4] . <br>";
echo "Je suis $employe[prenom] $employe[2] du service $employe[service] . <br><hr>";

// et enfin :
$resultat = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
$employe = $resultat->fetch(PDO::FETCH_OBJ);  // pour obtenir un objet StdClass avec le nom des champs de la requête comme propriétés publiques ("public").
debug($employe);
echo 'Je suis ' . $employe->prenom . ' ' . $employe->nom . ' ' . 'du service ' . $employe->service . '.<br>';


// Note : il faut choisir l'un des "fetch()" que vous voulez effectuer, car vous ne pouvez pas faire plusieurs "fetch()" sur le même résultat.



//-------------------
// Exercice : 
//afficher le service de l'employé d'id_employes 417.

$resultat = $pdo->query("SELECT * FROM employes WHERE id_employes=417");
$employe = $resultat->fetch(PDO::FETCH_ASSOC);
echo "Le service de l'employé $employe[id_employes] est le : $employe[service] . <br><hr>";



//--------------------------------------
echo '<h2> La méthode query() avec fetch() et plusieurs résultat </h2>';
//--------------------------------------

$resultat = $pdo->query("SELECT * FROM employes");

echo "Nombre d'employés dans la requête : " . $resultat->rowCount() . "<br>";  // compte le nombre de lignes retournées par la requête dans un objet PDOStatement

debug($resultat);

// Comme nous avons plusieurs lignes dans le jeu de résultats, nous devons faire une boucle pour les parcourir :

while($employe = $resultat->fetch(PDO::FETCH_ASSOC)){  // fetch() va chercher la ligne suivante du jeu de résultats et la retourne en array associatif. La boucle while permet de faire avance le curseur dans le jeu de résultat, et arrête quand il est à la fin, autrement dit quand fetch() retourne false parce qu'il n'y a plus de résultat à "fetcher".

    //debug($employe);  // $employe est un tableau représentant 1 employé à chaque tour de boucle.

    echo '<div>';
        echo '<div>' . $employe['prenom'] . '</div>';
        echo '<div>' . $employe['nom'] . '</div>';
        echo '<div>' . $employe['service'] . '</div>';
        echo '<div>' . $employe['salaire'] . '€</div>';
        
    echo '</div><hr>';
}

//--------------------------------------
echo '<h2> Exercice : </h2>';
//--------------------------------------
// Afficher la liste des différents services dans une liste <ul> et 1 service par <li>. 

$resultat = $pdo->query("SELECT * FROM employes GROUP BY service");

echo '<ul>';
    // Je fais une boucle car nous avons plusieurs résultats à "fetcher" dans l'objet $resultat. "while", tant qu'il y a un service à afficher.
    while($services = $resultat->fetch(PDO::FETCH_ASSOC)){
        
        echo '<li>' . $services['service'] . '</li>';
    }
echo '</ul>';


//--------------------------------------
echo '<h2> La méthode fetchAll() : </h2>';
//--------------------------------------

$resultat = $pdo->query("SELECT * FROM employes");
// $resultat est un objet PDOStatement qui contient le jeu de résultats.

$donnees= $resultat->fetchAll(PDO::FETCH_ASSOC);  // "fetchAll(PDO::FETCH_ASSOC)" retourne toutes les lignes de résultats dans un tableau multidimensionnel : nous y trouvons 1 tableau associatif à chaque indice numérique de $donnees. Chacun des sous-tableau représente 1 seul employé. On peut aussi faire "fetchAll(PPDO::FETCH_NUM)" pour obtenir un sous tableau indicé numériquement, ou encore "fetchAll()" pour obtenir un sous tableau numérique et associatif.

//debug($donnees);

// On parcour $donnees avec une boucle "foreach" pour en afficher le contenu :
foreach($donnees as $employe){  // on parcours le tableau $donneespar ses valeurs affectées à la variable $employe.
   // debug($employe);  // $employe est un tableau associatif qui représente 1 seul employé. 
    echo '<div>';
        echo '<div>Prénom : ' . $employe['prenom'] . '</div>';
        echo '<div>Nom : ' . $employe['nom'] . '</div>';
        echo '<div>Service : ' . $employe['service'] . '</div>';
        echo '<div>Salaire : ' . $employe['salaire'] . '€</div>';
    echo '</div><hr>';
}


//--------------------------------------
echo '<h2> Exercice : </h2>';
//--------------------------------------
// Afficher la liste des differents services des employés masculins uniquement. Vous mettez les services dans une seule liste <ul>, et un service par <li>. A faire avec un "fetchAll()". 

$resultat = $pdo->query("SELECT * FROM employes WHERE sexe = 'm' GROUP BY service");
//$resultat = $pdo->query("SELECT DISTINCT service FROM employes WHERE sexe = 'm'");  // idem que la ligne au dessus.

$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);

echo '<ul>Les différents services masculin sont : ';
foreach($donnees as $employe){
    //debug($employe);
    echo '<li> ' . $employe['service'] . '.</li>';
}
echo '</ul>';


//--------------------------------------
echo '<h2> Afficher les données dans une table HTML : </h2>';
//--------------------------------------
// On veut afficher le jeux de résultats sous forme de table HTML.

$resultat = $pdo->query("SELECT * FROM employes");

echo '<table>';
    // Afficher la ligne des entêtes :
    echo '<thead>';
        echo '<th>Id</th>';
        echo '<th>Prénom</th>';
        echo '<th>Nom</th>';
        echo '<th>Sexe</th>';
        echo '<th>Service</th>';
        echo '<th>Date d\'embauche</th>';
        echo '<th>Salaire</th>';
    echo '</thead>';

    // Afficher les lignes (1 par employé) dynamiquement :
    while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)){  // je fais une boucle car il y a plusieurs résultats à "fetcher". 
        //debug($employe);  // $employe est un tableau associatif représentant 1 employé à chaque tour de boucle.

        echo '<tbody>';  // on ouvre une ligne de <table> pour y mettre 1 employé
            foreach($employe as $information){  // on parcourt $employe pour en récupérer les valeurs dans $information à chaque tour.
                echo '<td>'. $information .'</td>';  //  on met les valeurs du tableau $employe dans des <td>.
            }
        echo '</tbody>';

    }

echo '</table>';



//--------------------------------------
echo '<h2> Les requêtes préparées : </h2>';
//--------------------------------------
// Les requêtes préparées sont préconisées si vous exécutez plusieurs fois la même requête. Ainsi vous évitez de répéter tout le cycle Analyse / Interprétation / Execution de la requête réalisé par le SGBD (MySQL chez nous). Permet des gains de performance serveur.

// Les requêtes préparées sont souvent utilisées pour assainir les données en terme de sécurité, et éviter les injeections de type SQL, ce que nous verrons dans un chapitre ultérieur.

$nom = 'Sennard';

// Une requête préparée se réalmise en deux ou trois étapes :

// 1- On prépare la requête :
$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom ");  // la méthode "prepare()" permet de préparer la requête mais ne l'exécute pas. Avec "prepare()" on utilise des marqueurs : :nom est marqueur nominatif qui est vide et attend une valuer.
// $resultat est un objet PDOStatement.


// 2- On lie le marqueur à sa valeur :
$resultat->bindParam(':nom', $nom);  //  avec "bindParam()", on lie un marqueur à une variable exclusivement. On ne peut pas y mettre une valeur directement. Si le contenu de la variable $nom change, alors la valeur du marqueur changera automatiquement sans avoir besoin de refaire un "bindParam()". 
// OU encore (alternative) :
$resultat->bindValue(':nom', 'Sennard');  // avec "bindValue()", on peut lier le marqueur directement à une valeur, ou à une variable si on le souhaite. Le marqueur pointe vers la VALEUR. Si celle-ci change entre deux execute(), il faudra refaire un "bindValue()" pour prendre en compte cette nouvelle valeur.


// 3- On exécute la requête :
$resultat->execute();  // "execute()" va de paire avec "prepare()". Il permet ainsi déexécuter la requête préalablement préparée.


// On affiche le résultat de la requête :
$employe = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de boucle while car il n'y a qu'un suel "Sennard" dans notre BDD.
debug($employe);

/* 
    Valeur de retour :

    "prepare()" renvoie toujours un objet PDOStatement.

    "execute()" : 
        Succès : true
        Echec : False
*/



//--------------------------------------
echo '<h2> Requêtes préparées : points complémentaires</h2>';
//--------------------------------------

echo '<h3> Le marqueur "?"</h3>';

$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = ? AND prenom = ? ");  // on prépare la requête avec les parties variables représentées par des marqueurs sous forme de "?".

$resultat->bindValue(1, 'Durand');  // 1 représente le premier "?" auquel on lie la valeur "Durand". 
$resultat->bindValue(2, 'Damien');  // 2 représente le second "?" auquel on lie la valeur "Damein". 

$resultat->execute();  //  on exécute l'ensemble de la requête. On peut aussi écrire la syntaxe suivante qui regroupe ces 3 lignes de code :
$resultat->execute(array('Durand','Damien'));  // dans l'ordre, "Durand" remplace le 1er "?" et "Damien" le second "?" puis la requête est exécutée.

$employe = $resultat->fetch(PDO::FETCH_ASSOC);  // pas de boucle car il y a qu'un seul Damien Durand.
debug($employe);

/******************/

echo '<h3> Lier les marqueurs nominatifs à leur valeur directement dans le execute() </h3>';

$resultat = $pdo->prepare("SELECT * FROM employes WHERE nom = :nom AND prenom = :prenom");

$resultat->execute(array(
    ':nom' => 'Chevel',
    ':prenom' => 'Daniel'
));  // on associe chaque marqueur à chaque valeur directement dans un tableau associatif passé en argument de execute(). Notez que nous ne sommes pas obligés de mettre les ":" devant les marqueurs quand on les associe à leur valeur.

$employe = $resultat->fetch(PDO::FETCH_ASSOC);
debug($employe);


//--------------------------------------
echo '<h2> Extension Mysqli </h2>';
//--------------------------------------

//IL existe une autre manière de se connecter à une BDD et d'effectuer des requêtes sur celle-ci : avec l'extension Mysqli. (vieillissant) moins de 20% d'utilisation aujourd'hui. 

//************************************************************************

