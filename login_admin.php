<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <!-- Inclure les fichiers Bootstrap CSS -->
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $db_host = 'localhost';
            $db_name = 'restaurants';
            $db_user = 'johns';
            $db_pass = 'admin';

            // Connexion à la base de données
            $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

            // Vérifier s'il y a une erreur de connexion
            if ($conn->connect_error) {
                die("Erreur de connexion à la base de données : " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT id, nom, prenom, email, mot_de_passe FROM administrateur WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $admin = $result->fetch_assoc();
                if (password_verify($password, $admin['mot_de_passe'])) {
                    session_start();
                    $_SESSION['admin_id'] = $admin['id'];
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

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
            <a href="index.php" class="back-link" title="lien vers le page d'acceuil">Retour à l'accueil</a>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
    <script>
        const darkModeToggle = document.createElement('button');
        darkModeToggle.classList.add('btn', 'btn-secondary', 'dark-mode-toggle');
        darkModeToggle.innerText = 'Mode Dark';
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        darkModeToggle.addEventListener('click', toggleDarkMode);
        document.body.appendChild(darkModeToggle);
    </script>
</body>
</html>
