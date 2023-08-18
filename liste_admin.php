<!DOCTYPE html>
<html>
<head>
    <title>Liste des administrateurs</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
            background-color: #f7f7f7;
        }

        .container {
            margin-bottom: 20px;
        }

        .center-text {
            text-align: center;
        }

        .custom-table {
            background-color: #ffffff;
        }

        .administrateur-liste {
            margin-top: 20px;
        }

        .titre {
            font-size: 40px;
            margin-bottom: 30px;
            color: #007bff;
        }

        .lien {
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .lien:nth-child(odd) {
            background-color: #007bff;
            color: #ffffff;
        }

        .lien:nth-child(even) {
            background-color: #28a745;
            color: #ffffff;
        }

        .lien:hover {
            background-color: #0056b3;
            color: #ffffff;
        }

        .navbar {
            background-color: #343a40;
            padding: 10px 0;
        }

        .navbar-brand {
            font-size: 24px;
            color: #ffffff;
            font-weight: bold;
        }

        .nav-link {
            color: #ffffff;
        }

        .nav-link:hover {
            color: #f7f7f7;
        }

        .table th, .table td {
            border-color: #dee2e6;
        }

        .table th {
            background-color: #343a40;
            color: #ffffff;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Mon Restaurant</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="Ajouter_plats.php">Ajouter plats</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="table.php">Ajouter tables</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="liste_commande.php">Liste Commande</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Table section -->
<div class="container">
    <div class="center-text">
        <h1 class="titre mb-4">Liste des administrateurs</h1>
    </div>
    <div class="administrateur-liste">
        <table class="table table-striped table-bordered custom-table">
            <thead class="thead-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connexion à la base de données en utilisant PDO
                $dsn = "mysql:host=localhost;dbname=restaurants;charset=utf8mb4";
                $nom_utilisateur = "johns";
                $mot_de_passe_db = "admin";

                try {
                    $connexion = new PDO($dsn, $nom_utilisateur, $mot_de_passe_db);
                    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Requête pour récupérer la liste des administrateurs
                    $requete = "SELECT username, email FROM admin";
                    $resultat = $connexion->query($requete);

                    // Afficher chaque administrateur dans le tableau
                    while ($administrateur = $resultat->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $administrateur['username'] . "</td>";
                        echo "<td>" . $administrateur['email'] . "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    die("Erreur de connexion à la base de données : " . $e->getMessage());
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="js/bootstrap.min.js"></script>

</body>
</html>
