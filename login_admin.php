<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
      <style>
        body {
            padding-top: 50px;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .alert {
            margin-bottom: 20px;
        }
        body.dark-mode {
            background-color: #333;
            color: #fff;
        }
        .dark-mode-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .back-link {
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Admin Login</h1>
        <?php
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Connexion à la base de données
            $db_host = 'localhost';
            $db_name = 'restaurants';
            $db_user = 'johns';
            $db_pass = 'admin';

            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

            if ($conn->connect_error) {
                die("Erreur de connexion à la base de données : " . $conn->connect_error);
            }

            // Requête pour vérifier l'administrateur
            $sql = "SELECT id, username, email, password FROM admin WHERE email = '$email' LIMIT 1";
            $result = $conn->query($sql);

            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                if ($password === $admin['password']) {
                    $_SESSION['id'] = $admin['id'];
                    header('Location: liste_admin.php');
                    exit;
                } else {
                    echo '<div class="alert alert-danger">Mot de passe incorrect.</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Administrateur non trouvé.</div>';
            }

            $conn->close();
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="index.php" class="back-link" title="lien vers la page d'accueil">Retour à l'accueil</a>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
