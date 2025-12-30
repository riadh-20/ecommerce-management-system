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

      <a href="home.php" class="logo">KinBech<span>.Com</span></a>

      <nav class="navbar">
         <a href="home.php">Home</a>
         <a href="about.php">About Us</a>
         <a href="orders.php">orders</a>
         <a href="shop.php">Shop Now</a>
         <a href="contact.php">Contact Us</a>
      </nav>

      <div class="icons">
         <?php
          
      
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE ID_client = ?");
            $count_wishlist_items->execute([$ID_client]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $select_cart = $conn->prepare("SELECT * FROM `panier` WHERE id_compte = ?");
$select_cart->execute([$ID_client]);

$fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC);

if ($fetch_cart) {
    $id_pannier = $fetch_cart['id_pannier'];
    
    $count_cart_items = $conn->prepare("SELECT * FROM `ligne_panier` WHERE id_panier = ?");
    $count_cart_items->execute([$id_pannier]);
    $total_cart_counts = $count_cart_items->rowCount();
} else {
    $total_cart_counts = 0;
}

         
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i>Search</a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `client` WHERE ID_client = ?");
            $select_profile->execute([$ID_client]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["nom"]; ?></p>
         <a href="update_user.php" class="btn">Update Profile.</a>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">Register.</a>
            <a href="login.php" class="option-btn">Login.</a>
         </div>
         <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
         <?php
            }else{
         ?> 
         <p>Please Login Or Register First to proceed !</p>
         <div class="flex-btn">
            <a href="registreAs.html" class="option-btn">Register</a>
            <a href="login.php" class="option-btn">Login</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>