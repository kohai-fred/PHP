<?php

require_once 'inc/init.php';

$resultat = executeRequete("SELECT * FROM logement"); 
//debug($resultat);
$contenu .= '<p class="mt-3">Nombre de biens : '. $resultat->rowCount() .' </p>';

$contenu .= '<div class="table-responsive">';
$contenu .= '<table class="table">';

    // Les entêtes du <table> :
    $contenu .= '<tr>';

        $contenu .= '<th>ID</th>';
        $contenu .= '<th>Titre</th>';
        $contenu .= '<th>Adresse</th>';
        $contenu .= '<th>Ville</th>';
        $contenu .= '<th>Code Postale</th>';
        $contenu .= '<th>Surface</th>';
        $contenu .= '<th>Prix</th>';
        $contenu .= '<th>photo</th>';
        $contenu .= '<th>Type de biens</th>';
        $contenu .= '<th>Description</th>';

    $contenu .= '</tr>';
    //debug($resultat);
    while ($bien = $resultat->fetch(PDO::FETCH_ASSOC)){
        

        $contenu .= '<tr>';

            foreach($bien as $indice => $information){
                if($indice == 'photo'){
                    $contenu .= '<td><img src="' . $information . '" style="width:90px"></td>';
                    
                } elseif($indice == 'description'){
                    $contenu .= '<td>'. couperMots($information, 20) .'</td>';
                }
                else{ 
                    $contenu .= '<td>' . $information  . '</td>';
                }
            } 


            $contenu .= '<td>';

                $contenu .= '<div><a href="description_logement.php?id_logement='. $bien['id_logement'] .'">Consulter le bien</a></div>';

            $contenu .= '</td>';


        $contenu .= '</tr>';
    }



$contenu .= '</td>';
$contenu .= '</table>';
$contenu .= '</div>';
require_once 'inc/header.php';

?>
<h1 class="mt-4 mb-4">Gestion des biens</h1>


<?php
echo $contenu;
require_once 'inc/footer.php';