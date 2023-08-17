<?php
// Connexion à la base de données
$conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}
function ajouterPlat($nom, $description, $prix, $categorie, $nombre, $image) {
    global $conn;

    $nom = $conn->real_escape_string($nom);
    $description = $conn->real_escape_string($description);
    $prix = floatval($prix);
    $nombre = intval($nombre);
    $imagePath = '';

    // Vérifier si une image est téléchargée
    if ($image['error'] === UPLOAD_ERR_OK) {
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imagePath = 'image/' . $imageName;

        // Déplacer l'image vers le dossier des téléchargements
        move_uploaded_file($imageTmpName, $imagePath);
    }

    $query = "INSERT INTO plats (ID_plat, Nom, Description, Prix, Categorie, Nombre, Image) VALUES (NULL, '$nom', '$description', $prix, '$categorie', $nombre, '$imagePath')";
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
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $nombre = $_POST['nombre'];
    $image = $_FILES['image'];
    if (ajouterPlat($nom, $description, $prix, $categorie, $nombre, $image)) {
        $message = 'Le plat a été ajouté avec succès.';
        $success = true;
    } else {
        $message = 'Erreur lors de l\'ajout du plat.';
    }
}
$query = "SELECT * FROM plats";
$result = $conn->query($query);
$plats = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $plats[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un plat</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
        .alert {
            margin-top: 20px;
        }
        .plats-liste {
            margin-top: 50px;
        }
        body{
            background-color:floralwhite;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Ajouter un plat</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($message !== ''): ?>
                    <div class="alert <?php echo $success ? 'alert-success' : 'alert-danger'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nom">Nom du plat :</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie">Catégorie :</label>
                        <select class="form-control" id="categorie" name="categorie" required>
                            <option value="Entrée">Entrée</option>
                            <option value="Plat principal">Plat principal</option>
                            <option value="Dessert">Dessert</option>
                            <option value="Dessert">Boisson</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre :</label>
                        <input type="number" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image :</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <div class="plats-liste">
        <div class="container-fluid">
            <h2 class="text-center">Liste des plats</h2>
            <?php if (count($plats) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Catégorie</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($plats as $plat): ?>
                            <tr>
                                <td><img src="<?php echo $plat['Image']; ?>" alt="Image du plat" height="100"></td>
                                <td><?php echo $plat['Nom']; ?></td>
                                <td><?php echo $plat['Description']; ?></td>
                                <td><?php echo $plat['Prix']; ?></td>
                                <td><?php echo $plat['Categorie']; ?></td>
                                <td><?php echo $plat['nombre']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Aucun plat enregistré.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
