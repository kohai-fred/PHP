<?php
/* 1- Créer une base de données "repertoire" avec une table "contact" :
		id_contact PK AI INT
		nom VARCHAR(50)
		prenom VARCHAR(50)
		telephone VARCHAR(10)
		email VARCHAR(255)
		type_contact ENUM('ami', 'famille', 'professionnel', 'autre')
		photo VARCHAR(255)

	2- Créer un formulaire HTML (avec doctype...) afin d'ajouter un contact dans la bdd. 
		Le champ type_contact doit être géré via un "select option".
		On doit pouvoir uploader une photo par le formulaire. 
	
	3- Effectuer les vérifications nécessaires :
		Les champs nom et prénom contiennent 2 caractères minimum, le téléphone 10 chiffres
		Le type de contact doit être conforme à la liste des types de contacts
		L'email doit être valide
		En cas d'erreur de saisie, afficher des messages d'erreurs au-dessus du formulaire

	4- Ajouter les infos du contact dans la BDD et afficher un message en cas de succès ou en cas d'échec.
	5- Si une photo est uploadée, ajouter la photo du contact en BDD et uploader le fichier sur le serveur de votre site.

*/

