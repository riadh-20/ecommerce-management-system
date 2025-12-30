<?php

include '../components/connect.php';
session_start();

if(isset($_SESSION['ID_client'])){
   $ID_client = $_SESSION['ID_client'];
}
if(isset($_POST['submit'])){

   $nom = $_POST['nom'];
   $email = $_POST['email'];
   $pass = ($_POST['pass']);
   $cpass = ($_POST['cpass']);
   $prenom = ($_POST['prenom']);
   $numT = ($_POST['numT']);
   $typeV = ($_POST['typeV']);
   $typeContra = ($_POST['typeContra']);
   $numComptB = ($_POST['num_compteB']);
   $sex = $_POST['sex'];
   






   $select_admin = $conn->prepare("SELECT * FROM `compte` WHERE email = ?");
   $select_admin->execute([$email]);

   if($select_admin->rowCount() > 0){
      $message[] = 'username already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `demande_livreur`( `email`,`nom`, `num_tel`, `num_comptB`, `prenom`, `sexe`, `type_vehicule`, `type_contra`, `etat_demande`,`password`) VALUES (?,?,?,?,?,?,?,?,?,?)");
         $insert_admin->execute([$email, $nom ,$numT,$numComptB,$prenom,$sex,$typeV,$typeContra,'en march',$cpass]);

         


      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<section class="form-container">


   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="nom" required placeholder="entrer nom" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="prenom" required placeholder="entrer prenom" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="numT" required placeholder="entrer nunero de Telephone" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="typeV" required placeholder="typeV" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="sex" required placeholder="entrer sex" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="typeContra" required placeholder="entrer type contra" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="num_compteB" required placeholder="numero compte boncare" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="email" required placeholder="email" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">




      <input type="password" name="pass" required placeholder="entrer MotDePasse" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      
      <input type="password" name="cpass" required placeholder="confirmer MotDePasse " maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>