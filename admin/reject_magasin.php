<?php

$db_name = 'mysql:host=localhost;dbname=ec';
$user_name = 'root';
$user_password = '';

try {
    $conn = new PDO($db_name, $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; // You can remove this line if you don't want to display a success message
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if(isset($_POST['Id_demande_magasin'])) {
    
    $id_Mag = $_POST['Id_demande_magasin'];

    try {
        // Retrieve data from the 'demande_magasin' table based on 'Id_demande_magasin'
        $select_query = $conn->prepare("SELECT * FROM `demande_magasin` WHERE Id_demande_magasin = ?");
        $select_query->execute([$id_Mag]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Extract data from the fetched row
        
            
          
            $update_query = $conn->prepare("UPDATE `demande_magasin` SET `etat_demande`='rejected' WHERE  Id_demande_magasin= ?");
            $update_query->execute([$id_Mag]);
            header('location:gerre_Magasin.php');

        }
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
