<?php

include 'components/connect.php';
session_start();

$message = []; // Initialize an empty array to store error messages

if(isset($_SESSION['ID_client'])){
   $ID_client = $_SESSION['ID_client'];
}

if(isset($_POST['submit'])){

   // Sanitize input data
   $nom = trim($_POST['nom']);
   $email = trim($_POST['email']);
   $pass = trim($_POST['pass']);
   $cpass = trim($_POST['cpass']);
   $prenom = trim($_POST['prenom']);
   $numT = trim($_POST['numT']);
   $date_N = trim($_POST['date_N']);
   $adress = trim($_POST['adress']);
   $sex = trim($_POST['sex']);
   
   // Check if email already exists
   $select_admin = $conn->prepare("SELECT * FROM `compte` WHERE email = ?");
   $select_admin->execute([$email]);

   if($select_admin->rowCount() > 0){
      $message[] = 'Email already exists!';
   }else{
      // Check if passwords match
      if($pass != $cpass){
         $message[] = 'Passwords do not match!';
      }else{
         // Insert data into 'compte' table
         $insert_compte = $conn->prepare("INSERT INTO `compte`(`mot_de_passe`, `email`, `etat_compte`) VALUES (?, ?, 'active')");
         $insert_compte->execute([$pass, $email]);
         
         // Get the ID of the inserted compte
         $id_compte = $conn->lastInsertId();

         // Insert data into the 'client' table
         $insert_client = $conn->prepare("INSERT INTO `client`(`nom`, `prenom`, `adresse`, `num_tel`, `date_naiss`, `sexe`, `Id_compte`) VALUES (?, ?, ?, ?, ?, ?, ?)");
         $insert_client->execute([$nom, $prenom, $adress, $numT, $date_N, $sex, $id_compte]);
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
   <title>Register Client</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<section class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>
      <?php
         // Display error messages, if any
         if(!empty($message)) {
            foreach($message as $msg) {
               echo "<p class='error'>$msg</p>";
            }
         }
      ?>
      <input type="text" name="nom" required placeholder="Enter Nom" class="box">
      <input type="text" name="prenom" required placeholder="Enter Prenom" class="box">
      <input type="text" name="numT" required placeholder="Enter Telephone Number" class="box">
      <input type="text" name="sex" required placeholder="Enter Sex" class="box">
      <input type="text" name="date_N" required placeholder="Enter Date de Naissance" class="box">
      <input type="text" name="adress" required placeholder="Enter Address" class="box">
      <input type="text" name="email" required placeholder="Enter Email" class="box">
      <input type="password" name="pass" required placeholder="Enter Mot de Passe" class="box">
      <input type="password" name="cpass" required placeholder="Confirm Mot de Passe" class="box">
      <input type="submit" value="Register Now" class="btn" name="submit">
   </form>
</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
