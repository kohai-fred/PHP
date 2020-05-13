<?php
/*
	1- Afficher dans une table HTML la liste des contacts avec tous les champs.
	2- Le champ photo devra afficher la photo du contact en 80px de large.
	3- Ajouter une colonne "Voir" avec un lien sur chaque contact qui amène au détail du contact (detail_contact.php).

*/


require_once 'inc/init.php';

$resultat = $pdo->prepare("SELECT * FROM contact");
$resultat->execute();


$contenu .= '<p class="mt-3">Nombre de contact : '. $resultat->rowCount() .' </p>';

$contenu .= '<div class="table-responsive">';
	$contenu .= '<table class="table">';

		$contenu .= '<tr>';

			$contenu .= '<th>ID</th>';
			$contenu .= '<th>Nom</th>';
			$contenu .= '<th>Prénom</th>';
			$contenu .= '<th>Téléphone</th>';
			$contenu .= '<th>Email</th>';
			$contenu .= '<th>Type de contact</th>';
			$contenu .= '<th>photo</th>';
			$contenu .= '<th>Voir</th>';


		$contenu .= '</tr>';
		//debug($resultat);

		while($contact = $resultat->fetch(PDO::FETCH_ASSOC)){

			$contenu .= '<tr>';

				foreach($contact as $indice => $information){

					if($indice == 'photo'){

						$contenu .= '<td><img src="' . $information . '" style="width:80px"></td>';
					} else{
						$contenu .= '<td class="align-middle">' . $information  . '</td>';
					}
					//debug($information);
				}

				$contenu .= '<td class="align-middle">';
					$contenu .= '<a href="detail_contact.php?id_contact='. $contact['id_contact'].'">Voir</a>';
				$contenu .= '</td>';

			$contenu .= '</tr>';

		}


	$contenu .= '</table>';
$contenu .='</div>';


require_once 'inc/header.php';
?>

<h1 class="mt-4 mb-4 text-center">Liste des contacts</h1>

<?php
echo $contenu;
require_once 'inc/footer.php';

