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
            $email = $row['email'];
            $password = $row['mot_de_passe'];
            $nom = $row['nom'];
            $num_tel = $row['num_tel'];
            $num_compB = $row['num_compB'];
            $type_mag = $row['type_mag'];
            $num_Reg = $row['num_Reg'];
            $etat_demande = $row['etat_demande'];
            $localisation = $row['localisation'];
            $nom_R_mag = $row['nom_R_mag'];

            // Insert data into the 'compte' table
            $insert_compte = $conn->prepare("INSERT INTO `compte`(`mot_de_passe`, `email`, `etat_compte`) VALUES (?, ?, 'active')");
            $insert_compte->execute([$password, $email]);

            // Retrieve the ID_compte of the inserted row
            $id_compte = $conn->lastInsertId();

            // Insert data into the 'magasin' table
            $insert_magasin = $conn->prepare("INSERT INTO `magasin`(`nom`, `nom_R_mag`, `type_mag`, `num_tel`, `num_Reg_mag`, `num_comptB`, `localisation`, `Id_compte`, `Id_demande_mag`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_magasin->execute([$nom, $nom_R_mag, $type_mag, $num_tel, $num_Reg, $num_compB, $localisation, $id_compte, $id_Mag]);
            $update_query = $conn->prepare("UPDATE `demande_magasin` SET `etat_demande`='accepted' WHERE  Id_demande_magasin= ?");
            $update_query->execute([$id_Mag]);
            header('location:gerre_Magasin.php');

        }
        
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
