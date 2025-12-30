<?php
include 'components/connect.php';

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Update the order status
    $update_order = $conn->prepare("UPDATE `commande_client` SET `etat_commande` = 'livred' WHERE id_commande = ?");
    $update_order->execute([$orderId]);

    // Redirect to the order details page or any other page
    header('Location: order_details.php?id=' . $orderId);
    exit;
} else {
    header('Location: ../magasin');}
?>
