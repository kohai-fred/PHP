<h1>Les commerciaux et leur salaire</h1>

<?php
// Exercice :
// 1- Afficher dans une liste <ul> le prénom, le nom et le salaire des commerciaux avec 1 employé par <li> en utilisant une requête préparée.
// 2- Afficher le nombre total de commerciaux.
function debug($variable){
    echo '<pre>';
        print_r($variable);
    echo '</pre>';
}

$pdo = new PDO('mysql:host=localhost;dbname=entreprise',  // driver MySQL, nom du serveur, nom de la BDD
                'root',  // Login de la BDD
                '',  // mot de passe de la BDD
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  // pour afficher les erreurs SQL dans le navigateur
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // définit le jeu de caractères des échanges avec la BDD
                )
);



$service = 'commercial';

$resultat = $pdo->prepare("SELECT * FROM employes WHERE service = :service");

$resultat->bindParam(':service', $service);
$resultat->execute();

echo '<ul>';

    while($employe = $resultat->fetch(PDO::FETCH_ASSOC)){
        echo '<li>Prenom : '. $employe['prenom'].", Nom : ".$employe['nom'].", Salaire : ".$employe['salaire'].'</li>';
    }

echo '</ul>';

echo "Il y a au total : " . $resultat->rowCount() ." commerciaux.";  // méthode qui compte le nombre de lignes dans l'objet PDOStatement $resultat.


