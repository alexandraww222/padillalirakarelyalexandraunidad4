<?php
// Inicio de sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['email'])) {
    die("No estás autenticado. <a href='login.php'>Inicia sesión</a>");
}

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

// Obtener el email del usuario desde la sesión
$user_email = $_SESSION['email'];

// Consulta para obtener datos del usuario
$sql = "SELECT email, nombre, ciudad, clave FROM usuarios WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user_email);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("No se encontraron datos para el usuario.");
}

// Manejar la actualización de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $ciudad = $_POST['ciudad'];
    $clave = $_POST['clave'];

    // Actualizar los datos del usuario en la base de datos
    $update_sql = "UPDATE usuarios SET nombre=?, ciudad=?, clave=? WHERE email=?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('ssss', $nombre, $ciudad, $clave, $user_email);
    $update_stmt->execute();

    // Confirmar la actualización
    if ($update_stmt->affected_rows > 0) {
        $user['nombre'] = $nombre;
        $user['ciudad'] = $ciudad;
        $user['clave'] = $clave;
        echo "<p>Datos actualizados con éxito.</p>";
    } else {
        echo "<p>No se pudieron actualizar los datos.</p>";
    }

    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Samsung Style</title>
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
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px;
        width: 350px;
    }

    .edit-form input {
        width: calc(100% - 20px);
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .edit-form button {
        background-color: #003c71;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1em;
    }

    .edit-form button:hover {
        background-color: #00509e;
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
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($user['nombre']); ?></h5>
                <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p class="card-text"><strong>Ciudad:</strong> <?php echo htmlspecialchars($user['ciudad']); ?></p>
                <p class="card-text"><strong>Clave:</strong> <?php echo htmlspecialchars($user['clave']); ?></p>
            </div>
        </div>
    </div>

    <!-- Formulario de edición -->
    <div class="container">
        <div class="edit-form">
            <h2>Editar Información</h2>
            <form action="" method="post">
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" placeholder="Nombre" required>
                <input type="text" name="ciudad" value="<?php echo htmlspecialchars($user['ciudad']); ?>" placeholder="Ciudad" required>
                <input type="password" name="clave" value="<?php echo htmlspecialchars($user['clave']); ?>" placeholder="Clave" required>
                <button type="submit">Actualizar Datos</button>
            </form>
        </div>
    </div>
</body>
</html>
