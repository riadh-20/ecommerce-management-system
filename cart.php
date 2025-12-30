<?php

include 'components/connect.php';

session_start();

if (!isset($_SESSION['ID_client'])) {
    header('location:login.php');
    exit;
}

$ID_client = $_SESSION['ID_client'];

// Fetch cart details to use in multiple places
$select_cart = $conn->prepare("SELECT * FROM `panier` WHERE id_compte = ?");
$select_cart->execute([$ID_client]);
$fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC);

$id_pannier = $fetch_cart['id_pannier'] ?? null;

if (isset($_POST['delete'])) {
    $cart_id = $_POST['cart_id'];

    $select_ligne = $conn->prepare("SELECT * FROM `ligne_panier` WHERE id_ligne = ?");
    $select_ligne->execute([$cart_id]);
    $fetch_ligne = $select_ligne->fetch(PDO::FETCH_ASSOC);

    if ($fetch_ligne !== false) {
        $prix_total = $fetch_cart['montant_total'] - ($fetch_ligne['quantite'] * $fetch_ligne['montant']);
        $nbr_pro = $fetch_cart['nbr_produit'] - 1;

        $update_cart = $conn->prepare("UPDATE `panier` SET nbr_produit = ?, montant_total = ? WHERE id_pannier = ?");
        $update_cart->execute([$nbr_pro, $prix_total, $id_pannier]);

        $delete_cart_item = $conn->prepare("DELETE FROM `ligne_panier` WHERE id_ligne = ?");
        $delete_cart_item->execute([$cart_id]);
    }
}

if (isset($_GET['delete_all'])) {
    if ($id_pannier !== null) {
        $delete_cart_item = $conn->prepare("DELETE FROM `ligne_panier` WHERE id_panier = ?");
        $delete_cart_item->execute([$id_pannier]);

        $update_cart = $conn->prepare("UPDATE `panier` SET nbr_produit = ?, montant_total = ? WHERE id_pannier = ?");
        $update_cart->execute([0, 0, $id_pannier]);
    }

    header('location:cart.php');
    exit;
}

if (isset($_GET['order'])) {
    $grand_total = 0;

    if ($id_pannier !== null) {
        // Calculate grand total before placing the order
        $ligne_panier = $conn->prepare("SELECT * FROM `ligne_panier` WHERE id_panier = ?");
        $ligne_panier->execute([$id_pannier]);
        while ($fetch_panier = $ligne_panier->fetch(PDO::FETCH_ASSOC)) {
            $select_prod = $conn->prepare("SELECT * FROM `produit` WHERE code_p = ?");
            $select_prod->execute([$fetch_panier['code_p']]);
            $fetch_prod = $select_prod->fetch(PDO::FETCH_ASSOC);
            $grand_total += $fetch_prod['prix_u'] * $fetch_panier['quantite'];
        }

        // Insert into commande_client
        $insert_co = $conn->prepare("INSERT INTO `commande_client` (prix,date_com, etat_commande, id_client, id_pannier, id_livreur) VALUES (?,NOW(), 'v', ?, ?, NULL)");
        $insert_co->execute([$grand_total, $ID_client, $id_pannier]);
        $id_commande = $conn->lastInsertId(); // Get the last inserted id from commande_client

        // Select all items in the panier
        $select_L = $conn->prepare("SELECT * FROM `ligne_panier` WHERE id_panier = ?");
        $select_L->execute([$id_pannier]);

        if ($select_L->rowCount() > 0) {
            while ($fetch_L = $select_L->fetch(PDO::FETCH_ASSOC)) {
                // Insert into contient table
                $insert_contient = $conn->prepare("INSERT INTO `contient` (code_p, num_cmd, quantite) VALUES (?, ?, ?)");
                $insert_contient->execute([$fetch_L['code_p'], $id_commande, $fetch_L['quantite']]);

                // Select the magasin id
                $select_mag = $conn->prepare("SELECT * FROM `produit` WHERE code_p = ?");
                $select_mag->execute([$fetch_L['code_p']]);
                $fetch_mag = $select_mag->fetch(PDO::FETCH_ASSOC);
                $id_mag = $fetch_mag['id_magasin'];

                // Check if the magasin id exists in the magcom table
                $select_magasin = $conn->prepare("SELECT * FROM `magcom` WHERE id_magasin = ? AND num_command = ?");
                $select_magasin->execute([$id_mag, $id_commande]);
                if ($select_magasin->rowCount() == 0) {
                    // Insert into magcom table
                    $insert_magcom = $conn->prepare("INSERT INTO `magcom` (num_command, id_magasin) VALUES (?, ?)");
                    $insert_magcom->execute([$id_commande, $id_mag]);
                }
            }
        }

        // Clear the cart after placing the order
        $delete_cart_items = $conn->prepare("DELETE FROM `ligne_panier` WHERE id_panier = ?");
        $delete_cart_items->execute([$id_pannier]);

        $update_cart = $conn->prepare("UPDATE `panier` SET nbr_produit = ?, montant_total = ? WHERE id_pannier = ?");
        $update_cart->execute([0, 0, $id_pannier]);
    }

    header('location:cart.php');
    exit;
}

if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);

    $select_ligne = $conn->prepare("SELECT * FROM `ligne_panier` WHERE id_ligne = ?");
    $select_ligne->execute([$cart_id]);
    $fetch_ligne = $select_ligne->fetch(PDO::FETCH_ASSOC);

    if ($fetch_ligne !== false) {
        $new_total = $fetch_cart['montant_total'] - ($fetch_ligne['quantite'] * $fetch_ligne['montant']) + ($qty * $fetch_ligne['montant']);

        $update_qty = $conn->prepare("UPDATE `ligne_panier` SET quantite = ? WHERE id_ligne = ?");
        $update_qty->execute([$qty, $cart_id]);

        $update_cart = $conn->prepare("UPDATE `panier` SET montant_total = ? WHERE id_pannier = ?");
        $update_cart->execute([$new_total, $id_pannier]);

        $message[] = 'Cart quantity updated';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
<?php include 'components/user_header.php'; ?>

<section class="products shopping-cart">

    <h3 class="heading">Shopping Cart</h3>

    <div class="box-container">

    <?php
    $grand_total = 0;

    if ($id_pannier !== null) {
        $ligne_panier = $conn->prepare("SELECT * FROM `ligne_panier` WHERE id_panier = ?");
        $ligne_panier->execute([$id_pannier]);

        if ($ligne_panier->rowCount() > 0) {
            while ($fetch_panier = $ligne_panier->fetch(PDO::FETCH_ASSOC)) {
                $select_prod = $conn->prepare("SELECT * FROM `produit` WHERE code_p = ?");
                $select_prod->execute([$fetch_panier['code_p']]);
                $fetch_prod = $select_prod->fetch(PDO::FETCH_ASSOC);
    ?>
    <form action="" method="post" class="box">
        <input type="hidden" name="cart_id" value="<?= $fetch_panier['id_ligne']; ?>">
        <a href="quick_view.php?pid=<?= $fetch_panier['code_p']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?= $fetch_prod['image_01']; ?>" alt="">
        <div class="name"><?= htmlspecialchars($fetch_prod['name']); ?></div>
        <div class="flex">
            <div class="price">$<?= htmlspecialchars($fetch_prod['prix_u']); ?>/-</div>
            <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= htmlspecialchars($fetch_panier['quantite']); ?>">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
        </div>
        <div class="sub-total">Sub total: <span>$<?= htmlspecialchars($sub_total = ($fetch_prod['prix_u'] * $fetch_panier['quantite'])); ?>/-</span></div>
        <input type="submit" value="Delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
    </form>
    <?php
                $grand_total += $sub_total;
            }
        } else {
            echo '<p class="empty">Your cart is empty</p>';
        }
    } else {
        echo '<p class="empty">Your cart is empty</p>';
    }
    ?>
    </div>

    <div class="cart-total">
        <p>Grand total: <span>$<?= htmlspecialchars($grand_total); ?>/-</span></p>
        <a href="shop.php" class="option-btn">Continue shopping</a>
        <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>" onclick="return confirm('delete all from cart?');">Delete all items</a>
        <a href="cart.php?order" class="btn <?= ($grand_total > 0) ? '' : 'disabled'; ?>">Proceed to checkout</a>
    </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
