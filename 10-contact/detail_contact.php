<?php
/*
   1- Vous affichez le détail complet du contact demandé, y compris la photo. Si le contact n'existe pas, vous laissez un message. 

*/

require_once 'inc/init.php';

$_GET['id_contact'] = htmlspecialchars($_GET['id_contact'], ENT_QUOTES);

if(isset($_GET['id_contact'])){

   $resultat = $pdo->prepare("SELECT * FROM contact WHERE id_contact = :id_contact");
   $resultat->execute(array(':id_contact'=>$_GET['id_contact']));
   $contact = $resultat->fetch(PDO::FETCH_ASSOC);
}

//debug($contact);
require_once 'inc/header.php';

?>


<h3 class="my-5">Profil</h3>
<?php
if(!empty($contact)){


?>
<div class="mb-5">
   <div class="text-center">
      <img src="<?php echo $contact['photo'];  ?>" alt=""></img>
      <h1 class="font-weight-bold font-italic"><?php echo $contact['nom'].' '.  $contact['prenom']; ?></h1>
   </div>
</div>

<p><span class="font-weight-bold">ID</span> : <?php echo $contact['id_contact']; ?></p>
<p><span class="font-weight-bold">Tél</span> : <?php echo $contact['telephone'];  ?></p>
<p><span class="font-weight-bold">Email</span> : <?php echo $contact['email'];  ?></p>
<p><span class="font-weight-bold">Type de contact</span> : <?php echo $contact['type_contact'];  ?></p>


<?php
}else{

   echo '<p>Contact inexistant!</p>';
}
?>

<?php
require_once 'inc/footer.php';

//<p>Votre Nom : <?php echo $contact['nom']; </p>
//<p>Votre Prenom : <?php echo $contact['prenom']; </p>