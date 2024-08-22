<?php
require_once 'db_conexion.php';

if (isset($_POST['guardar'])) {
    $nombre_usuario = $_POST['nombre'];
    $numero = $_POST['numero'];
    $fecha = $_POST['fecha'];
    $tipo = $_POST['tipo'];

    if (!empty($nombre_usuario) && !empty($numero) && !empty($fecha) && !empty($tipo)) {
        $insertQuery = $cnnPDO->prepare("INSERT INTO garantia (nombre, numero, fecha, tipo) VALUES (:nombre, :numero, :fecha, :tipo)");

        $insertQuery->bindParam(':nombre', $nombre_usuario);
        $insertQuery->bindParam(':numero', $numero);
        $insertQuery->bindParam(':fecha', $fecha);
        $insertQuery->bindParam(':tipo', $tipo);

        if ($insertQuery->execute()) {
            $to = 'cliente@example.com'; 
            $subject = "Registro de Garantía Recibido";
            $message = '<html>
            <body>  
                <h1>Registro de Garantía Recibido</h1>
                <p>Tu registro de garantía ha sido recibido.</p>
                <p><b>Nombre de Usuario:</b> ' . htmlspecialchars($nombre_usuario) . '</p>
                <p><b>Número:</b> ' . htmlspecialchars($numero) . '</p>
                <p><b>Fecha:</b> ' . htmlspecialchars($fecha) . '</p>
                <p><b>Tipo:</b> ' . htmlspecialchars($tipo) . '</p>
            </body>
            </html>';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
            $headers .= "From: ROCKET@email.com" . "\r\n";
            mail($to, $subject, $message, $headers);
            header('Location: principal.php');
            exit(); 
        } else {
            $error_message = 'Error al enviar el registro de garantía.';
        }
    } else {
        $error_message = 'Por favor complete todos los campos.';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Garantía</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
          body {
            background-image: url('images/imgfon1.avif');
            background-size: cover;
            color: #fff;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-card {
            background-color: #f8f9fa;
            color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #111;
        }
        button[type="submit"] {
            background-color: #0033a0;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #002670;
        }
        
        .navbar {
            background-color: #0033a0; 
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #fff; 
        }

        .navbar-nav .nav-link:hover {
            color: #cfcfcf; 
        }

        .alert {
            border-radius: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="#">Samsung Garantías</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="principal.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="versolicitudes.php">Ver Garantías</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="formulario2.php">Registrar Garantía</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container">
        <div class="form-card">
            <h2 class="text-center">Registro de Garantía</h2>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <form action="" method="post">
                <div class="form-group">
                    <label for="nombre">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre de usuario" required>
                </div>

                <div class="form-group">
                    <label for="numero">Número de serie del producto:</label>
                    <input type="text" class="form-control" id="numero" name="numero" placeholder="Ingrese el numero de serie" required>
                </div>

                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Garantía:</label>
                    <select class="form-control" id="tipo" name="tipo" required>
                        <option value="producto">Garantia Estandar</option>
                        <option value="servicio">Garantia Extendida</option>
                    </select>
                </div>

                <button type="submit" name="guardar" class="btn btn-primary btn-custom">Registrar Garantía</button>

            </form>
        </div>
    </div>
</body>
</html>
