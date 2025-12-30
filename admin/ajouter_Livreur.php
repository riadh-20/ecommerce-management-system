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
            echo"ttt";
            $email = $row['email'];
            $password = $row['password'];
            $nom = $row['nom'];
            $num_tel = $row['num_tel'];
            $num_compB = $row['num_comptB'];
            $type_vehicule = $row['type_vehicule'];
            $etat_demande = $row['etat_demande'];
            $type_contra = $row['type_contra'];
            $prenom = $row['prenom']; // Corrected variable assignment
            $sexe = $row['sexe'];

            // Insert data into the 'compte' table
            $insert_compte = $conn->prepare("INSERT INTO `compte`(`mot_de_passe`, `email`, `etat_compte`) VALUES (?, ?, 'active')");
            $insert_compte->execute([$password, $email]);

            // Retrieve the ID_compte of the inserted row
            $id_compte = $conn->lastInsertId();

            // Insert data into the 'laivreur' table
            $insert_laivreur = $conn->prepare("INSERT INTO `laivreur`(`nom`, `prenom`, `num_tel`, `type_vehicule`, `sexe`, `type_contra`, `num_compteB`, `Id_compte`, `Id_demande_livreur`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert_laivreur->execute([$nom, $prenom, $num_tel, $type_vehicule, $sexe, $type_contra, $num_compB, $id_compte, $id_Mag]);

            $update_query = $conn->prepare("UPDATE `demande_livreur` SET `etat_demande`='accepted' WHERE Id_demande_livreur = ?");
            $update_query->execute([$id_Mag]);
            header('location:gerre_livreur.php');

        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
