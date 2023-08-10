<!DOCTYPE html>
<html>
<head>
    <title>Créer un compte</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
        .alert {
            margin-top: 20px;
        }
        body {
            background-color: floralwhite;
        }
        .return-link {
            display: block;
            text-align: center;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s ease;
            margin-top: 10px;
        }
        .return-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Inscription</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
                if ($conn->connect_error) {
                    die("Erreur de connexion à la base de données : " . $conn->connect_error);
                }

                // Fonction pour ajouter un client dans la table "Clients"
                function ajouterClient($nom, $email, $telephone, $adresse) {
                    global $conn;

                    $nom = $conn->real_escape_string($nom);
                    $email = $conn->real_escape_string($email);
                    $telephone = $conn->real_escape_string($telephone);
                    $adresse = $conn->real_escape_string($adresse);

                    $query = "INSERT INTO Clients (nom, email, telephone, adresse) VALUES ('$nom', '$email', '$telephone', '$adresse')";
                    if ($conn->query($query) === TRUE) {
                        return true;
                    } else {
                        return false;
                    }
                }
                $message = '';
                $success = false;

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nom = $_POST['nom'];
                    $email = $_POST['email'];
                    $telephone = $_POST['telephone'];
                    $adresse = $_POST['adresse'];
                    if (ajouterClient($nom, $email, $telephone, $adresse)) {
                        $message = 'Le client a été ajouté avec succès.';
                        $success = true;
                    } else {
                        $message = 'Erreur lors de l\'ajout du client.';
                    }
                }
                ?>

                <?php if ($message !== ''): ?>
                    <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone :</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" pattern="[0-9]+" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse :</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>

                <a href="client_login.php" class="return-link">Retour</a>
            </div>
        </div>
    </div>
</body>
</html>
