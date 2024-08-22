<?php
    require_once 'db_conexion.php';
    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Samsung Styled Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
           body {
            background-image: url('images/imgfon1.avif');
            background-size: cover;
            color: #fff;
        }

        
        nav {
            background-color: #1428a0;
        }
        
        nav a.navbar-brand {
            color: #fff;
            font-weight: bold;
        }

        nav a.nav-link {
            color: #fff;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        .card {
            margin-bottom: 20px;
            background-color: #fff;
            color: #000;
            border: 1px solid #ddd;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .card-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .card-text {
            font-size: 16px;
            margin-bottom: 20px;
        }
        
        .card-link {
            color: #1428a0;
            font-weight: bold;
            text-decoration: none;
        }
        
        .card-link:hover {
            text-decoration: underline;
        }

        .carousel-item img {
            height: 300px;
            object-fit: cover;
        }

        footer {
            background-color: #1428a0;
            color: #fff;
            padding: 20px 0;
            margin-top: 30px;
            text-align: center;
        }

        footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        footer a:hover {
            text-decoration: underline;
        }
        footer .social-icons {
    margin: 10px 0;
}

footer .social-icons a {
    font-size: 24px;
    color: #fff;
    text-decoration: none;
}

footer .social-icons a:hover {
    color: #ddd;
}

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Samsung Electronics</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php
                if (isset($_SESSION['nombre']) && isset($_SESSION['email'])) {
                    $nombre = $_SESSION['nombre'];
                    $email = $_SESSION['email'];
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="versolicitudes.php">Ver tus Garantias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="formulario2.php">Solicitar Garantias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="datosusuario.php">Datos de Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="archivos.php">Subir archivos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="document.querySelector(\'form[name=\\\'logout-form\\\']\').submit(); return false;">Cerrar Sesión</a>
                            <form name="logout-form" action="" method="post" style="display: none;">
                                <input type="hidden" name="cerrar_sesion">
                            </form>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">Bienvenido, ' . $nombre . '</span>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">' . $email . '</span>
                        </li>
                    ';
                } else {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="formulario.php">Crear Cuenta</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar Sesión</a>
                        </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Samsung Galaxy S23</h5>
                    <p class="card-text">Experimenta el rendimiento superior y la tecnología de vanguardia con el nuevo Samsung Galaxy S23.</p>
                    <a href="#" class="card-link">Ver detalles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Samsung QLED TV</h5>
                    <p class="card-text">Disfruta de una calidad de imagen impresionante y una experiencia de entretenimiento inigualable con nuestra línea QLED TV.</p>
                    <a href="#" class="card-link">Ver detalles</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Samsung Galaxy Tab S9</h5>
                    <p class="card-text">Potencia y versatilidad en una tablet: el Samsung Galaxy Tab S9 está diseñado para tu productividad y entretenimiento.</p>
                    <a href="#" class="card-link">Ver detalles</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-block w-100 bg-primary text-white d-flex align-items-center justify-content-center" style="height: 400px;">
                            <h2 class="text-center">Innovación en Smartphones</h2>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-block w-100 bg-success text-white d-flex align-items-center justify-content-center" style="height: 400px;">
                            <h2 class="text-center">Televisores con Calidad 4K</h2>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-block w-100 bg-danger text-white d-flex align-items-center justify-content-center" style="height: 400px;">
                            <h2 class="text-center">Tablets para Profesionales</h2>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Soporte Técnico</h5>
                    <p class="card-text">Asistencia especializada para resolver cualquier problema con tus dispositivos Samsung.</p>
                    <a href="#" class="card-link">Contactar</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Seguridad de Datos</h5>
                    <p class="card-text">Protección avanzada para asegurar la privacidad y seguridad de tu información en todos los dispositivos Samsung.</p>
                    <a href="#" class="card-link">Saber más</a>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 Samsung Electronics. Todos los derechos reservados.</p>
    <div class="social-icons">
        <a href="https://www.facebook.com/samsung" target="_blank" class="text-white me-3">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com/samsung" target="_blank" class="text-white me-3">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="https://www.instagram.com/samsung" target="_blank" class="text-white me-3">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.linkedin.com/company/samsung-electronics" target="_blank" class="text-white">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
    <p class="mt-3">
        <a href="#" class="text-white">Términos y Condiciones</a> | 
        <a href="#" class="text-white">Política de Privacidad</a> | 
        <a href="#" class="text-white">Contáctanos</a>
    </p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
