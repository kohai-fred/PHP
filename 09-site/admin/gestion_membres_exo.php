<?php

//-----------------------------------------------------
// Exercice :
//-----------------------------------------------------
/* 
    Vous créez la page de gestion des membres dans le back-boffice :
    1- Seul 1 administrateur doit avoir accès à cette page. Les autres membres sont redirigés vers la page de connexion.php.

    2- Afficher dans cette page, tous les membres inscrits  sur le site sous forme de table HTML, avec toutes les infos SAUF son mot de passe. Vous ajoutez à ce tableau une colonne "action". 

    3- Afficher le nombre membres inscrits.

    4- dans la colonne "action", ajouter un lien pour pouvoir supprimer un membre, sauf lui-même qui est connecté. 

    5- Dans la colonne "action", ajouter un lien pour pouvoir modifier le statut des membres en admin pour les membres ou en membre pour les admins. Le membre connecté ne peut pas modifier son propre statut.
*/
require_once '../inc/init.php';

// 1
if(!estAdmin()){
    header('location:../connexion.php');  // si le membre n'est pas admin, on le redirige sur la page de connexion.
    exit;
}

// 5
if(isset($_GET['id_membre'])){  // si existe id_produit dans l'URL c'est qu'on a demandé sa suppression.

    $resultat = executeRequete("DELETE FROM membre WHERE id_membre = :id_membre", array(':id_membre' => $_GET['id_membre']));

    //debug($resultat->rowCount());  // on obtient 1 lors de la suppression d'un ligne.

    if($resultat->rowCount() == 1){  // si le DELETE retourne une ligne c'est que la requête a bien marché.
        $contenu .= '<div class="alert alert-success">Le membre a bien été supprimé</div>';


    } else{  // sinon le DELETE retourne 0 ligne, c'est que l'id_produit n'est pas en BDD :
        $contenu .= '<div class="alert alert-danger">Le membre n\'a pas pu être supprimé</div>';

    }
}
/* if(isset($_GET['statut'])){

    debug($_GET);
} */

// 2

$resultat = executeRequete("SELECT * FROM membre");  // $resultat est un objet PDOStatement
//debug($resultat);


$contenu .= '<p class="mt-3">Nombre de membre inscrit : '. $resultat->rowCount() .' </p>';


$contenu .= '<div class="table-responsive">';
$contenu .= '<table class="table">';

    // Les entêtes du <table> :
    $contenu .= '<tr>';

        $contenu .= '<th>id_membre</th>';
        $contenu .= '<th>pseudo</th>';
        $contenu .= '<th>nom</th>';
        $contenu .= '<th>prenom</th>';
        $contenu .= '<th>email</th>';
        $contenu .= '<th>civilite</th>';
        $contenu .= '<th>ville</th>';
        $contenu .= '<th>code_postal</th>';
        $contenu .= '<th>adresse</th>';
        $contenu .= '<th>statut</th>';
        $contenu .= '<th>action</th>';

        
    $contenu .= '</tr>';
    
    /*     if(empty($_POST['statut'])){


        $succes = executeRequete("UPDATE membre (statut) VALUES (:statut)", array(':statut' => $_POST['statut'],));
    }
    debug($membre); */
    
    while ($membre = $resultat->fetch(PDO::FETCH_ASSOC)){
        debug($membre);

        $contenu .= '<tr>';

            foreach($membre as $indice => $information){ 
                if($indice == 'mdp'){ 

                } else{
                    $contenu .= '<td>' . $information  . '</td>';
                }
            } // fin de foreach
            
            // On ajoute les liens "action" :


            if($information == 0){

                //debug($membre);
                
                /* if(empty($_POST)){
                    //debug($_POST);
                    $requete = executeRequete("REPLACE INTO membre WHERE statut =:statut",array(':statut' => $_POST['statut']));
                } */

                
                $contenu .= '<td>';

                    $contenu .= '<div><a href="/PHP/09-site/inscription.php?id_membre='. $membre['id_membre'] .'">Modifier</a></div>';
                    $contenu .= '<div><a href="?id_membre='. $membre['id_membre'] .' " onclick="return(confirm(\'Etes-vous certain de supprimer ce produit ?\'))" >Supprimer</a></div>';
                    /* $contenu .=
                    "<form method='post'>
                        <div>
                            <select name='statut'>
                            <option>Statut</option>
                            <option <?php if(isset(\$membre_actuel[\'statut\']) && \$membre_actuel[\'statut\'] == \'0\') echo \'selected\'; ?> >0</option>
                            <option ";if(isset($membre_actuel['statut']) && $membre_actuel['statut'] == '1') echo 'selected';" >1</option>
                            <input type='submit' value='Changer le statut' class='btn mt-4'>
                            </select>
                        </div>
                    </form>"; */
                    $contenu .= '<form method="post">
                        <div>
                            <select name="statut">
                                <option>statut</option>
                                <option <?php if(isset($membre_actuel[\'statut\']) && $membre_actuel[\'statut\'] == \'0\') echo \'selected\'; ?> >0</option>

                                <option>1</option>
                                <input type="submit" value="Changer le statut" class="btn mt-4">
            
                            </select>
                        </div>
                        
                    </form>';
                        
                $contenu .= '</td>';
            } else{
                $contenu .= '<td>';

                    $contenu .= '<div><a href="/PHP/09-site/inscription.php?id_membre='. $membre['id_membre'] .'">Modifier</a></div>';

                    $contenu .= 
                    '<form method="post">

                        <div>
                            <select name="statut">
                                <option>statut</option>
                                <option <?php if(isset($membre_actuel[\'statut\']) && $membre_actuel[\'statut\'] == \'0\') echo \'selected\'; ?> >0</option>
                                <option>1</option>
                                <input type="submit" value="Changer le statut" class="btn mt-4">
            
                            </select>
                        </div>
                    
                    </form>';

                $contenu .= '</td>';
            }
                

            

        $contenu .= '</tr>';
    }



    $contenu .= '</td>';
    $contenu .= '</table>';
    $contenu .= '</div>';
    require_once '../inc/header.php';
?>
<h1 class="mt-4 mb-4 text-center">Gestion membre</h1>


<?php
echo $contenu;
require_once '../inc/footer.php';
