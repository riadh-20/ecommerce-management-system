<?php

if (isset($_POST['add_to_wishlist'])) {

    if (empty($ID_client)) {
        header('location:./login.php');
        exit;
    } else {

        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $image = filter_var($_POST['image'], FILTER_SANITIZE_STRING);

        $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND ID_client = ?");
        $check_wishlist_numbers->execute([$name, $ID_client]);

        if ($check_wishlist_numbers->rowCount() > 0) {
            $message[] = 'Already added to wishlist!';
        } else {
            $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(ID_client, pid, name, price, image) VALUES(?,?,?,?,?)");
            $insert_wishlist->execute([$ID_client, $pid, $name, $price, $image]);
            $message[] = 'Added to wishlist!';
        }

    }

}

if (isset($_POST['add_to_cart'])) {

    if (empty($ID_client)) {
        header('location:login.php');
        exit;
    } else {
        $select_cart = $conn->prepare("SELECT id_pannier, montant_total, nbr_produit FROM `panier` WHERE id_compte = ?");
        $select_cart->execute([$ID_client]);
        $fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC);

        if ($fetch_cart !== false) {
            $id_pannier = $fetch_cart['id_pannier'];
        } else {
            // Handle the case where the panier doesn't exist for the user
            // Here, you might want to create a new panier
            $create_cart = $conn->prepare("INSERT INTO `panier` (id_compte, montant_total, nbr_produit) VALUES (?, 0, 0)");
            $create_cart->execute([$ID_client]);
            $id_pannier = $conn->lastInsertId();
        }

        $pid = filter_var($_POST['pid'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
        $image = filter_var($_POST['image'], FILTER_SANITIZE_STRING);
        $qty = filter_var($_POST['qty'], FILTER_SANITIZE_STRING);

        $check_cart_numbers = $conn->prepare("SELECT * FROM `ligne_panier` WHERE code_p = ? AND id_panier = ?");
        $check_cart_numbers->execute([$pid, $id_pannier]);

        if ($check_cart_numbers->rowCount() > 0) {
            $message[] = 'Already added to cart!';
        } else {
            $insert_cart = $conn->prepare("INSERT INTO `ligne_panier` (quantite, montant, id_panier, code_p) VALUES (?, ?, ?, ?)");
            $insert_cart->execute([$qty, $price, $id_pannier, $pid]);

            // Update the total price and product count in the panier
            $prix_total = $fetch_cart['montant_total'] + ($qty * $price);
            $nbr_pro = $fetch_cart['nbr_produit'] + 1;

            $update_cart = $conn->prepare("UPDATE `panier` SET nbr_produit = ?, montant_total = ? WHERE id_pannier = ?");
            $update_cart->execute([$nbr_pro, $prix_total, $id_pannier]);

            $message[] = 'Added to cart!';
        }

    }

}

?>
