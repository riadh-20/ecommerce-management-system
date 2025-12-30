<?php

include '../components/connect.php';

session_start();

if (!isset($_SESSION['livreur_id'])) {
    header('location:../login.php');
    exit;
}

$ID_livreur = $_SESSION['livreur_id'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>

   <!-- Include Font Awesome for icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
   <!-- Include custom admin styles -->
   <link rel="stylesheet" href="../css/style.css">

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
   function confirmAndGoToOrderDetails(orderId) {
    
           window.location.href = 'order_detail.php?id=' + orderId;
       
   }
   </script>

</head>
<body>
<?php include '../components/livreur_header.php'; ?>
<section class="orders">

<h1 class="heading">Command Disponible</h1>

<div class="box-container">

   <?php
   $sql = "SELECT * FROM `commande_client` WHERE etat_commande = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute(['completed']);

   if ($stmt->rowCount() > 0) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         
       

         echo '<div class="box">';
         echo '<div class="order-row" onclick="confirmAndGoToOrderDetails(' . htmlspecialchars($row["id_commande"]) . ')">';
         echo '<div><span>Order ID:</span> ' . htmlspecialchars($row["id_commande"]) . '</div>';
         echo '<div><span>Date:</span> ' . htmlspecialchars($row["date_com"]) . '</div>';
         echo '<div><span>Status:</span> ' . htmlspecialchars($row["etat_commande"]) . '</div>';
         echo '</div>';
         echo '</div>';
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
