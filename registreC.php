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
      echo'ppppppppppppppp';
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