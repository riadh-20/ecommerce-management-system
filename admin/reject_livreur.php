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
echo"fff";

if(isset($_POST['Id_demande_livreur'])) {
    
    $id_Mag = $_POST['Id_demande_livreur'];

    try {
        echo"sss";
        // Retrieve data from the 'demande_livreur' table based on 'Id_demande_livreur'
        $select_query = $conn->prepare("SELECT * FROM `demande_livreur` WHERE Id_demande_livreur = ?");
        $select_query->execute([$id_Mag]);
        $row = $select_query->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Extract data from the fetched row
           
            $update_query = $conn->prepare("UPDATE `demande_livreur` SET `etat_demande`='rejected' WHERE Id_demande_livreur = ?");
            $update_query->execute([$id_Mag]);
            header('location:gerre_livreur.php');

        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>


