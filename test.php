<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un plat</title>
    <!-- Inclure les fichiers CSS Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter un nouveau plat</h2>
        <?php
        $servername = "localhost";
        $username = "johns";
        $password = "admin";
        $dbname = "restaurants";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $categorie = $_POST['categorie'];
            $nombre = $_POST['nombre'];

            // Vérifier si une image a été sélectionnée
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = file_get_contents($_FILES['image']['tmp_name']);
            } else {
                $image = null;
            }

            $stmt = $conn->prepare("INSERT INTO plat (Nom, Description, Prix, Categorie, nombre, Image) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssi", $nom, $description, $prix, $categorie, $nombre, $image);

            if ($stmt->execute()) {
                echo '<div class="alert alert-success">Données insérées avec succès.</div>';
            } else {
                echo '<div class="alert alert-danger">Erreur lors de l\'insertion des données: ' . $stmt->error . '</div>';
            }

            $stmt->close();
        }

        $conn->close();
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom">Nom du plat:</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="prix">Prix:</label>
                <input type="number" class="form-control" id="prix" name="prix" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie:</label>
                <select class="form-control" id="categorie" name="categorie">
                    <option value="plat_principal">Plat principal</option>
                    <option value="boisson">Boisson</option>
                    <option value="dessert">Dessert</option>
                    <option value="pain">Pain</option>
                    <option value="Entrer">Entrer</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="number" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le plat</button>
        </form>
    </div>
    <div class="container mt-5">
        <h2>Liste des plats</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Nombre</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT Nom, Description, Prix, Categorie, nombre, Image FROM plat";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Nom"] . "</td>";
                        echo "<td>" . $row["Description"] . "</td>";
                        echo "<td>" . $row["Prix"] . "</td>";
                        echo "<td>" . $row["Categorie"] . "</td>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        if ($row["Image"]) {
                            echo '<td><img src="data:image/jpeg;base64,' . base64_encode($row["Image"]) . '" alt="Image du plat" style="max-width: 100px;"></td>';
                        } else {
                            echo '<td>Aucune image</td>';
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Aucun plat trouvé</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
