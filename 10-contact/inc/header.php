<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>
<body>
    
    <header>
        
        <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
            <a class="navbar-brand text-danger font-weight-bold" href="<?php echo RACINE_SITE . 'index.php';  ?>">EXO</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link text-warning" href="<?php echo RACINE_SITE . 'formulaire.php';  ?>">Formulaire <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link text-warning" href="<?php echo RACINE_SITE . 'liste_contact.php';  ?>">Liste des contacts <span class="sr-only">(current)</span></a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li> -->
                    <?php 
                        if(estConnecte()){
                            //echo '<li><a href="'. RACINE_SITE. 'profil.php" class="nav-link">Profil</a></li>';
                           // echo '<li><a href="'. RACINE_SITE. 'connexion.php?action=deconnexion" class="nav-link">Se deconnecter</a></li>';
                        } else{
                            //echo '<li><a href="'. RACINE_SITE. 'formulaire.php" class="nav-link inline">Inscription</a></li>';
                            //echo '<li><a href="'. RACINE_SITE. 'connexion.php" class="nav-link">Connexion</a></li>';
                        }
                        //debug($_SESSION); 
                    ?> 
                </ul>
            </div>
        </nav>
        
    </header>
    <main class="container">
    