<!DOCTYPE html>
<html>
<head>
    <title>Liste des commandes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            filter: blur(8px);
        }
        .background-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .container {
            margin-top: 50px;
            position: relative;
            z-index: 1;
        }
        .table-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .table {
            background-color: rgba(255, 255, 255, 0.8);
            color: black;
        }
        .empty-message {
            text-align: center;
            font-style: italic;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="background-container">
        <img src="image/food.jpg" alt="Background Image" class="background-image">
    </div>

    <div class="container">
        <div class="table-container">
            <h1 style="text-align: center;">Liste des commandes</h1>

            <h2>Liste des commandes</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Numéro de commande</th>
                        <th>Client</th>
                        <th>Date et heure</th>
                        <th>Plat</th>
                        <th>Table</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connexion à la base de données
                    $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
                    if ($conn->connect_error) {
                        die("Erreur de connexion à la base de données : " . $conn->connect_error);
                    }

                    // Récupérer la liste des commandes avec les informations du client, du plat et de la table
                    $queryCommandes = "SELECT commande.id_commande, clients.nom AS client_nom, commande.date_commande, plat.Nom AS plat_nom, plat.prix, tables.nom AS table_nom 
                                       FROM commande
                                       INNER JOIN clients ON commande.id_client = clients.id_client
                                       INNER JOIN plat ON commande.id_plat = plat.ID_plat
                                       INNER JOIN tables ON commande.id_table = tables.id_table";
                    $resultCommandes = $conn->query($queryCommandes);

                    if ($resultCommandes->num_rows > 0) {
                        while ($rowCommande = $resultCommandes->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $rowCommande['id_commande'] . "</td>";
                            echo "<td>" . $rowCommande['client_nom'] . "</td>";
                            echo "<td>" . $rowCommande['date_commande'] . "</td>";
                            echo "<td>" . $rowCommande['plat_nom'] . "</td>";
                            echo "<td>" . $rowCommande['table_nom'] . "</td>";

                            // Ajouter le formulaire pour le bouton "Valider"
                            echo "<td><form method='post'>";
                            echo "<input type='hidden' name='commandeId' value='" . $rowCommande['id_commande'] . "'>";
                            echo "<input type='hidden' name='clientNom' value='" . $rowCommande['client_nom'] . "'>";
                            echo "<input type='hidden' name='platNom' value='" . $rowCommande['plat_nom'] . "'>";
                            echo "<input type='hidden' name='quantite' value='1'>";
                            echo "<input type='hidden' name='prix' value='" . $rowCommande['prix'] . "'>";
                            echo "<button type='submit' class='btn btn-primary' name='validerCommande'>Livré</button>";
                            echo "</form></td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='empty-message'>Aucune commande trouvée.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
if (isset($_POST['validerCommande'])) {
    $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }
    $commandeId = $_POST['commandeId'];
    $clientNom = $_POST['clientNom'];
    $platNom = $_POST['platNom'];
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix'];
    $queryFacture = "INSERT INTO facture (nom, prix, date, id_commande, id_plat, plat) VALUES ('$clientNom', $prix * $quantite, CURRENT_DATE(), $commandeId, (SELECT id_plat FROM plat WHERE Nom = '$platNom'), '$platNom')";
    if ($conn->query($queryFacture) === TRUE) {
        echo "<script>alert('La facture a été ajoutée avec succès.');</script>";
    } else {
        echo "Erreur lors de l'ajout de la facture : " . $conn->error;
    }
    
    $queryUpdatePlat = "UPDATE plat SET nombre = nombre - $quantite WHERE Nom = '$platNom'";
    if ($conn->query($queryUpdatePlat) === TRUE) {
        echo "<script>alert('La quantité a été mise à jour dans le table plats.');</script>";
    } else {
        echo "Erreur lors de la mise à jour de la quantité dans le table plats : " . $conn->error;
    }
    $queryMasquerCommande = "DELETE FROM commande WHERE id_commande = $commandeId";
    if ($conn->query($queryMasquerCommande) === TRUE) {
        echo "<script>alert('La commande a été livrée.');</script>";
    } else {
        echo "Erreur lors du masquage de la commande : " . $conn->error;
    }

    $conn->close();
}
?>
?>
</body>
</html>
