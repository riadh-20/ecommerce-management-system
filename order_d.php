<?php

include 'components/connect.php';

session_start();

if (!isset($_SESSION['ID_client'])) {
    header('location:login.php');
    exit;
}

$order_id = $_GET['id'];
$ID_client = $_SESSION['ID_client'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* CSS for product bov */
        .accept-btn {
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 100px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 10px 5px;
            cursor: pointer;
            border-radius: 12px;
            transition: background-color 0.3s ease;
            position: absolute;
        }

        .accept-btn:hover {
            background-color: #45a049;
        }

        .accept-btn:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
        }

        body {
            background-color: #F4EDEC;
        }

        .cc {
            width: fit-content;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            float: left;
            background-color: #f9f9f9;
        }

        .bov {
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            float: left;
            background-color: #DFC2BC;
        }

        .bov img {
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
            color: #009688;
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
            font-size: 22px;
        }

        .product-evaluation {
            margin-top: 20px;
        }

        .evaluation-form h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .evaluation-form select, .evaluation-form textarea {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .evaluation-form button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .evaluation-form button:hover {
            background-color: #45a049;
        }

        .reviews {
            margin-top: 10px;
        }

        .reviews h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .review {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .review p {
            margin: 5px 0;
        }

        .review .date {
            font-size: 12px;
            color: #666;
        }

        .star-rating {
            color: #FFD700;
        }

    </style>
</head>
<body>
<?php include 'components/user_header.php'; ?>
<?php if (isset($_POST['submit_review'])) {
$note = trim($_POST['rating']);
$review = trim($_POST['review']);
$c_prod = trim($_POST['codep']);
$insert_review= $conn->prepare("INSERT INTO `evaleur_produit`(`id_client`, `code_p`, `note`, `fedback`) VALUES (?,?,?,?)");
        $insert_review->execute([$ID_client,$c_prod,$note ,$review]);



}   ?>


<div class="cc">
    <form action="" method="post">
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <?php
        $select_com = $conn->prepare("SELECT * FROM `contient` WHERE num_cmd = ?");
        $select_com->execute([$order_id]);
        if ($select_com->rowCount() > 0) {
            while ($fetch_com = $select_com->fetch(PDO::FETCH_ASSOC)) {
                $cod_prod = $fetch_com['code_p'];

                $select_products = $conn->prepare("SELECT * FROM `produit` WHERE code_p = ?");
                $select_products->execute([$cod_prod]);
                if ($select_products->rowCount() > 0) {
                    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
        ?>
        <div class="bov">
            <img src="uploaded_img/<?php echo $fetch_products['image_01']; ?>" alt="">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="price">$<span><?php echo $fetch_products['prix_u']; ?></span>/-</div>
            <div class="details"><span><?php echo $fetch_products['description']; ?></span></div>
            <div class="flex-btn">
                <div class="quantite"><span><?php echo $fetch_com['quantite']; ?></span></div>
            </div>

            <?php
            // Fetch product evaluations
            $select_evals = $conn->prepare("SELECT * FROM evaleur_produit WHERE code_p = ?");
            $select_evals->execute([$cod_prod]);
            $evaluations = $select_evals->fetchAll(PDO::FETCH_ASSOC);
            ?>

<section class="product-evaluation">
    <form action="" method="post" class="evaluation-form">
        <h4>Submit your review</h4>
        <select name="rating" required>
            <option value="" disabled selected>Rate the product</option>
            <option value="1">1 - Poor</option>
            <option value="2">2 - Fair</option>
            <option value="3">3 - Good</option>
            <option value="4">4 - Very Good</option>
            <option value="5">5 - Excellent</option>
        </select>
        <textarea name="review" rows="3" placeholder="Write your review here..." required></textarea>
        <input type="hidden" name="codep" value="<?php echo $cod_prod; ?>">
        <button type="submit" name="submit_review">Submit Review</button>
    </form>

    <section class="reviews">
        <h4>Product Reviews</h4>
        <?php
        // Initialize variables
        $reviesT = 0;

        // Check if there are any evaluations
        if (count($evaluations) > 0) {
            // Loop through each evaluation
            foreach ($evaluations as $evaluation) {
                // Get the rating and add it to the total
                $sub_total = intval($evaluation['note']);
                $reviesT += $sub_total;
            }

            // Calculate the average rating
            $rev = $reviesT / count($evaluations);

            // Display the average rating as stars
            ?>
            <div class="review">
                <p class="star-rating">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fa<?= $i < $rev ? 's' : 'r' ?> fa-star"></i>
                    <?php endfor; ?>
                </p>
            </div>
        <?php } else { ?>
            <p>No reviews yet.</p>
        <?php } ?>
    </section>
</section>
    
</div>
        <?php
                }
            }
        }
        ?>

    </form>
</div>

<?php include 'components/footer.php'; ?>

</body>
</html>
