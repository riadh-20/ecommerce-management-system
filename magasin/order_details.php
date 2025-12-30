<?php
session_start();

$id_mag = $_SESSION['id_mag'];

if (!isset($id_mag)) {
    header('location:../login.php');
    exit;
}

include '../components/connect.php';

$order_id = $_GET['id'];

if (isset($_POST['accept'])) {
    $order_id = $_POST['order_id'];
    $select_products = $conn->prepare("UPDATE `commande_client` SET `etat_commande`='completed' WHERE id_commande =?");
    $select_products->execute([$order_id]);
    $number_of_products = $select_products->rowCount();
    header('location:order_details.php?id='. $order_id);
    exit;
}

if (isset($_POST['refuse'])) {
    $order_id = $_POST['order_id'];
    $select_products = $conn->prepare("UPDATE `commande_client` SET `etat_commande`='refuse' WHERE id_commande =?");
    $select_products->execute([$order_id]);
    $number_of_products = $select_products->rowCount();
    header('location:order_details.php?id='. $order_id);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
        /* CSS for product box */
       .accept-btn {
            bottom: 20px; /* Adjust this value to your preference */
            left: 40%;
            transform: translateX(-50%);

            background-color: #4CAF50; /* Green background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 15px 100px; /* Some padding */
            text-align: center; /* Centered text */
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Get the element to line up nicely with others */
            font-size: 20px; /* Increase font size */
            margin: 10px 5px; /* Some margin */
            cursor: pointer; /* Pointer/hand icon on hover */
            border-radius: 12px; /* Rounded corners */
            transition: background-color 0.3s ease; /* Smooth transition */
            position: absolute;
        }
        .refuse-btn {
            bottom: 20px; /* Adjust this value to your preference */
            left: 60%;
            transform: translateX(-50%);

            background-color: red; /* Green background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 15px 100px; /* Some padding */
            text-align: center; /* Centered text */
            text-decoration: none; /* Remove underline */
            display: inline-block; /* Get the element to line up nicely with others */
            font-size: 20px; /* Increase font size */
            margin: 10px 5px; /* Some margin */
            cursor: pointer; /* Pointer/hand icon on hover */
            border-radius: 12px; /* Rounded corners */
            transition: background-color 0.3s ease; /* Smooth transition */
            position: absolute;
        }

       .accept-btn:hover {
            background-color: #45a049; /* Darker green on hover */
        }

       .accept-btn:active {
            background-color: #3e8e41; /* Even darker green when clicked */
            box-shadow: 0 5px #666; /* Add shadow on click */
        }

        body {
            background-color: #F4EDEC;
        }

       .cc {
            background-color: black;
            width: fit-content;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            float: left;
            background-color: #f9f9f9;
        }

       .box {
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            float: left;
            background-color: #DFC2BC;
        }

       .box img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

       .name {
            font-weight: bold;
            margin-top: 10px;
            font-size: 20px;
        }

       .price {
            color: #009688; /* Green color for price */
            font-size: 20px;
        }

       .details {
            margin-top: 10px;
            font-size: 24px;
        }

       .flex-btn {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

       .quantite {
            font-size: 22px; /* Increase font size of quantity */
        }



    </style>
</head>
<body>
<?php include '../components/magasin_header.php';?>
<div class="cc">
    <form action="" method="post">
        <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
        <?php


$select_com = $conn->prepare("SELECT * FROM `produit` WHERE id_magasin   =?");
        $select_com->execute([$id_mag]);
        if ($select_com->rowCount() > 0) {
        while ($fetch_com = $select_com->fetch(PDO::FETCH_ASSOC)) {
        $cod_prod=$fetch_com['code_p'];


        $select_commande = $conn->prepare("SELECT * FROM `contient` WHERE num_cmd  =?  and code_p=?" );
        $select_commande->execute([$order_id,$cod_prod]);
        if ($select_commande->rowCount() > 0) {
            while ($fetch_commande = $select_commande->fetch(PDO::FETCH_ASSOC)) {
                $id_prod = $fetch_commande['code_p'];
                

                $select_products = $conn->prepare("SELECT * FROM `produit` WHERE  code_p =?");
                $select_products->execute([$id_prod]);
                if ($select_products->rowCount() > 0) {
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
       ?>
        <div class="box">
            <img src="../uploaded_img/<?php echo $fetch_products['image_02'];?>" alt="">
            <div class="name"><?php echo $fetch_products['name'];?></div>
            <div class="price">$<span><?php echo $fetch_products['prix_u'];?></span>/-</div>
            <div class="details"><span><?php echo $fetch_products['description'];?></span></div>
            <div class="flex-btn">
                <div class="quantite"><span><?php echo $fetch_commande['quantite'];?></span></div>
            </div>
        </div>

        <?php
                }
            }
         }}
        }
       ?>
<button class="accept-btn" type="submit" name="accept" aria-label="Accept" onclick="return confirm('Accept this order?');">Accept</button>
<button class="refuse-btn" type="submit" name="refuse" aria-label="refuse" onclick="return confirm('refuse this order?');">refuse</button>

    </form>
</div>
</body>
</html>