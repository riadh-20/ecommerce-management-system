<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';               
      }
   }
?>

<header class="header">

   <section class="flex">

      <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php">home</a>
         <a href="../admin/magasin_accounts.php">magasin</a>
         <a href="../admin/admin_accounts.php">admins</a>
         <a href="../admin/client_accounts.php">client</a>
         <a href="../admin/livreurs_accounts.php">livreur</a>
         
         <a href="../admin/messages.php">messages</a>
         <a href="../admin/gerre_Magasin.php">demmande magasin</a>
         <a href="../admin/gerre_livreur.php">demmande livreur</a>

      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
      <?php
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

            $select_compte = $conn->prepare("SELECT * FROM `compte` WHERE Id_compte = ?");
            $select_compte->execute([$fetch_profile['Id_compte']]);
            $fetch_compte = $select_compte->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="../admin/update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="../admin/register_admin.php" class="option-btn">register</a>
            <a href="login.php" class="option-btn">login</a>
         </div>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
      </div>

   </section>

</header>