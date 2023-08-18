<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une commande</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
        }

        .container {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();

        $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        function ajouterCommande($idPlat, $idTable, $idClient, $quantite) {
            global $conn;
            $idPlat = intval($idPlat);
            $idTable = intval($idTable);
            $idClient = intval($idClient);
            $quantite = intval($quantite);

            $localdate = date('Y-m-d H:i:s', time());

            $query = "INSERT INTO commande (date_commande, id_plat, id_table, id_client, quantite) VALUES ('$localdate', $idPlat, $idTable, $idClient, $quantite)";
            return ($conn->query($query) === TRUE);
        }

        $message = '';
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_plat'])) {
            $idPlat = $_POST['id_plat'];
            $idTable = $_POST['id_table'];
            $quantite = $_POST['quantite'];

            if (isset($_SESSION['id_client']) && !empty($_SESSION['id_client'])) {
                $idClient = $_SESSION['id_client'];

                if (ajouterCommande($idPlat, $idTable, $idClient, $quantite)) {
                    $message = 'La commande a été ajoutée avec succès.';
                    $success = true;
                } else {
                    $message = 'Erreur lors de l\'ajout de la commande.';
                }
            } else {
                $message = 'Vous devez être connecté pour ajouter une commande.';
            }
        }

        $queryPlats = "SELECT * FROM plat WHERE nombre > 0";
        $resultPlats = $conn->query($queryPlats);
        $plats = $resultPlats->fetch_all(MYSQLI_ASSOC);

        $queryTables = "SELECT * FROM tables WHERE id_table NOT IN (SELECT DISTINCT id_table FROM commande)";
        $resultTables = $conn->query($queryTables);
        $tables = $resultTables->fetch_all(MYSQLI_ASSOC);

        $conn->close();
        ?>

        <?php if (isset($_SESSION['id_client']) && !empty($_SESSION['id_client'])): ?>
            <h1 class="text-center mt-4">Bienvenue !</h1>
            <p class="text-center">Votre ID client : <?php echo $_SESSION['id_client']; ?></p>
            <div class="text-center">
                <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        <?php else: ?>
            <h1 class="text-center mt-4">Page de connexion</h1>
        <?php endif; ?>

        <?php if (isset($_SESSION['id_client']) && !empty($_SESSION['id_client'])): ?>
            <div class="mt-5">
                <h2 class="text-center">Ajouter une commande</h2>
                <?php if (!empty($message)): ?>
                    <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>"><?php echo $message; ?></div>
                <?php endif; ?>

                <form action="<?php echo "http://localhost/restaurant/Ajouter_commande.php?id=" . $_GET['id']; ?>" method="post">
                    <input type="hidden" name="id_plat" value="<?php echo $_GET['id']; ?>">

                    <div class="form-group">
                        <label for="id_table">Table :</label>
                        <select class="form-control" id="id_table" name="id_table" required>
                            <?php foreach ($tables as $table): ?>
                                <option value="<?php echo $table['id_table']; ?>"><?php echo $table['nom']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantite">Quantité :</label>
                        <input type="number" class="form-control" id="quantite" name="quantite" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Ajouter</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
