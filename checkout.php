<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['ID_client'])){
   $ID_client = $_SESSION['ID_client'];
}else{
   $ID_client = '';
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `panier` WHERE ID_client = ?");
   $check_cart->execute([$ID_client]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `commande_client`(ID_client, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$ID_client, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `panier` WHERE ID_client = ?");
      $delete_cart->execute([$ID_client]);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $select_cart = $conn->prepare("SELECT id_pannier, montant_total, nbr_produit FROM `panier` WHERE id_compte = ?");
         $select_cart->execute([$ID_client]);
         $fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC);
         $total_products=$fetch_cart['nbr_produit'];
         $grand_total=$fetch_cart['montant_total'];

      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">grand total : <span>$<?= $grand_total; ?>/-</span></div>
      </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paytm">paytm</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. mumbai" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. maharashtra" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. India" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>