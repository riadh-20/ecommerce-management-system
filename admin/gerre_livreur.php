<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
   <link rel="stylesheet" href="../css/admin_style.css">
   
    <title>Gere_compte</title>
</head>
<body>
<?php include 'C:\xampp\htdocs\ecfinal\components/connect.php'; ?>
<?php include 'C:\xampp\htdocs\ecfinal\components/admin_header.php'; ?>




<table>
    <thead>
        <tr>
            <th>Id_demande_livreur  </th>
            <th>nom</th>
            <th>email</th>
            <th>num_tel</th>
            <th>num_comptB</th>
            <th>prenom</th>
            <th>sexe</th>
            <th>type_vehicule </th>
            <th>type_contra </th>
            <th> etat_demande</th>
            <th>password  </th>
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        

        // Prepare the SQL query
     $sql = "SELECT * FROM demande_livreur where etat_demande='en march'	 " ;


        // Execute the query
        $stmt = $conn->query($sql);

        // Fetch the results as an associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if there are any results
        if ($rows) {
            // Loop through the results and display each row
            foreach ($rows as $row) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row["Id_demande_livreur"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["nom"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["num_tel"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["num_comptB"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["prenom"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["sexe"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["type_vehicule"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["type_contra"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["etat_demande"]) . '</td>';
                echo '<td>' . htmlspecialchars($row["password"]) . '</td>';
                echo '<td>';
                echo '<form action="ajouter_livreur.php"   method="post">';
                echo '<input type="hidden" name="Id_demande_livreur" value="' . htmlspecialchars($row["Id_demande_livreur"]) . '">';
                echo '<button class="accept" type="submit">Accept</button>';
                echo '</form>';
                echo '<form action="reject_Livreur.php"   method="post">';
                echo '<input type="hidden" name="Id_demande_livreur" value="' . htmlspecialchars($row["Id_demande_livreur"]) . '">';
                echo '<button class="reject" type="submit">Reject</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="9">No results found</td></tr>';
        }

        // Close the connection
        $pdo = null;
        ?>
    </tbody>
</table>

</body>
</html>
