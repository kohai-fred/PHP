<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma boutique</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>
    <header>
        <!-- navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

            <div class="container">
                <!-- la marque -->
                <a href="<?php echo RACINE_SITE . 'index.php';  ?>" class="navbar-brand">MA BOUTIQUE</a>

                <!-- le menu -->
                <div class="collapse navbar-collapse" id="nav1">
                    <ul class="navbar-nav ml-auto">
                        <?php
                            echo '<li><a href="'. RACINE_SITE. 'index.php" class="nav-link">Boutique</a></li>';
                            if(estConnecte()){  // si le membre est connecté
                                echo '<li><a href="'. RACINE_SITE. 'profil.php" class="nav-link">Profil</a></li>';
                                echo '<li><a href="'. RACINE_SITE. 'connexion.php?action=deconnexion" class="nav-link">Se deconnecter</a></li>';
                            } else{  // le membre n'est pas connecté. 
                                echo '<li><a href="'. RACINE_SITE. 'inscription.php" class="nav-link">Inscription</a></li>';
                                echo '<li><a href="'. RACINE_SITE. 'connexion.php" class="nav-link">Connexion</a></li>';
                            }

                            echo '<li><a href="'. RACINE_SITE. 'panier.php" class="nav-link">Panier ('. numeroPanier() .')</a></li>';
                            
                            if(estAdmin()){  // si le membre est admin.
                                echo '<li><a href="'. RACINE_SITE. 'admin/gestion_boutique.php" class="nav-link">Gestion de la Boutique</a></li>';
                                echo '<li><a href="'. RACINE_SITE. 'admin/gestion_membres.php" class="nav-link">Gestion des membres</a></li>';
                            }

                        ?>
                    </ul>
                </div><!-- Fin menu -->
            </div><!-- Fin container -->
        </nav>
    </header>

    <!-- Contenu de la page -->
    <div class="container" style="min-height: 80vh">
        <div class="row">
            <div class="col-12">
                <!-- ici le contenu spécifique à chaque page -->