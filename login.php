<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

if(isset($_POST['submit'])){
   $email = $_POST['email'];
   $pass = $_POST['pass'];
   
   $select_id = $conn->prepare("SELECT id_compte FROM `compte` WHERE email = ? AND mot_de_passe = ?");
   $select_id->execute([$email, $pass]);
   
   if($select_id->rowCount() > 0){
      $row = $select_id->fetch(PDO::FETCH_ASSOC);
      
      $select_client = $conn->prepare("SELECT * FROM `client` WHERE Id_compte = ?");
      $select_client->execute([$row['id_compte']]);
      
      if($select_client->rowCount() > 0){
         $row = $select_client->fetch(PDO::FETCH_ASSOC);
         $_SESSION['ID_client'] = $row['ID_client'];
         header('location: home.php');
         exit;
      } else {
         $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE Id_compte = ?");
         $select_admin->execute([$row['id_compte']]);
         
         if($select_admin->rowCount() > 0){
            $row = $select_admin->fetch(PDO::FETCH_ASSOC);
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin/dashboard.php');
            exit;
         } else {
            $select_delivery = $conn->prepare("SELECT * FROM `laivreur` WHERE Id_compte = ?");
            $select_delivery->execute([$row['id_compte']]);
            
            if($select_delivery->rowCount() > 0){
               $row = $select_delivery->fetch(PDO::FETCH_ASSOC);
               $_SESSION['livreur_id'] = $row['Id_livreur'];
               header('location: livreur/commandeDisp.php');
               exit;
            } else {
               $select_store = $conn->prepare("SELECT * FROM `magasin` WHERE Id_compte = ?");
               $select_store->execute([$row['id_compte']]);
               
               if($select_store->rowCount() > 0){
                  $row = $select_store->fetch(PDO::FETCH_ASSOC);
                  $_SESSION['id_mag'] = $row['Id_mag'];
                  header('location: magasin/dashboard.php');
                  exit;
               } else {
                  echo "User not recognized.";
               }
            }
         }
      }
   } else {
      echo "Incorrect email or password.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<section class="form-container">
   <form action="" method="post">
      <h3>Login now</h3>
      <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login now" class="btn" name="submit">
      <p>Don't have an account?</p>
      <a href="user_register.php" class="option-btn">Register now</a>
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
