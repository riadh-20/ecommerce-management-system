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

      <a href="../magasin/dashboard.php" class="logo">Magasin<span>Panel</span></a>

      <nav class="navbar">
         <a href="../magasin/dashboard.php">home</a>
         <a href="../magasin/products.php">products</a>
        

         <a href="../magasin/placed_orders.php">orders</a>
         
         <a href="../magasin/Completed_Orders.php">preperd Orders</a>
         <a href="../magasin/retour_Orders.php">retour Orders</a>
         <a href="../magasin/livred_Orders.php">livred Orders</a>



         
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
      <?php
            $select_profile = $conn->prepare("SELECT * FROM `magasin` WHERE Id_mag  = ?");
            $select_profile->execute([$id_mag]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

            $select_compte = $conn->prepare("SELECT * FROM `compte` WHERE Id_compte = ?");
            $select_compte->execute([$fetch_profile['Id_compte']]);
            $fetch_compte = $select_compte->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['nom']; ?></p>
         <a href="../magasin/update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="../admin/register_admin.php" class="option-btn">register</a>
            <a href="../admin/admin_login.php" class="option-btn">login</a>
         </div>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
      </div>

   </section>

</header>