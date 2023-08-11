<?php
session_start();

// Connexion à la base de données
$conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Fonction pour obtenir l'id_client en fonction de l'email
function getIdClientByEmail($email) {
    global $conn;
    $email = $conn->real_escape_string($email);

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id_client FROM clients WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['id_client'];
    } else {
        return null;
    }
}

// ...

// Vérifier si le formulaire de connexion est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer l'email du formulaire
    $email = $_POST['email'];

    // Récupérer l'id_client en fonction de l'email
    $idClient = getIdClientByEmail($email);

    if ($idClient !== null) {
        // L'email existe, rediriger vers la page d'ajout de commande
        $_SESSION['id_client'] = $idClient;
        header('Location: Ajouter_commande.php');
        exit;
    } else {
        // L'email n'existe pas, afficher un message d'erreur
        $loginError = 'Cet email n\'existe pas.';
    }
} elseif (isset($_GET['plat_id'])) {
    $selectedPlatId = $_GET['plat_id'];
    // Récupérer le nom du plat sélectionné
    $query = "SELECT Nom FROM plat WHERE id_plat = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $selectedPlatId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $selectedPlatNom = $row['Nom'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: floralwhite;
        }
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 50px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        /* Style the links */
        .custom-link {
            display: inline-block;
            text-align: center;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
            border-bottom: 2px solid transparent;
            transition: border-bottom-color 0.2s ease;
        }
        .custom-link:hover {
            border-bottom-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Page de connexion</h1>
        <?php if (isset($selectedPlatNom)): ?>
            <p class="mt-2 text-center">Vous avez sélectionné le plat : <?php echo $selectedPlatNom; ?></p>
        <?php endif; ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <?php if(isset($loginError)): ?>
                            <div class="alert alert-danger"><?php echo $loginError; ?></div>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                        <a href="Ajout_client.php" class="custom-link">Créer un compte</a>
                        <a href="index.php" class="custom-link">Retour</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript form validation
        document.querySelector("form").addEventListener("submit", function (event) {
            event.preventDefault();
            if (!validateForm()) {
                event.stopPropagation();
            } else {
                this.submit();
            }
        });

        function validateForm() {
            const emailInput = document.getElementById("email");
            const emailValue = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailValue === "") {
                showErrorMessage(emailInput, "Veuillez entrer une adresse email.");
                return false;
            } else if (!emailRegex.test(emailValue)) {
                showErrorMessage(emailInput, "Veuillez entrer une adresse email valide.");
                return false;
            } else {
                hideErrorMessage(emailInput);
                return true;
            }
        }

        function showErrorMessage(inputElement, message) {
            const errorElement = document.createElement("div");
            errorElement.className = "invalid-feedback";
            errorElement.innerText = message;

            inputElement.classList.add("is-invalid");
            inputElement.parentNode.appendChild(errorElement);
        }

        function hideErrorMessage(inputElement) {
            const errorElement = inputElement.parentNode.querySelector(".invalid-feedback");
            if (errorElement) {
                inputElement.classList.remove("is-invalid");
                inputElement.parentNode.removeChild(errorElement);
            }
        }
    </script>
</body>
</html>
