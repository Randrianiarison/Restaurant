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

        // Connexion à la base de données
        $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

// Fonction pour enregistrer une commande dans la table "commande"
function ajouterCommande($idPlat, $idTable, $idClient, $quantite) {
    global $conn;

    $idPlat = intval($idPlat);
    $idTable = intval($idTable);
    $idClient = intval($idClient);
    $quantite = intval($quantite);

    $localdate = date('Y-m-d H:i:s', time()); // Get the local date and time

    $query = "INSERT INTO commande (date_commande, id_plat, id_table, id_client, quantite) VALUES ('$localdate', $idPlat, $idTable, $idClient, $quantite)";
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        return false;
    }
}



        // Variables pour afficher les messages de succès ou d'erreur
        $message = '';
        $success = false;

        // Vérifier si le formulaire d'ajout de commande est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $idPlat = $_POST['id_plat'];
            $idTable = $_POST['id_table'];
            $quantite = $_POST['quantite'];

            // Vérifier si l'ID client est défini dans la session
            if (isset($_SESSION['id_client']) && !empty($_SESSION['id_client'])) {
                $idClient = $_SESSION['id_client'];

                // Appeler la fonction d'ajout de commande avec l'ID client de la session
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

        // Récupérer la liste des plats disponibles (quantité > 0)
        $queryPlats = "SELECT * FROM plat WHERE nombre > 0";
        $resultPlats = $conn->query($queryPlats);
        $plats = [];

        if ($resultPlats->num_rows > 0) {
            while ($rowPlat = $resultPlats->fetch_assoc()) {
                $plats[] = $rowPlat;
            }
        }

        // Récupérer la liste des tables qui ne sont pas déjà présentes dans les commandes
        $queryTables = "SELECT * FROM tables WHERE id_table NOT IN (SELECT DISTINCT id_table FROM commande)";
        $resultTables = $conn->query($queryTables);
        $tables = [];

        if ($resultTables->num_rows > 0) {
            while ($rowTable = $resultTables->fetch_assoc()) {
                $tables[] = $rowTable;
            }
        }

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
            <div class="text-center">
                <p>Veuillez vous connecter pour ajouter une commande.</p>
                <a href="login.php" class="btn btn-primary">Se connecter</a>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['id_client']) && !empty($_SESSION['id_client'])): ?>
            <div class="mt-5">
                <h2 class="text-center">Ajouter une commande</h2>
                <?php if ($message !== ''): ?>
                    <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>"><?php echo $message; ?></div>
                <?php endif; ?>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="id_plat">Plat :</label>
                        <select class="form-control" id="id_plat" name="id_plat" required>
                            <?php foreach ($plats as $plat): ?>
                                <option value="<?php echo $plat['ID_plat']; ?>"><?php echo $plat['Nom']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
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
