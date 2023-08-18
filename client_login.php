<?php
session_start();

$conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
function getIdClientByEmail($email, $conn) {
    $email = mysqli_real_escape_string($conn, $email);
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

function getPlatDetails($platId, $conn) {
    $query = "SELECT * FROM plat WHERE ID_plat = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $platId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

$selectedPlatDetails = null;
if (isset($_GET['id'])) {
    $selectedPlatId = $_GET['id'];
    $selectedPlatDetails = getPlatDetails($selectedPlatId, $conn);
}

$loginError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $idClient = getIdClientByEmail($email, $conn);

    if ($idClient !== null) {
        $_SESSION['id_client'] = $idClient;
        if (isset($_POST['id_plat']) && isset($_GET['id'])) {
            $selectedPlatId = $_GET['id'];
            header("Location: Ajouter_commande.php?id=$selectedPlatId");
        } else {
            header('Location: Ajouter_commande.php');
        }
        exit;
    } else {
        $loginError = 'Cet email n\'existe pas.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
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
    <h3 class="mt-4 text-center">Entrer votre Email</h3>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-container">
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . (isset($_GET['id']) ? $_GET['id'] : ''); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <?php if(isset($loginError)): ?>
                        <div class="alert alert-danger"><?php echo $loginError; ?></div>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary" name="id_plat">Se connecter</button>
                    <a href="Ajout_client.php" class="custom-link">Créer un compte</a>
                    <a href="index.php" class="custom-link">Retour</a>
                </form>
            </div>
            <?php if ($selectedPlatDetails !== null): ?>
                <div class="mt-2 text-center">
                    <h3>Détails du plat sélectionné</h3>
                    <p>Nom du plat : <?php echo $selectedPlatDetails['Nom']; ?></p>
                    <p>Description : <?php echo $selectedPlatDetails['Description']; ?></p>
                    <p>Prix : <?php echo $selectedPlatDetails['Prix'] . " Ariary"; ?></p>
                    <p>Catégorie : <?php echo $selectedPlatDetails['Categorie']; ?></p>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($selectedPlatDetails['Image']); ?>" alt="Plat Image" width="200">
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
