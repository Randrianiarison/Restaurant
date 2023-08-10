<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Fonction pour ajouter une table
function ajouterTable($nom) {
    global $conn;

    $nom = $conn->real_escape_string($nom);

    $query = "INSERT INTO tables (nom, libre) VALUES ('$nom', true)";
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        throw new Exception("Erreur lors de l'insertion : " . $conn->error);
    }
}


$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le nom de la table depuis le formulaire
    $nom = $_POST['nom'];

    // Appeler la fonction d'ajout de table
    if (ajouterTable($nom)) {
        $message = 'La table a été ajoutée avec succès.';
        $success = true;
    } else {
        $message = 'Erreur lors de l\'ajout de la table.';
    }
}

$query = "SELECT * FROM tables";
$result = $conn->query($query);
$tables = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une table</title>
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
        .menu-bar {
            background-color: #007bff; /* Couleur de fond de la barre de menu */
            padding: 10px;
        }
        .menu-item {
            display: inline-block;
            margin-right: 20px;
        }
        .menu-item a {
            text-decoration: none;
            color: white; /* Couleur du texte des liens du menu */
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .menu-item a:hover {
            background-color: #0056b3; /* Couleur de fond au survol */
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="menu-bar">
        <div class="container">
            <div class="menu-item">
                <!-- Lien "Ajouter plats" vers Ajouter_plats.php -->
                <a href="Ajouter_plats.php">Ajouter plats</a>
            </div>
            <div class="menu-item">
                <!-- Lien "Ajouter tables" vers Ajouter_tables.php -->
                <a href="Ajouter_tables.php">Ajouter tables</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="mt-4 text-center">Ajouter une table</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($message !== ''): ?>
                    <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label for="nom">Nom de la table :</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

        <div class="plats-liste">
            <div class="container-fluid">
                <h2 class="text-center">Liste des tables</h2>
                <?php if (count($tables) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Libre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tables as $table): ?>
                                <tr>
                                    <td><?php echo $table['nom']; ?></td>
                                    <td><?php echo $table['libre'] ? 'Oui' : 'Non'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center">Aucune table enregistrée.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
