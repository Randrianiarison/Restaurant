<!DOCTYPE html>
<html>
<head>
    <title>Enregistrement Admin</title>
    <!-- Ajouter le lien vers les fichiers Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Enregistrement Admin</h2>
                </div>
                <div class="card-body">

                    <?php
                    // Vérifier si le formulaire a été soumis
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Connexion à la base de données (remplacez ces informations par les vôtres)
                        $servername = "localhost";
                        $username = "johns";
                        $password = "admin";
                        $dbname = "restaurants";

                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Vérifier la connexion à la base de données
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Récupérer les valeurs du formulaire
                        $username = $_POST["username"];
                        $email = $_POST["email"];
                        $password = $_POST["password"];

                        // Préparer et exécuter la requête SQL d'insertion
                        $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
                        $stmt->bind_param("sss", $username, $email, $password);
                        $stmt->execute();

                        // Fermer la connexion à la base de données
                        $stmt->close();
                        $conn->close();

                        echo "Enregistrement réussi!";
                    }
                    ?>
                    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur:</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
                <div class="card-footer text-muted text-center">
                    <!-- Message de réussite après l'enregistrement -->
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        echo "Enregistrement réussi!";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
