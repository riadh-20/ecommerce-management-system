<?php

include '../components/connect.php';

session_start();

$id_mag = $_SESSION['id_mag'];

if (!isset($id_mag)) {
   header('location:../login.php');
   exit;
}

if (isset($_POST['update_payment'])) {
   $order_id = $_POST['order_id'];
   $payment_status = filter_var($_POST['payment_status'], FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `commande_client` SET etat_commande = ? WHERE id_commande = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'Payment status updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `commande_client` WHERE id_commande = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
   exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Placed Orders</title>

   <!-- Include Font Awesome for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
   <!-- Include custom admin styles -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
      .orders .box-container {
         display: flex;
         flex-direction: column;
         gap: 20px;
      }
      .orders .box {
         background: #fff;
         border-radius: 5px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
         padding: 20px;
         width: 100%;
         margin: 20px 0;
      }
      .orders .order-row {
         display: flex;
         flex-direction: row;
         justify-content: space-between;
         align-items: center;
         padding: 10px;
         border: 1px solid #ccc;
         margin-bottom: 10px;
         cursor: pointer;
      }
      .orders .order-row:hover {
         background: #f0f0f0;
      }
      .orders .order-row div {
         flex: 1;
         text-align: left;
         padding: 5px;
      }
      .orders .flex-btn {
         display: flex;
         gap: 10px;
         margin-top: 10px;
      }
      .accept, .reject, .option-btn, .delete-btn {
         padding: 5px 10px;
         border: none;
         border-radius: 3px;
         cursor: pointer;
      }
      .accept {
         background: #4CAF50;
         color: white;
      }
      .reject {
         background: #f44336;
         color: white;
      }
      .option-btn {
         background: #008CBA;
         color: white;
      }
      .delete-btn {
         background: #e7e7e7;
         color: black;
      }
   </style>

   <script>
      // Function to handle row click and redirect to order details page
      function goToOrderDetails(orderId) {
         window.location.href = 'order_details.php?id=' + orderId;
      }
   </script>

</head>
<body>

<?php include '../components/magasin_header.php'; ?>

<section class="orders">

<h1 class="heading">Placed Orders</h1>

<div class="box-container">

   <?php
   $sql = "SELECT * FROM `magcom` WHERE id_magasin = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id_mag]);

   if ($stmt->rowCount() > 0) {
      while ($fetch_mag = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $idC = $fetch_mag['num_command'];
         $sql = "SELECT * FROM `commande_client` WHERE id_commande = ? and etat_commande='v'";
         $stmt2 = $conn->prepare($sql);
         $stmt2->execute([$idC]);
         $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);

         if ($rows) {
            foreach ($rows as $row) {
               echo '<div class="box">';
               echo '<div class="order-row" onclick="goToOrderDetails(' . htmlspecialchars($row["id_commande"]) . ')">';
               echo '<div><span>Order ID:</span> ' . htmlspecialchars($row["id_commande"]) . '</div>';
               echo '<div><span>Date:</span> ' . htmlspecialchars($row["date_com"]) . '</div>';
               echo '<div><span>Status:</span> ' . htmlspecialchars($row["etat_commande"]) . '</div>';
               echo '<div><span> Prix:</span> ' . htmlspecialchars($row["prix"]) . '<span>$</span></div>';


               echo '<div><span>Client ID:</span> ' . htmlspecialchars($row["id_client"]) . '</div>';
               echo '</div>';
               echo '<div class="order-row">';
               echo '<div>';
               echo '<form action="ajouter_livreur.php" method="post" style="display:inline-block;">';
               echo '<input type="hidden" name="Id_commande" value="' . htmlspecialchars($row["id_commande"]) . '">';
               echo '<button class="accept" type="submit">Accept</button>';
               echo '</div>';
               echo '<div>';
              
               echo '</div>';
               echo '</div>';
               echo '</div>';
            }
         }
      }
   } else {
      echo '<p>No orders placed yet.</p>';
   }
   ?>

</div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
