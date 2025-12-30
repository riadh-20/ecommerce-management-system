<?php

include '../components/connect.php';





if(isset($_POST['submit'])){


   $nom = $_POST['nom'];
   $email = $_POST['email'];
   $mot_de_passe = $_POST['mot_de_passe'];
   $num_tel = $_POST['num_tel'];
   $num_compB = $_POST['num_compB'];
   $type_mag = $_POST['type_mag'];
   $num_Reg = $_POST['num_Reg'];
   $localisation = $_POST['localisation'];
   $nom_R_mag = $_POST['nom_R_mag'];
   $cpass = $_POST['cpass'];


   $select_admin = $conn->prepare("SELECT * FROM `compte` WHERE email = ?");
   $select_admin->execute([$email]);

   if($select_admin->rowCount() > 0){
      $message[] = 'username already exist!';
   }else{
      if($mot_de_passe != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `demande_magasin`(nom, email,mot_de_passe,num_tel,num_compB,type_mag,num_Reg,etat_demande,localisation,nom_R_mag) VALUES(?,?,?,?,?,?,?,?,?,?)");
         $insert_admin->execute([$nom, $email,$mot_de_passe,$num_tel,$num_compB,$type_mag,$num_Reg,'en march',$localisation,$nom_R_mag]);
         
         $message[] = 'new admin registered successfully!';
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
   <title>register magasin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<section class="form-container">

   <form action="" method="post">
      <h3>magasin register </h3>
      <input type="text" name="nom" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="email" required placeholder="enter your email" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="num_tel" required placeholder="numero Telepone" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="num_compB" required placeholder="numere compte Boncare " maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="type_mag" required placeholder="type magasin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="num_Reg" required placeholder="numero Register comerse" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="localisation" required placeholder="localisation" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="nom_R_mag" required placeholder="nom Responsable magasin" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="mot_de_passe" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">





      <input type="submit" value="register now" class="btn" name="submit">
      <p>already have an account?</p>
      <a href="magasin_login.php" class="option-btn">login now</a>
   </form>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>