<!DOCTYPE html>
<html>
<head>
    <title>Gestion CRM & Marketing</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Gestion CRM & Marketing</h1>

        <h2>Communication avec les clients</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nom du client</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Demande / Commentaire</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
                if ($conn->connect_error) {
                    die("Erreur de connexion à la base de données : " . $conn->connect_error);
                }

                $query = "SELECT * FROM Clients";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['nom'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['telephone'] . "</td>";
                        echo "<td>" . $row['demande_commentaire'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Aucune communication avec les clients.</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>

        <h2>Stratégie de marketing</h2>
        <div>
            <h4>Publicité au paiement par clic</h4>
            <p>Code PHP pour gérer la publicité au paiement par clic et afficher les statistiques de performance.</p>
        </div>

        <div>
            <h4>Stratégie de marketing de contenu</h4>
            <p>Code PHP pour gérer la stratégie de marketing de contenu et afficher les articles, blogs ou autres contenus publiés.</p>
        </div>

        <div>
            <h4>Offres spéciales et promotions</h4>
            <p>Code PHP pour gérer les offres spéciales, les promotions et afficher les détails de ces offres.</p>
        </div>

        <div>
            <h4>Emails marketing</h4>
            <p>Code PHP pour gérer les campagnes d'email marketing et afficher les statistiques d'ouverture, de clics, etc.</p>
        </div>
    </div>
</body>
</html>
<?php
// Fonction pour gérer la publicité au paiement par clic et afficher les statistiques de performance
function gestionPubliciteClic()
{
    // Code pour gérer la publicité au paiement par clic

    // Simulation de données de statistiques
    $clics = 500;
    $impressions = 1000;
    $tauxClics = ($clics / $impressions) * 100;

    // Affichage des statistiques de performance
    echo "<h3>Statistiques de publicité au paiement par clic :</h3>";
    echo "<p>Clics : $clics</p>";
    echo "<p>Impressions : $impressions</p>";
    echo "<p>Taux de clics : $tauxClics%</p>";
}

// Appel de la fonction pour afficher les statistiques de performance de la publicité au paiement par clic
gestionPubliciteClic();
?>
<?php
// Fonction pour gérer la stratégie de marketing de contenu et afficher les articles
function gestionMarketingContenu()
{
    // Code pour gérer la stratégie de marketing de contenu

    // Simulation de données d'articles
    $articles = [
        [
            'titre' => 'Nouvelles tendances en matière de restauration',
            'auteur' => 'John Doe',
            'date' => '2023-07-15',
            'contenu' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit....',
        ],
        [
            'titre' => 'Conseils pour une alimentation saine',
            'auteur' => 'Jane Smith',
            'date' => '2023-07-12',
            'contenu' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit....',
        ],
        // Ajouter d'autres articles ici...
    ];

    // Affichage des articles
    echo "<h3>Articles de marketing de contenu :</h3>";
    foreach ($articles as $article) {
        echo "<h4>" . $article['titre'] . "</h4>";
        echo "<p>Auteur : " . $article['auteur'] . "</p>";
        echo "<p>Date : " . $article['date'] . "</p>";
        echo "<p>" . $article['contenu'] . "</p>";
        echo "<hr>";
    }
}

// Appel de la fonction pour afficher les articles de marketing de contenu
gestionMarketingContenu();
?>
<?php
// Fonction pour gérer les offres spéciales et promotions
function gestionOffresPromotions()
{
    // Code pour gérer les offres spéciales et promotions

    // Simulation de données d'offres spéciales
    $offres = [
        [
            'titre' => 'Offre spéciale du mois',
            'description' => 'Obtenez une réduction de 20% sur tous les plats principaux.',
            'date_debut' => '2023-07-01',
            'date_fin' => '2023-07-31',
        ],
        [
            'titre' => 'Promotion Happy Hour',
            'description' => 'Tous les cocktails à moitié prix de 17h à 19h.',
            'date_debut' => '2023-07-01',
            'date_fin' => '2023-07-31',
        ],
        // Ajouter d'autres offres ici...
    ];

    // Affichage des détails des offres spéciales
    echo "<h3>Offres spéciales et promotions :</h3>";
    foreach ($offres as $offre) {
        echo "<h4>" . $offre['titre'] . "</h4>";
        echo "<p>" . $offre['description'] . "</p>";
        echo "<p>Date de début : " . $offre['date_debut'] . "</p>";
        echo "<p>Date de fin : " . $offre['date_fin'] . "</p>";
        echo "<hr>";
    }
}

// Appel de la fonction pour afficher les détails des offres spéciales et promotions
gestionOffresPromotions();
?>
<?php
// Fonction pour gérer les campagnes d'email marketing et afficher les statistiques
function gestionCampagnesEmail()
{
    // Code pour gérer les campagnes d'email marketing

    // Simulation de données de statistiques
    $campagne1 = [
        'titre' => 'Nouvelle collection de plats',
        'emails_envoyes' => 1000,
        'emails_ouverts' => 500,
        'taux_ouverture' => (500 / 1000) * 100,
        'clics' => 200,
        'taux_clics' => (200 / 500) * 100,
    ];

    $campagne2 = [
        'titre' => 'Offre spéciale du mois',
        'emails_envoyes' => 800,
        'emails_ouverts' => 400,
        'taux_ouverture' => (400 / 800) * 100,
        'clics' => 150,
        'taux_clics' => (150 / 400) * 100,
    ];

    // Affichage des statistiques des campagnes d'email
    echo "<h3>Statistiques des campagnes d'email marketing :</h3>";
    echo "<h4>" . $campagne1['titre'] . "</h4>";
    echo "<p>Emails envoyés : " . $campagne1['emails_envoyes'] . "</p>";
    echo "<p>Emails ouverts : " . $campagne1['emails_ouverts'] . "</p>";
    echo "<p>Taux d'ouverture : " . $campagne1['taux_ouverture'] . "%</p>";
    echo "<p>Clics : " . $campagne1['clics'] . "</p>";
    echo "<p>Taux de clics : " . $campagne1['taux_clics'] . "%</p>";
    echo "<hr>";

    echo "<h4>" . $campagne2['titre'] . "</h4>";
    echo "<p>Emails envoyés : " . $campagne2['emails_envoyes'] . "</p>";
    echo "<p>Emails ouverts : " . $campagne2['emails_ouverts'] . "</p>";
    echo "<p>Taux d'ouverture : " . $campagne2['taux_ouverture'] . "%</p>";
    echo "<p>Clics : " . $campagne2['clics'] . "</p>";
    echo "<p>Taux de clics : " . $campagne2['taux_clics'] . "%</p>";
}

// Appel de la fonction pour afficher les statistiques des campagnes d'email marketing
gestionCampagnesEmail();
?>

