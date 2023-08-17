<!DOCTYPE html>
<html>
<head>
    <title>Page d'accueil - Liste des plats</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            margin-top: 60px; 
        }
        .plat-card {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .plat-card h2 {
            margin-top: 0;
        }
        .plat-image {
            max-width: 200px;
            max-height: 200px;
            margin-right: 20px;
            float: left;
        }
        .navbar {
            background-color: #EFAC11;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
        }
        .navbar-brand {
            color: white;
            font-size: 24px;
            margin: 10px 20px;
            text-decoration: none;
        }
        .navbar-nav {
            margin-right: 20px;
        }
        .nav-item {
            margin: 0 10px;
        }
        .nav-item a {
            color: white;
            font-size: 18px;
            text-decoration: none;
        }
        .nav-item a:hover {
            color: #ddd;
        }
        .plat-card:hover {
            transform: scale(1.05); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .liste{
            text-decoration: none;
            color :black;
        }
    </style>
</head>
<body>
    <div>
    <nav class="navbar">
        <a class="navbar-brand" href="#" style="font-size:50px">Mon Restaurant</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="index.php" title="Page d'acceuil">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="client_login.php"title="Quel lien utiliser si vous souhaitez acheter quelque chose">Client</a></li>
            <li class="nav-item"><a class="nav-link" href="login_admin.php"title="Lien pour l'administrateur ou les employeurs">Administrateur</a></li>
            <li class="nav-item"><a class="nav-link" href="#apropos"title="si vous aves plus de detaille de cette restaurant">À propos</a></li>
        </ul>
    </nav>
    </div>
    <div class="container">
        <h1 class="text-center mt-4">Liste des plats</h1>
        <a class="liste" href="client_login.php">
        <div class="row">
 <?php
            $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
            if ($conn->connect_error) {
                die("Erreur de connexion à la base de données : " . $conn->connect_error);
            }
            $query = "SELECT * FROM plat";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $platCount = 0; // Variable pour compter les plats affichés
                while ($row = $result->fetch_assoc()) {
                    $platCount++;

                    echo '<div class="col-md-6">';
                    echo '<a class="liste" href="client_login.php?id=' . $row['ID_plat'] . '">';
                    echo '<div class="plat-card">';

                    // Affichage de l'image, nom, description, prix et catégorie du plat
                    $imageData = base64_encode($row['Image']);
                    $imageSrc = 'data:image/*;base64,' . $imageData;

                    echo '<img src="' . $imageSrc . '" alt="Image du plat" class="plat-image">';
                    echo '<h3>' . $row['ID_plat'] . '</h3>';
                    echo '<h2>' . $row['Nom'] . '</h2>';
                    echo '<p><strong>Description :</strong> ' . $row['Description'] . '</p>';
                    echo '<p><strong>Prix :</strong> ' . $row['Prix'] . ' Ariary</p>';
                    echo '<p><strong>Catégorie :</strong> ' . $row['Categorie'] . '</p>';

                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12">';
                echo '<p class="text-center">Aucun plat trouvé.</p>';
                echo '</div>';
            }
            $conn->close();
            ?>
        </div></a>
                <div class="text-center mt-4">
            <p>Nombre de plats affichés : <?php echo $platCount; ?></p>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener("load", () => {
            const platCards = document.querySelectorAll(".plat-card");
            platCards.forEach((card) => {
                card.addEventListener("mouseenter", () => {
                    card.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";
                });

                card.addEventListener("mouseleave", () => {
                    card.style.boxShadow = "0 2px 5px rgba(0, 0, 0, 0.1)";
                });
            });
        });
    </script>
</body>
</html>
