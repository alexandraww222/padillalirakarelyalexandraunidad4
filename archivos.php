<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_electronic";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se han enviado archivos
if (isset($_FILES['files'])) {
    $fileCount = count($_FILES['files']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $_FILES['files']['name'][$i];
        $fileTmpName = $_FILES['files']['tmp_name'][$i];
        $fileSize = $_FILES['files']['size'][$i];
        $fileError = $_FILES['files']['error'][$i];
        $fileType = $_FILES['files']['type'][$i];

        // Verificar si el archivo se ha subido correctamente
        if ($fileError === UPLOAD_ERR_OK) {
            // Leer el contenido del archivo
            $fileContent = file_get_contents($fileTmpName);
            $fileContent = $conn->real_escape_string($fileContent);
            
            // Consulta para insertar el archivo en la base de datos
            $sql = "INSERT INTO archivos (nombre, tipo, contenido) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $fileName, $fileType, $fileContent);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Archivo '$fileName' subido exitosamente.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al subir el archivo '$fileName': " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error al subir el archivo '$fileName': " . $fileError . "</div>";
        }
    }
} else {
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos - Samsung Electronics</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-image: url('images/imgfon1.avif');
            background-size: cover;
            color: #fff;
        }

        .navbar-custom {
            background-color: #003c71; /* Color azul Samsung */
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-nav .nav-link {
            color: #ffffff; 
        }
        .navbar-custom .navbar-brand:hover,
        .navbar-custom .navbar-nav .nav-link:hover {
            color: #d9d9d9; 
        }
        .container {
            padding: 2rem;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #003c71;
            color: #ffffff;
            border-bottom: none;
            font-size: 1.5rem;
            text-align: center;
            padding: 1rem;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-primary {
            background-color: #003c71;
            border-color: #003c71;
        }
        .btn-primary:hover {
            background-color: #00509e;
            border-color: #004085;
        }
        .form-control-file {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">Samsung Electronics</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="principal.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="versolicitudes.php">Ver solicitudes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="datosusuario.php">Datos de usuario</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                Subir Archivos
            </div>
            <div class="card-body">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="files">Selecciona archivos:</label>
                        <input type="file" class="form-control-file" id="files" name="files[]" multiple>
                    </div>
                    <button type="submit" name="guardar" class="btn btn-primary btn-block">Subir Archivos</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
