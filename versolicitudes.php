<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garantías - Samsung Style</title>
    <style>
    /* Estilos generales */
    body {
            background-image: url('images/imgfon1.avif');
            background-size: cover;
            color: #fff;
        }

    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Navbar */
    .navbar {
        background-color: #003c71; /* Color azul oscuro de Samsung */
        color: white;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar h1 {
        margin: 0;
        font-size: 1.5em;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
        font-weight: bold;
    }

    .navbar a:hover {
        text-decoration: underline;
    }

    /* Contenedor de cards */
    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
    }

    /* Card */
    .card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        margin: 15px;
        width: 350px;
        overflow: hidden;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card-body {
        padding: 25px;
    }

    .card-title {
        font-size: 1.5em;
        color: #003c71;
        margin: 0 0 15px;
    }

    .card-text {
        font-size: 1em;
        margin: 10px 0;
    }

    .card-text strong {
        color: #0073e6;
    }

    /* Formulario de edición */
    .edit-form {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        margin: 15px;
        padding: 20px;
        width: 350px;
    }

    .edit-form label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .edit-form input, .edit-form select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .edit-form button {
        background-color: #003c71;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1em;
    }

    .edit-form button:hover {
        background-color: #002a54;
    }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>Samsung Electronics</h1>
        <div>
            <a href="principal.php">Inicio</a>
            <a href="formulario2.php">Registrar garantia</a>
            <a href="archivos.php">Subir archivos</a>
        </div>
    </div>

    <!-- Contenedor de cards -->
    <div class="container">
        <?php
        // Configuración de conexión a la base de datos
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

        // Consulta para obtener datos de la tabla garantia
        $sql = "SELECT Nombre, numero, fecha, tipo FROM garantia";
        $result = $conn->query($sql);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Mostrar datos en la card
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row["Nombre"]) . '</h5>';
                echo '<p class="card-text"><strong>Número:</strong> ' . htmlspecialchars($row["numero"]) . '</p>';
                echo '<p class="card-text"><strong>Fecha:</strong> ' . htmlspecialchars($row["fecha"]) . '</p>';
                echo '<p class="card-text"><strong>Tipo:</strong> ' . htmlspecialchars($row["tipo"]) . '</p>';
                echo '<a href="?edit=' . htmlspecialchars($row["numero"]) . '" class="btn btn-primary">Editar</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No se encontraron resultados.</p>';
        }

        // Procesar la actualización de datos
        if (isset($_POST['update'])) {
            $nombre = $_POST['Nombre'];
            $numero = $_POST['numero'];
            $fecha = $_POST['fecha'];
            $tipo = $_POST['tipo'];

            $updateSql = "UPDATE garantia SET Nombre=?, fecha=?, tipo=? WHERE numero=?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param('ssis', $nombre, $fecha, $tipo, $numero);
            
            if ($stmt->execute()) {
                echo '<p>Datos actualizados con éxito.</p>';
            } else {
                echo '<p>Error al actualizar los datos.</p>';
            }
        }

        // Mostrar formulario de edición si se ha seleccionado un número
        if (isset($_GET['edit'])) {
            $editNumero = $_GET['edit'];
            $editSql = "SELECT Nombre, numero, fecha, tipo FROM garantia WHERE numero=?";
            $stmt = $conn->prepare($editSql);
            $stmt->bind_param('i', $editNumero);
            $stmt->execute();
            $result = $stmt->get_result();
            $editRow = $result->fetch_assoc();

            if ($editRow) {
                echo '<div class="edit-form">';
                echo '<h2>Editar Garantía</h2>';
                echo '<form action="" method="POST">';
                echo '<label for="Nombre">Nombre:</label>';
                echo '<input type="text" id="Nombre" name="Nombre" value="' . htmlspecialchars($editRow['Nombre']) . '" required>';
                echo '<input type="hidden" name="numero" value="' . htmlspecialchars($editRow['numero']) . '">';
                echo '<label for="fecha">Fecha:</label>';
                echo '<input type="date" id="fecha" name="fecha" value="' . htmlspecialchars($editRow['fecha']) . '" required>';
                echo '<label for="tipo">Tipo:</label>';
                echo '<select id="tipo" name="tipo" required>';
                echo '<option value="Garantía estándar"' . ($editRow['tipo'] == 'Garantía estándar' ? ' selected' : '') . '>Garantía estándar</option>';
                echo '<option value="Garantía extendida"' . ($editRow['tipo'] == 'Garantía extendida' ? ' selected' : '') . '>Garantía extendida</option>';
                echo '</select>';
                echo '<button type="submit" name="update">Actualizar</button>';
                echo '</form>';
                echo '</div>';
            }
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </div>
</body>
</html>
