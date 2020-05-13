<!--***************************************************** JOUR 1/12 ********************************************-->
<style>
    body{
        margin-bottom: 400px;
    }

    h2{
        border-top: 1px solid;
        border-bottom: 1px solid;
    }

    td{
        border: 1px solid;
        border-color: red;
        
    }
    table{
        border-collapse: collapse;
    }
</style>

<?php

//--------------------------------------------------------------------------
echo '<h2> Les balises PHP </h2>';  // echo pour afficher dans le navigateur
//--------------------------------------------------------------------------
?>

<?php
// pour ouvrir un passage en PHP, on utilise la balise précédente
// pour fermer un passage en PHP, on utilise la balise suivante :
?>

<p>Bonjour en HTML</p> <!-- en dehors des balises d'ouverture et de fermeture du PHP, je suis en HTML (possible car nous sommes dans un fichier avec une extension .php) -->

<?php
// Vous n'êtes pas obligé de fermer un passage en PHP à la fin du script.

// pour faire un commantaire sur 1 ligne
# pour faire un commantaire sur 1 ligne

/* 
    pour faire des commentaires 
    sur plusieurs 
    lignes
*/


//--------------------------------------------------------------------------
echo '<h2> Affichage </h2>';
//--------------------------------------------------------------------------

// echo est une instruction qui permet d'effectuer un affichage. Nous pouvons y mettre du code html sour forme de 'string'.

print 'Nous sommes mercredi <br>';  // print est une autre instruction pour afficher dans le navigateur.

// Il existe deux autres instruction d'affichage que nous utiliserons plus loin :
print_r('code'); echo '<br>';  // l'echo me sert juste a faire une mise à la ligne.
var_dump('code'); // ces deux instructions sont l'équivalent d'un "console.log" directement dans le navigateur. Elles permettrons d'analyser par exemples le contenu d'une variable, d'un tableau, d'un objet...


//--------------------------------------------------------------------------
echo '<h2> Variable </h2>';
//--------------------------------------------------------------------------
// Une variable est un espace mémoire qui porte un nom et qui permet de conserver une valeur.

// En PHP on représente une variable avec le signe "$". 

$a = 127;  // on déclare la variable a et lui affecte la valuer 127 evc le signe "=". 

echo gettype($a);  // gettype est une fonction prédéfinie qui permet de voir le type d'une variable. Ici il s'agit d'un entier appelé INTEGER.

echo '<br>';

$a = 1.5;
echo gettype($a); // il s'agit d'un DOUBLE ou encore FLOAT pour nombre à virgule.
echo '<br>';

$a = 'une chaîne de caractères';
echo gettype($a);  // STRING pour chaîne de caractères
echo '<br>';
$a = '127';  // un nombre écrit dans des quotes ou des guillemets est interprété comme un STRING.
echo gettype($a);
echo '<br>';

$a = true;  // ou alors false
echo gettype($a);   // BOOLEAN pour le type booléen
echo '<br>';

// Par convention, un nom de VARIABLE commence par une MINUSCULE, puis une MAJUSCULE à chaque mot qui le compose. Il peut contenir des chiffres (jamais au début) ou un "_" (pas au début ni à la fin).
// Exemple : $maVariable1


//--------------------------------------------------------------------------
echo '<h2> Concaténation </h2>';
//--------------------------------------------------------------------------
// En php on concatène (= faire suivre) les éléments avec le ".".

$x = 'Bonjour ';
$y = 'tout le monde!';

echo $x . $y . '<br>';  // ici on concatène 2 variables puis un string.


//----------------
// Concaténation lors de l'affectation avec l'opérateur combiné ".="
$prenom = 'Nicolas';
$prenom .= '-Marie';    // Avec l'opérateur ".=" on ne remplace pas la valeur "Nicolas" par la valeur "-Marie", mais on les ajoute l'une à l'autre.
echo $prenom . '<br>';  // Affiche Nicolas-Marie.


//--------------------------------------------------------------------------
echo '<h2> Guillemets et Quotes </h2>';
//--------------------------------------------------------------------------
$message = "aujourd'hui";
$message = 'aujourd\'hui';  // on échappe l'apostrophe écrit dans des quotes simples, avec le "\" (AltGR + 8).

$txt = 'Bonjour';
echo "$txt tout le monde <br>"; // dans les Guillemets, la variable est évaluée : c'est son contenu qui est affiché.
echo '$txt tout le monde <br>'; // dans les Quotes simples, tout devient du texte brut, c'est donc le nom de la variable qui est affiché.


//--------------------------------------------------------------------------
                    echo '<h2> Constante </h2>';
//--------------------------------------------------------------------------
// Une Constante permet de conserver une valeur sauf que celle-ci ne peut pas changer. C'est-à-dire qu'on ne pourra lui donner une autre valeur durant l'exécution du script. Utile pour conserver de manière certaine les paramètres de connexion à la BDD.
// Exemple :

define('CAPITALE_FRANCE', 'Paris'); // on déclare la constante CAPITALE_FRANCE et lui affect la valeur "Paris". Par convention on écrit toujours les constantes en MAJUSCULES.
echo CAPITALE_FRANCE . '<br>';  // affiche Paris.

// Autre syntax :
const TAUX_CONVERSION = 6.55957;    // on peut aussi déclarer une constante avec le mot clé const.
echo TAUX_CONVERSION . '<br>';  // affiche 6.55957

// Quelques constantes dites "magiques" :
echo __DIR__ . '<br>';  // affiche le chemin complet du dossier dans lequel se trouve ce script.
echo __FILE__ . '<br>'; // affiche le chemin complet du fichier dans lequel se trouve ce script.

// Exercice :
// afficher Bleux-Blanc-Rouge en affectant le texte de chacune des couleurs à une variable.
$couleur = "Bleu";
$couleur .= "-Blanc";
$couleur .= "-Rouge";
echo $couleur . '<br>';

$couleur = "Bleu";
$couleur1 = "-Blanc";
$couleur2 = "-Rouge";
echo $couleur . $couleur1 . $couleur2 . '<br>';

echo "$couleur $couleur1 $couleur2 <br>";


//--------------------------------------------------------------------------
                    echo '<h2> Opérateurs arithmétiques </h2>';
//--------------------------------------------------------------------------

$a = 10;
$b = 2;

echo $a + $b . '<br>';  // 12
echo $a - $b . '<br>';  // 8
echo $a * $b . '<br>';  // 20
echo $a / $b . '<br>';  // 5
echo $a % $b . '<br>';  // 0 (MODULO reste de la division entière). ex: 3 % 2 = 1

//----------
// Opérateurs arithmétiques combinés : 
$a = 10;
$b = 2;

$a += $b;   // équivaut à $a = $a + $b. On ajoute la valeur de $b à la valeur déjà présente dans $a. À la fin de l'opération $a vaut 12.
$a -= $b;   // équivaut à $a = $a - $b. À la fin de l'opération $a vaut 10.

// Il existe aussi les opérateurs combinés *=   /=  %=
// On utilise fréquemment le += et le -= dans les paniers d'achat par exemple ($quantiteProduit += $quantiteAjoute).

//-----------
// Incrémenter et décrémenter :
$i = 0;

$i++;   // incrémentation = ajouter 1
$i--;   // décrémentation = retrancher 1

$i = 0;
$k = ++$i;  // la variable $i est d'abord incrémentée, puis on affecte le résultat à $k. $k vaut donc 1.
echo '$i vaut ' . $i . '<br>';  // 1
echo '$k vaut ' . $k . '<br>';  // 1

$i = 0;
$k = $i++;  // on affecte d'abord la variable $i à $k, puis on incrémente $i. $k vaut donc 0.
echo '$i vaut ' . $i . '<br>';  // 1
echo '$k vaut ' . $k . '<br>';  // 0

// Même logique avec $i-- et --$i.


//--------------------------------------------------------------------------
                    echo '<h2> Structures conditionnelles </h2>';
//--------------------------------------------------------------------------
$a = 10;
$b = 5;
$c = 2;

// if ... else

if($a > $b){ // si la condition est évaluée à TRUE, c'est-à-dire si $a est supérieur à $b, on exécute les accolades qui suivent:
    echo '$a est strictement supérieur à $b <br>';
} else {    // sinon, dans le cas contraire on exécute le else :
    echo 'Non, c\'est $b qui est supérieur à $a <br>';
}




//------
// L'opérateur AND qui sécrit && :

if($a > $b && $b > $c){ // si $a est supérieur à $b et que dans le même temps $b est supérieur à $c, on exécute les accolades qui suivent :
    echo 'Vrai pour les deux conditions <br>';
}

// TRUE && TRUE => TRUE
// FALSE && FALSE => FALSE
// TRUE && FLASE => FALSE




//------
// L'opérateur OR qui s'écrit || :
if($a == 9 || $b > $c){ // si $a est égale (==) à 9 OU (||) alors que $b est supérieur à $c, on entre dans les accolades qui suivent :
    echo 'Vrai pour au moins une des deux conditions <br>';
} else{   // sinon c'est que les deux conditions sont fausses :
    echo 'Les deux conditions sont fausses <br>';
}

// TRUE || TRUE => TRUE
// FALSE || FALSE => FALSE
// TRUE || FALSE => TRUE




//------
// if ... elseif ... else :

$a = 10;
$b = 5;
$c = 2;    

if($a == 8){    // si $a égale à 8 :
    echo 'réponse 1 : $a est égale à 8 <br>';
} elseif($a != 10){   // si $a est différent de 10 :
    echo 'réponse 2 : $a est différent de 10 <br>';
} else{   // sinon je tombe ici si aucune des conditions précédente est vraie :
    echo 'réponse 3 : les conditions précédentes sont fausses <br>';
}



//------
// Lopérateur XOR pour le OU EXCLUSIF : 
// TRUE XOR TRUE => FALSE
// FALSE XOR FALSE => FALSE
// TRUE XOR FALSE => TRUE

$question1 = 'mineur';  // réponse de l'internaute à la question 1
$question2 = 'je vote'; // seconde réponse du même internaute

if($question1 == 'mineur' XOR $question2 == 'je vote'){
    echo 'Vos réponses sont cohérentes <br>';
} else{
    echo 'Vos réponses ne sont pas cohérentes <br>';
}



//------
// Forme contractée dite "tenaire" :
// Il s'agit d'une autre syntaxe du if ... else.
$a = 10;

echo ($a == 10 ) ? '$a est bien égale à 10 <br>' : '$a est différent de 10 <br>';
// Il faute retenir que le "?" remplace "if" et que le ":" remplace "else". 



//------
// Comaparaison avec "==" et "===" :
$varA = 1;  // integer
$varB ='1'; // string

if($varA == $varB){ // on compare en valeur uniquement : la condition est vraie
    echo '$varA est égal à $varB en valeur <br>';
}

if($varA === $varB){    // on compare à la fois en valeur ET en type : la condition est fausse (on un integer vs un string)
    echo '$varA est strictement égal à $varB en valeur ET en type <br>';
} else{
    echo '$varA est différent de $varB en valeur OU en type <br>';
}



//------
// isset() et empty()
// empty() est une fonction qui vérifie si c'est vide : 0, '' (string vide), NULL, FALSE, ou non défini.
// isset() est une fonction qui vérifie si ça existe (défini) ET a une valeur non NULL.

$var1 = 0;
$var2 = '';

if(empty($var1)){   // condition vraie car $var1 contient 0
    echo '$var1 est vide (0, ", NULL, FALSE ou non définie) <br>';
}

if(isset($var2)){   // condition vraie car $var2 est bien défini et n'est pas NULL
    echo '$var2 existe et est non NULL <br>';
}

// Si on ne déclare pas les variables $var1 et $var2, empty($var1) rest TRUE car la variable n'existe pas, mais isset($var2) devient FALSE car la variable n'est pas déclarée.

// Utilisation : empty pour vérifier si un champ de formulaire est rempli. isset pour vérifier l'existance d'une variable avant de l'utiliser.



//------
// l'opérateur NOT qui s'écrit "!" :
$var3 = 'quelque chose';

if(!empty($var3)){  // NOT est une négation. Ici il s'ignifie si $var3 n'est pas vide, auquel cas on entre dans lacondition :
    echo '$var3 n\'est pas vide <br>';
}

// !TRUE => FALSE
// !FALSE => TRUE
// L'opérateur NOT inverse le sens du booléen.


//------
// phpinfo();   // pour voir la version de PHP
// PHP7 - afficher une variable si elle existe avec l'opérateur "??" (Null coalescent):

echo $maVar ?? 'valeur par défaut'; // on affiche le contenu $maVar si elle existe, sinon on affiche le string qui suit. On prend la PREMIERE valeur qui existe.

// Exemple d'utilisation : pour mettre les valeurs saisies par l'internaute dans les champs de formulaire.



//--------------------------------------------------------------------------
                    echo '<h2> Condition switch </h2>';
//--------------------------------------------------------------------------
// La condition switch est une autre syntax pour écrire une condition if ... elseif ... else quand on veut comparer une variable à une multitude de valeurs.

$langue = 'chinois';

switch ($langue){
    case 'français' :   // oncompare $langue à la vavaleur des "case" et exécute le code qui suit si elle correspond.
        echo 'Bonjour !';
    break;  // obligatoir pour quitter la condition une fois un "case" exécuté.
    case 'italien' :
        echo 'Ciao !';
    break;
    case 'espagnol' :
        echo 'Hola !';
    break;
    default :   // cas par défaut dans lequel on entre si aucun des "case" précédents n'est exécuté.
        echo 'Hello ! <br>';
    break;
}


// Exercice :
// Vous ré-écrivez ce switch sous forme de if... dans l'objectif d'obtenir le même résultat.

if($langue == 'français'){
    echo 'Bonjour !';
} elseif($langue == 'italien'){
    echo 'Ciao !';
} elseif($langue == 'espagnol'){
    echo 'Hola !';
} else{
    echo 'Hello ! <br>'; 
}



//--------------------------------------------------------------------------
                    echo '<h2> Quelques fonctions prédéfinies </h2>';
//--------------------------------------------------------------------------
// Une fonction prédéfinie permet de réaliser un traitement spécifique qui est prédéterminé dans le langage PHP.

// strpos() :
$email1 = 'prenom@site.fr';
echo strpos($email1, '@');  // indique la position 6 de '@' dans $email1 (on compte à partir de 0).

echo '<br>';

$email2 = 'bonjour';
echo strpos($email2, '@');  // cette ligne n'affiche rien, pourtant la fonction retourne bien quelque chose : FALSE.
var_dump(strpos($email2, '@')); // grâce au var_dump on aperçoit le FALSE que retourne la fonction. var_dump est donc un fonction d'affichage améliorée que l'on utilise en phase de développement.

echo '<br>';

//------
// strlen() :
$phrase = 'une phrase ici';
echo strlen($phrase);   // affiche 14 : strlen() retourne la taille d'une chaîne ne nombre d'octets (un caractère accentué valant 2 octets).

echo '<br>';

//------
// substr() :
$texte = 'Ici un très long text...............';
echo substr($texte, 0, 5) . '...<a href="#">Lire la suite</a>'; //substr() retourne une partie du texte coupé de la position 0 juqu'à la position 5.

echo '<br>';

//------
// strtolower(), strtoupper(), trim :
$message = '      Hello World !            ';
echo strtolower($message) . '<br>';  // On affiche tout en minuscule
echo strtoupper($message) . '<br>';  // On affiche tout en majuscule

echo strlen($message) . '<br>'; // On compte avec les espaces
echo strlen(trim($message)) . '<br>';  // trim() retourne $message sans les espaces au début et à la fin, puis on compte les octets contenus dans cette nouvelle chaîne de caractères (13).


//------
// Le manuel PHP :
// https://www.php.net/manual/fr/
// https://www.php.net/


/************************************************** JOUR 2/12 **************************************************/

//--------------------------------------------------------------------------
                    echo '<h2> Fonctions utilisateur </h2>';
//--------------------------------------------------------------------------
// Une fonctions est un morceau de code encapsulé dans des accolades et portant un nom. On appelle la fonction au besoin pour exécuter le code qui s'y trouve.

// Quand on crée des fonctions, dans le but de ne pas se répéter, on parle de FACTORISER son code. 

//------
// Les fonctions qui ne sont pas prédéfinie, sont d'abord déclarées puis exécutées par l'utilisateur.

// Déclaration d'une fonction :
function ligne(){   // ici on déclare une fonction sans paramètre. Cependant les () sont obligatoires.
    echo '<hr>';
}

// Appel de la fonction pour l'exécuter :
ligne();    // on appelle une fonction en écrivant son nom suivi d'une paire de ().

//------
// Fonction avec paramètres et return :
function bonjour($prenom, $nom){    // $prenom et $nom sont des paramètres de la fonction. Ils permettent de recevoir un valeur car ce sont des variables de réception.
    
    return "Bonjour $prenom $nom ! <br>";   // return permet de retourner (renvoyer) ce qui est écrit après le return à l'endroit où la fonction est appelée.
    echo 'cette ligne ne sera pas exécutée !';  // après un return les instructions ne sont pas exécutées (on a quitté la fonction).
}

// Appel de la fonction :
echo bonjour('John', 'Doe' );   // si la fonction possède des paramètres, il faut lui envoyer des valeurs dans le même ordre. Ces valeurs s'appellent des "arguments". Quand il n'y a pas de echo dans la fonction et que l'on souhaite afficher, il faut faire un echo avant l'appel de cette fonction.

$prenom = 'Pierre';
$nom = 'Quiroule';
echo bonjour($prenom, $nom);    // on peut remplacer les arguments par des variables.

// Exercice :
// Écrivez une fonction "multiplication" qui retourne le calcul d'un nombre 1 par un nombre 2. Vous appelez cette fonction et vous affichez son résultat.

function multiplication($num1, $num2 = 1){  // on peut rendre un paramètre optionnel si l'on ne reçoit pas de valeur lui correspondant. Pour cela on l'initialise en lui affectant une valeur par defaut (ici 1 pour $nombre2).
    return $num1*$num2;
}

echo multiplication(2,2) . '<br>';
echo multiplication(10) . '<br>'; 

// Exercice :
echo '<p>EXERCICE</p>';
function meteo($saison, $temperature){
    echo "Nous sommes en $saison et il fait $temperature degré." . '<br>'; 
}

meteo('hiver', 10);
meteo('printemps', 1);

echo "<p>ENONCÉ : au sein d'une nouvelle fonction exoMeteo, vous affichez la même phrase avec l'article au/en selon la saison, <br> et en ajoutant le S à degré quand la température est au pluriel (inférieur à -1 ou supérieur à +1).</p>";
// Enoncé : au sein d'une nouvelle fonction exoMeteo, vous affichez la même phrase avec l'article au/en selon la saison, et en ajoutant le S à degré quand la température est au pluriel (inférieur à -1 ou supérieur à +1).


echo '<p>CORRECTION :</p>';


function corMeteo($saison, $temperature){
        
    if($saison == 'printemps'){
        $article = 'au';
    } else{
        $article = 'en';
    }

    if($temperature <-1 || $temperature >1){
        $degre ='degrés';
    } else {
        $degre = 'degré';
    }

    echo "Nous sommes $article $saison et il fait $temperature $degre." . '<br>'; 
}

corMeteo('hiver', 10);
corMeteo('printemps', 0);

echo '<hr>';
//------
// PHP7 - On peut préciser en amont le type des valeurs entrantes dans un fonction :
function identite(string $nom, int $age){   //array, bool, float, int, string
    echo gettype($nom) . '<br>';
    echo gettype($age) . '<br>';

    return "$nom a $age ans.";
}

echo identite('Asterix', 60) . '<hr>';   // le type des arguments est respecté, il n'y a donc pas d'erreur

echo identite('Asterix', '60') . '<hr>';    // ici il n'y a pas d'erreur car le string '60' a pu être casté (=changer de type) en integer par la fonction.
//echo identite('Asterix', 'soixante') . '<hr>';  // ici nous obtenon un "fatal error" car on passe un string qui ne peut pas être transformé en integer. Le script s'arrête.


// PHP7 - On peut préciser en amont le type de la valeur de retour de la fonction :
function isAdult(int $age) : bool { // array, bool, float, int, string
    if($age >= 18){
        return true;
    } else{
        return false;
    }
}

var_dump(isAdult(27));  // true pour 27, false pour 7


//--------------------------------------------------------------------------
                    echo '<h2> Espace (scope) global et espace local </h2>';
//--------------------------------------------------------------------------

// De l'espace local vers l'espace global :
echo "<p>De l'espace local vers l'espace global :</p>";
function jourSemaine(){
    $jour = 'jeudi';    // variable local car déclarée dans l'espace local de la fonction.
    return $jour;   // return permet de sortir une valeur de la fonction.
}

//echo $jour;   // erreur car cette variable n'existe que dans l'espace de la fonction jourSemaine().
echo jourSemaine() . '<hr>'; // on récupère la valeur retournée par le return de la fonction en l'appelant et on l'affiche : jeudi.

//-------
// De l'espace global vers l'espace local :
echo "<p>De l'espace global vers l'espace local :</p>";

$pays = 'France';   // variable globale car déclarée dans l'espace global (hors de toute fonction).

function affichePays(){
    global $pays;   // le mot clé "global' permet de récupérer une variable globale au sein de l'espace local de la fonction.
    echo $pays;
}
affichePays() . '<hr>';


//--------------------------------------------------------------------------
                    echo '<h2> Structure itératives </h2>';
//--------------------------------------------------------------------------
// Les boucles sont destinées à répéter des lignes de codes de façon automatique.

// Boucle while :
echo "<p>Boucle while :</p>";
$i = 0; // valeur de départ de la boucle

while($i < 3){  // tant que $i est inférieur à 3 nous entrons dans la boucle
    echo $i . '-----';
    $i++;   // incrémentation effectuée à chaquetour pour varier la valeur de $i et permettre à la condition du 'while' de devenir 'false' à un moment donné (sinon la boucle est infinie).
}

echo '<br>';
// Exercice
echo "<p>EXERCICE <br> ENONCE : à l'aide d'une boucle while, afficher dans un menu déroulant les années de 1920 à 2020.</p>";

echo '<select>';
    echo '<option>1920</option>';
    echo '<option>...</option>';
    echo '<option>2020</option>';
echo '</select>';
echo '<br><p>Résultat</p>';
$annee = 1920;
echo '<select>';

    while($annee <= 2020){
        echo '<option>'.$annee.'</option>';
        $annee++;
    }

echo '</select>';
echo '<hr>';


// Avec une fonction (BONUS):

/* function calcYears($debut, $fin){
    echo '<select>';
    while($debut <= $fin){
        echo '<option>' . $debut . '</option>';
        $debut++ ;
    }
    echo '</select>';
}

calcYears(1990, 2020) . '<br>'; */

//------
// Boucle do while :
// La boucle do while a la particularité de s'exécuter au moins une fois, puis tant que la condition est vraie.
echo "<p>Boucle do while :</p>";

$j = 0;

do {
    echo 'Je fais un tour de boucle !';
    $j++;
} while($j > 10);   // la condition de retour dans la boucle renvoie false tout de suite, et pourtant la boucle a bien tourné une fois. Note : ATTENTION au ";" à la fin du while.
echo '<hr>';


//------
// La boucle for :
// La boucle for est une autre syntaxe de la boucle while.
echo "<p>La boucle for :</p>";

for ($i = 0; $i < 3; $i++){ // on trouve directement dans les () de la for : (valeur de départ de $i; condition d'entrée dans la boucle; incrémentation ou décrémentations)
    echo $i . '----';
}
echo '<br>';

// Exercice : afficher les mois 1 à 12 dans un menu déroulant à l'aide d'une boucle for.

echo '<select>';

    for ($i = 0; $i <= 12; $i++){ 
        echo '<option>' . $i . '</option>';
    }

echo '</select>';

echo '<hr>';

//------
// Il existe la boucle foreach que nous aborderons au chapitre des tableaux qu'elle sert à parcourir.

//--------------------------------------------------------------------------
                    echo '<h2> Exercices de mélange PHP et HTML </h2>';
//--------------------------------------------------------------------------

// Exercice 1 : Faites une boucle for qui affiche de 0 à 9 sur la même ligne.

for($i=0; $i<=9; $i++){
    echo $i;
}

// Exercice 1 : Faites une boucle for qui affiche de 0 à 9 sur la même ligne. dans une table HTML. Vous faites du CSS dans la balise <style> pour y mettre une bordure.

/* echo '<table>';

    echo '<tr>';    // ligne

        echo '<td>1</td>';  // cellule de donnée
        echo '<td>2</td>';
        echo '<td>3</td>';

    echo '</tr>';

echo '</table>';
*/

echo '<table>';

    echo '<tr>';  

        for($i=0; $i<=9; $i++){
            echo '<td>' . $i . '</td>';
        }

    echo '</tr>';

echo '</table>';


//--------------------------------------------------------------------------
echo '<h2> Tableau (array) </h2>';
//--------------------------------------------------------------------------
// Un tableau, ou array en anglais, est déclaré comme une vraiable améliorée dans laquelle on stocke une multitude de valeurs. Ces valeurs peuvent être de n'importe quel type et possède un indice par défaut dont la numérotation commence par 0.

// Contexte : bien souvent on récupère les informations de la BDD sous forme de tableau (ou éventuellement d'objet).

// Déclarer un array (méthode 1) :
$liste = array('Grégoire', 'Nathalie', 'Emilie', 'François', 'George');

//echo $liste;    // on a une erreur de type "array to string conversion" car on ne peut pas afficher directement un array dans son intégralité.
echo '<pre>';
    var_dump($liste);   //affiche le contenu du tableau plus certaines infos comme le type des éléments.
echo '</pre>';

echo '<pre>';
    print_r($liste);    // print_r est moins analytique que le var_dump.
echo '</pre>';  // cette balise permet de preformater l'affichage du print_r ou var_dump.


// On se crée une fonction personnelle pour faire des print_r : 
function debug($variable){
    echo '<pre>';
        print_r($variable);
    echo '</pre>';
}

// Autre façon de déclarer un array (méthode 2) :
$tab = ['France', 'Italie', 'Espagne', 'Portugal'];

// Afficher "Italie" depuis notre tableau $tab :
echo $tab[1] . '<br>';  // on accède à une valeur en écrivant le nom du tableau suivi de l'indice de cette valeur écrit entre []. Affiche Italie.

// Ajouter une valeur à la fin d'un tableau :
$tab [] = 'Suisse'; // les [] vides permettent d'ajouter une valeur à la fin du tableau $tab.

debug($tab);    // pour véifier


//------
// Tableau associatif :
// Dans un tableau associatif, nous pouvons choir le nom des indices.
$couleurs = array(
    'j' => 'jaune',
    'b' => 'bleu',
    'v' => 'vert'
);

debug($couleurs);

// Pour accéder à un élément d'un tableau associatif :
echo 'La seconde couleur du tableau est le ' . $couleurs['b'] . '<br>';
echo "La seconde couleur du tableau est le $couleurs[b] <br>";  // affiche bleu. Un array écrit dans des "guillemets" ou des quotes perd les quotes autour deson indice.

// Mesurer le nombre d'éléments qui constituent un tableau :
echo 'Taille du tableau $couleurs : ' . count($couleurs) . '<br>';  // affiche 3 car il y a 3 éléments dans notre tableau.
echo 'Taille du tableau $couleurs : ' . sizeof($couleurs) . '<br>'; // sizeof() est pareil que count() dont il est un alias.


//--------------------------------------------------------------------------
                    echo '<h2> Boucle foreach pour les tableaux </h2>';
//--------------------------------------------------------------------------
// foreach est un moyen simple de parcourir un tableau de façon automatique. Cette boucle ne fonctionne que sur les tableaux et les objets, et genère une erreur si vous l'utiliser sur une variable d'un autre type.

debug($tab);

foreach($tab as $pays){ // on parcours le tableau $tab en affectant chaque valeur à $pays à chaque tour de boucle. Le mot "as" fait partie de la structure et est obligatoire.

    echo $pays . '<br>';    // $pays prend la valeur France au 1er tour, puis Itallie au second, et ainsi de suite. 
}
echo '<hr>';

foreach($tab as $indice => $pays){  // quand il y a deus variables, celle à quache de la flèche parcourt la colonne des indices, et celle à droite de la flèche parcourt la colonne des valeur.
    echo $indice . 'correspond à ' . $pays . '<br>';
}

//Exercice
// Écrivez un array associatif avec les indices prenom, nom, email et telephone et mettez y des valeurs pour un seul contact. Puis avec une boucle foreach, vous affichez les valeurs dans des <p>, sauf le prenom qui doit être un <h3>.
$tabMembre = [

    'prenom' => 'John',
    'nom' => 'Doe',
    'email' => 'johndoe@gmail.com',
    'tel' => '0601020304',
];

debug($tabMembre);

foreach($tabMembre as $indice => $membre){
    if ($indice == 'prenom'){
        echo  $indice . '<h3>' . $membre . '</h3>';
    } else{
        echo $indice . '<p>' . $membre . '</p>';
    }
}

/************************************************** JOUR 3/12 **************************************************/


//--------------------------------------------------------------------------
                    echo '<h2> Tableau multidimensionnel </h2>';
//--------------------------------------------------------------------------

// Nous parlons de tableau multidimensionnel quand un tableau est contenu dans un autre tableau. Chaque tableau représente une dimension.

// Création d'un tableau multidimensionnel:

$tab_multi = array(

    array(
        'prenom' => 'Goku',
        'nom' => 'Son',
        'telephone' => '0601020304',
    ),
    array(
        'prenom' => 'Naruto',
        'nom' => 'Uzumaki',
        'telephone' => '0145122356',
    ),
    array(
        'prenom' => 'Mireille',
        'nom' => 'Bouquet',
    ),

);

debug($tab_multi);

// Accéder à la valeur "Goku" :
echo $tab_multi[0]['prenom'] . '<br>';  // pour accéder à "Goku", nous entrons d'abord à l'indice [0] de $tab_multi pour aller ensuite dans le sous tableau à l'indice ['prenom'].

echo '<hr>';

// Nous pouvons parcourir ce tableau $tab_multi avec une boucle FOR car ses indices sont numériques :

for($i=0; $i < count($tab_multi); $i++) {   //tant que $i est inférieur au nombre d'éléments du tableau, ici 3. 
    echo $tab_multi[$i]['prenom'] . 'br';   // on affiche la valeur du tableau d'indice $i, qui varie successivement de 0 puis à 1 puis à 2.
}

echo '<hr>';

// Exercice :
//  Afficher les 3 prénoms de $tab_multi avec une boucle foreach.

foreach($tab_multi as $indice => $tableauInterne){
    //debug($tab_multi);
    echo  $tab_multi[$indice]['prenom'] . '<br>';
    //autre solution:
   // echo $tableauInterne['prenom'] . '<br>';
}

// Autre façon:
/* foreach ($tab_multi as $tableauInterne){
    // on voit que $tableauInterne est lui même un tableau qui possède un indice ['prenom'].
    echo $tableauInterne['prenom'] . '<br>';
    
} */


//--------------------------------------------------------------------------
                    echo '<h2> Inclusion de fichiers </h2>';
//--------------------------------------------------------------------------

// Quatre type d'inclusions :

echo 'Première inclusion : ';
include 'exemple.inc.php'; // le fichier est inclus comme si nous avion copié/collé son code ici.

echo '<br> Deuxième inclusion : ';
include_once 'exemple.in.php';  // la mention "once" permet de vérifier si le fichier a déjà été inclus. Si c'est le cas, il ne le ré-inclus pas. Evite par exemple d'inclure plusieurs fois les fonctions.

echo '<br> Troisième inclusion : ';
require 'exemple.inc.php';  // le fichier est "requis", donc obligatoire : en cas d'erreur lors de son inclusion, require génère une erreur de type "fatal error" qui stoppe l'exécution du script. "include" génère quant à lui une erreur de type "warning" quand la page peut pas être incluse, et poursuit l'exécution du script. 

echo '<br> Quatrième inclusion : ';
require_once 'exemple.inc.php'; // le "once" vérifie ici aussi si le fichier est déjà inclus. Si c'est le cas il ne le ré-inclut pas.

// La mention "inc" dans le nom du fichier inclus est un indicatif précisant aux ddéveloppeurs qu'il s'agit d'un fichier d'inclusion et non pas d'une page à part entière. Ce n'est pas obligatoire mais utile. In peut aussi mettre ces fichiers d'incusion dans un sous-dossier "inc" du projet.


//--------------------------------------------------------------------------
                    echo '<h2> Gestion des dates </h2>';
//--------------------------------------------------------------------------

// date() :
echo date('d/m/Y H:i:s');   // Retourne la date du jour selon le format spécifié : d = jour, m = month, Y = Year sur 4 chiffres, H = Hour, i = minute, s = seconde.

echo '<br>';

echo date('y/m/d'); // on peut changer l'ordre des arguments qui définissent le format. Ici y = year sur 2 chiffres.
echo '<br>';
//------
// time () :
// Le timestamp est le nombre de secondes écoulées entre une date et le 1er janvier 1970 à 00:00:00 (date informatique qui correspond à la création du système d'exploitation UNIX).

echo time();    // retourne le timestamp actuel (utile pour les cookies par exemple).
echo '<br>';

//------
// Changer le format d'une date : méthode procédurale
// strtotime() :
$timestamp = strtotime('04/17/2020');   // pour 17 avril 2020. strtotime() retourne le timestamp d'une date fournie au format anglais mois/jour/année.
echo $timestamp;
echo '<br>';

// strftime() :
$dateFormat = strftime('%d/%m/%Y', $timestamp); // retourne une date sous forme de string au format indiqué à partir du timestamp fourni. Ici on obtient 17/04/2020.
echo $dateFormat;   // affiche 17/04/2020.
echo '<br>';


//------
// Changer le format d'une date  : méthode objet
// Les fonctions strtotime() et strftime() sont limitées à 2038 (système 32bits), ce qui n'est pas le cas de l'approche objet.
// Pour les 64 bits la date est : dimanche 4 décembre 292 277 026 596 ap. J. -C.


$date = new DateTime('11-04-2017'); // on crée un objet $date pour la date du 11/04/2017.

echo $date->format('Y-m-d');    // on peut formater cet objet date avec sa méthode format() et en lui indiquant les parmètres du format de sortie, ici Y-m-d. Affiche 2017-04-11.



//--------------------------------------------------------------------------
                    echo '<h2> Introduction aux objets : </h2>';
//--------------------------------------------------------------------------
// Un objet est un autre TYPE de données. Il représente un objet réel (par exemple voiture, personnage, membre, panier, produit...) auquel on peut associer des variables, appelées PROPRIETES, et des fonctions, appelées METHODES.

// Pour créer des objets, il nous faut un "plan de construction" : c'est le rôle de la "CLASS".

// Nous créons pour l'exemple une classe pour fabriquer des meubles :
class Meuble {  // par convention les classes portent une Majuscule.
    public $marque ='ikea';  // $marque est une propriété. "public" permet de préciser qu'elle sera accessible partout, en particulier à l'extérieur de la "class".
    
    public function prix(){
        return rand(50, 200) . "€";  // tirage aléatoire d'un entier entre 50 et 200 auquel on concatène le sigle "€". 
    } 
}

$table = new Meuble();  // avec le mot clé "new" je créer un objet issu de la "class" Meuble. On dit "instancier" la "class Meuble". $table est donc de type objet.

debug($table);  // nous pouvons obsever le type "object", la "class" dont est issu notre objet, et sa propriété "marque" de valeur "ikea".

// Syntax objet en PHP :
echo 'Marque de la table : ' . $table->marque . '<br>';  // pour accéder à la propiété d'un objet, on écrit l'objet suivi d'une flèche "->" puis du nom de la propriété. Affiche ikea.

echo 'Prix de la table : ' . $table->prix() . '<br>';  // pour accéder à la "METHODE" d'un objet, on écrit le nom de l'objet suivi de la flèche "->" et du nom de la "METHODE" avec ses ().


//****************************************************************************

//echo '<br>';
/* echo "<p></p>"; */