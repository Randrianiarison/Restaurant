<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un employé</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .card {
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 10px;
            display: none;
        }
        .btn-ajouter {
            background-color: #007bff;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .btn-ajouter:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-body">
            <h1 class="mb-4">Ajouter un employé</h1>
            <form id="employeeForm">
                <div class="form-group">
                    <label for="nom" class="form-label">Nom:</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="poste" class="form-label">Poste:</label>
                    <input type="text" name="poste" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="date_embauche" class="form-label">Date d'embauche:</label>
                    <input type="date" name="date_embauche" class="form-control" required>
                </div>
                <button type="button" class="btn btn-primary btn-ajouter" onclick="ajouterEmploye()">Ajouter</button>
            </form>
            <p class="success-message" id="successMessage">Employé ajouté avec succès.</p>
        </div>
    </div>

    <script>
        function ajouterEmploye() {
            const form = document.getElementById("employeeForm");
            const successMessage = document.getElementById("successMessage");

            const formData = new FormData(form);
            fetch("<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>", {
                method: "POST",
                body: formData
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        showSuccessMessage();
                        form.reset();
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        function showSuccessMessage() {
            const successMessage = document.getElementById("successMessage");
            successMessage.style.display = "block";
            setTimeout(() => {
                successMessage.style.display = "none";
            }, 3000);
        }
    </script>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $poste = $_POST["poste"];
    $date_embauche = $_POST["date_embauche"];

    $conn = new mysqli('localhost', 'johns', 'admin', 'restaurants');
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO employer (nom, poste, date_embauche) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $poste, $date_embauche);

    $response = array();
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = "Erreur lors de l'ajout de l'employé : " . $conn->error;
    }
    $stmt->close();
    $conn->close();

    echo json_encode($response);
}
?>
