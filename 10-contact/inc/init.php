<?php

$pdo = new PDO('mysql:host=localhost;dbname=repertoire',  // driver MySQL, nom du serveur, nom de la BDD
                'root',  // Login de la BDD
                '',  // mot de passe de la BDD
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,  // pour afficher les erreurs SQL dans le navigateur
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',  // définit le jeu de caractères des échanges avec la BDD
                )
);

session_start();

define('RACINE_SITE', '/PHP/10-contact/');

$contenu = '';

require_once 'function.php';