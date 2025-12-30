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
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/livreur_header.php'; ?>



<script src="../js/admin_script.js"></script>
   
</body>
</html>