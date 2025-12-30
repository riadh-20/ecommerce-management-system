<?php
include '../components/connect.php';

session_start();

if (!isset($_SESSION['livreur_id'])) {
    header('location:../login.php');
    exit;
}

$ID_livreur = $_SESSION['livreur_id'];
$order_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['valider'])) {

    $update_order = $conn->prepare("UPDATE `commande_client` SET `etat_commande`='livred' WHERE id_commande = ?");
    $update_order->execute([ $order_id]);
    header('location:mes commande.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_problem'])) {
    $problem = $_POST['problem'];

    $update_order = $conn->prepare("UPDATE `commande_client` SET `etat_commande`='retour' WHERE id_commande = ?");
    $update_order->execute([ $order_id]);
    
    $stmt = $conn->prepare("SELECT `id_signal`, `description`, `id_commande` FROM `signal_problem` WHERE id_commande=?");
    $stmt->execute([$order_id]);

    if ($stmt->rowCount() == 0) {
        if (!empty($problem)) {
            $insert_stmt = $conn->prepare('INSERT INTO signal_problem (description, id_commande) VALUES (?, ?)');
            $insert_stmt->execute([$problem, $order_id]);
        }
    }
    header('location:mes commande.php');
    exit;

}

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
   <link rel="stylesheet" href="css/style.css">

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
      .hidden {
        display: none;
      }
   </style>
</head>
<body>
<section class="orders">
<h1>Client Address</h1>
<?php 
 // Fetch the order details
 $sql = "SELECT * FROM `commande_client` WHERE id_commande = ?";
 $stmt = $conn->prepare($sql);
 $stmt->execute([$order_id]);
 $order = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the client details
$client = $conn->prepare("SELECT * FROM `client` WHERE ID_client= ?");
$client->execute([$order['id_client']]);
$fetch_client = $client->fetch(PDO::FETCH_ASSOC);

echo '<div class="box">';
echo '<div class="order-row">';
echo '<div><span>Nom:</span> ' . htmlspecialchars($fetch_client['nom']) . '</div>';
echo '<div><span>Prénom:</span> ' . htmlspecialchars($fetch_client['prenom']) . '</div>';
echo '<div><span>Adresse:</span> ' . htmlspecialchars($fetch_client['adresse']) . '</div>';
echo '<div><span>Téléphone:</span> ' . htmlspecialchars($fetch_client['num_tel']) . '</div>';
echo '</div>';
echo '</div>';
?>

<h1 class="heading">Store List</h1>
<div class="box-container">
   <?php
   // Fetch the store details
   $magasin = $conn->prepare("SELECT * FROM `magcom` WHERE num_command = ?");
   $magasin->execute([$order_id]);

   if ($magasin->rowCount() > 0) {
      while ($fetch_magasin = $magasin->fetch(PDO::FETCH_ASSOC)) {
         
         $magasin_inf = $conn->prepare("SELECT * FROM `magasin` WHERE id_mag = ?");
         $magasin_inf->execute([$fetch_magasin['id_magasin']]);
         $fetch_magasin_inf = $magasin_inf->fetch(PDO::FETCH_ASSOC);

         echo '<div class="box">';
         echo '<div class="order-row">';
         echo '<div><span>Name:</span> ' . htmlspecialchars($fetch_magasin_inf['nom']) . '</div>';
         echo '<div><span>Location:</span> ' . htmlspecialchars($fetch_magasin_inf['localisation']) . '</div>';
         echo '<div><span>Telephone:</span> ' . htmlspecialchars($fetch_magasin_inf['num_tel']) . '</div>';
         echo '</div>';
         echo '</div>';
      }
   } else {
      echo '<p>No orders placed yet.</p>';
   }
   ?>
</div>

</section>

<form id="order-form" method="post" action="">
   <button class="accept" type="submit" name="valider" onclick="return confirm('Valider this order?');">Valider</button>
   <button type="button" id="signaler-button">Signaler Button</button>
   <div id="form-container" class="hidden">
      <label for="problem-input">Problem:</label>
      <input type="text" id="problem-input" name="problem">
      <button type="submit" id="send-button" name="send_problem">Accept</button>
      <button type="button" id="console-button">anuller</button>

   </div>
</form>

<script>
const signalerButton = document.getElementById('signaler-button');
const formContainer = document.getElementById('form-container');
const problemInput = document.getElementById('problem-input');
const consoleButton = document.getElementById('console-button');
const acceptButton = document.getElementById('accept-button');

signalerButton.addEventListener('click', () => {
  formContainer.classList.remove('hidden');
});

consoleButton.addEventListener('click', () => {
   formContainer.classList.add('hidden');
  console.log('Console button clicked');
});

acceptButton.addEventListener('click', () => {
  formContainer.classList.add('hidden');
});
</script>

</body>
</html>
