<!DOCTYPE html>
<html>
<head>
    <title>Connexion Administrateur</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #333;
            color: #fff;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding-top: 50px;
        }

        .login-form {
            background-color: #555;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dark mode styles for form elements */
        .form-control {
            background-color: #444;
            color: #fff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Dark mode styles for alerts */
        .alert {
            background-color: #1a1a1a;
            color: #fff;
            border-color: #333;
        }
    </style>
</head>
<body>

    <?php
    // Vérification du formulaire de connexion
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $mot_de_passe = $_POST["mot_de_passe"];

        // Connexion à la base de données en utilisant PDO
        $dsn = "mysql:host=localhost;dbname=restaurants;charset=utf8mb4";
        $nom_utilisateur = "johns";
        $mot_de_passe_db = "admin";

        try {
            $connexion = new PDO($dsn, $nom_utilisateur, $mot_de_passe_db);
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer le mot de passe hashé associé à l'e-mail
            $requete = "SELECT mot_de_passe FROM administrateur WHERE email = :email";
            $statement = $connexion->prepare($requete);
            $statement->bindParam(':email', $email);
            $statement->execute();

            $resultat = $statement->fetch(PDO::FETCH_ASSOC);

            if ($resultat) {
                $mot_de_passe_hash = $resultat['mot_de_passe'];

                // Vérifier si le mot de passe correspond
                if (password_verify($mot_de_passe, $mot_de_passe_hash)) {
                    echo '<div class="alert alert-success" role="alert">Connexion réussie.</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Mot de passe incorrect.</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">L\'e-mail n\'existe pas.</div>';
            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
    ?>

    <div class="container">
        <div class="login-form">
            <h2 class="mb-4">Connexion Administrateur</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label>Email :</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Mot de passe :</label>
                    <input type="password" name="mot_de_passe" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginForm = document.querySelector(".login-form");
            loginForm.style.opacity = 0;
            loginForm.style.transform = "translateY(20px)";

            // Apply the fadeIn animation on load
            setTimeout(function () {
                loginForm.style.opacity = 1;
                loginForm.style.transform = "translateY(0)";
            }, 100);
        });
    </script>

</body>
</html>
