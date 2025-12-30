<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];

   // Delete user query to delete the associated account
   $delete_user = $conn->prepare("DELETE FROM `compte` WHERE id_compte = ?");
   $delete_user->execute([$delete_id]);

   // Redirect to the current page after deleting the account
   header("Location: livreurs_accounts.php");
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>client accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">user accounts</h1>

   <div class="box-container">

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `laivreur`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_accounts['Id_livreur']; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['nom']; ?></span> </p>
      <?php
      $idcompte = $fetch_accounts['Id_compte'];
      $select_C = $conn->prepare("SELECT * FROM `compte` WHERE id_compte = ?");
      $select_C->execute([$idcompte]);
      $fetch_C = $select_C->fetch(PDO::FETCH_ASSOC);

      ?>
      <p> email : <span><?= $fetch_C['email']; ?></span> </p>
      <a href="livreurs_accounts.php?delete=<?= $fetch_C['id_compte']; ?>" onclick="return confirm('delete this account? the user related information will also be deleted!')" class="delete-btn">delete</a>

   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>