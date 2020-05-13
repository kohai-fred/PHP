<?php
// Ce fichier est inclus dans tous les scripts du site pour notamment initialiser la connexion à la BDD, l'accès aux sessions, définir les variables d'affichage, et inclure le fichier functions.php. 


// Connexion à la BDD :
$pdo = new PDO('mysql:host=localhost;dbname=immobilier',  // driver MySQL, nom du serveur, nom de la BDD
                'root',  // Login de la BDD
                '',  // mot de passe de la BDD
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  // pour afficher les erreurs SQL dans le navigateur
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // définit le jeu de caractères des échanges avec la BDD
                )
);


// Session
session_start();  //  crée un fichier appelé session sur le serveur dans lequel on stocke des données : celles du membre ou de son panier. Si la session existe déjà, on y accède directement à l'aide de l'identifiant reçu dans un cookie depuis le poste de l'internaute.


// Constante qui contient le chemin du site
define('RACINE_SITE', '/PHP/11-EVAL/');  // ici on indique le dossier dans lequel se trouve le site à partir de "localhost". S'il n'est dans un aucun dossier, on met un "/" seul. Permet de créer des chemins absolus à partir de "localhost" utilisés notamment dans le "header.php" qui est inclus dans des pages qui se trouvent dans différents sous-dossiers du site. Par conséquent, les chemins relatifs vers les sources changent selon ces sous-dossiers, ce qui n'est pas le cas en chemin absolu.

/* Chemin relatif :

    ../dossier_cible/fichier.php = on part du dossier courant, on remonte dans le dossier parent puis on descend dans le dossier_cible et on accède au fichier.

    dossier_cible/fichier.php = on part du dossier courant et on entre directement dans le dossier_cible qui se trouve au même endroit.

    Chemin absolu :

    /dossier_cible/fichier.php = on part de la racine du serveur qui est "localhost" dans notre cas, peu importe l'endroit où on se trouve. le "/" du début indique qu'il s'agit d'un chemin absolu.

*/

// Initialisation de variables d'affichage :
$contenu = '';
$contenu_gauche = '';
$contenu_droite = '';  // on y mettra du HTML à afficher

// Inclusion des fonctions :
require_once 'functions.php';