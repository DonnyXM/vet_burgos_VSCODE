<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vet-Burgos - Tu clínica veterinaria</title>
    <!-- Bootstrap 5 CSS (vía CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tu archivo CSS personalizado -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Menú de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="index.php">
                <i class="fa-solid fa-stethoscope"></i> Vet-Burgos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
                </ul>
                <div class="d-flex gap-2 align-items-center">
                    <?php
                    // Comprobamos si existe la variable de sesión 'usuario_id'
                    if (isset($_SESSION['usuario_id'])):
                    ?>
                        <!-- SI EL USUARIO ESTÁ LOGUEADO -->
                        <span class="text-muted me-3 fw-bold">
                            <i class="fa-solid fa-user-circle"></i> ¡Hola, <?php echo $_SESSION['usuario_nombre']; ?>!
                        </span>

                        <!-- Botón para ir a su panel (Aún no lo hemos creado, pero dejamos el enlace listo) -->
                        <a href="index.php?controller=Cliente&action=dashboard" class="btn btn-outline-primary">Mi Panel</a>

                        <!-- Botón para cerrar sesión -->
                        <a href="index.php?controller=Auth&action=logout" class="btn btn-danger">Cerrar Sesión</a>

                    <?php else: ?>
                        <!-- SI EL USUARIO NO ESTÁ LOGUEADO (Visitante normal) -->
                        <a href="index.php?controller=Auth&action=login" class="btn btn-outline-dark">Iniciar Sesión</a>
                        <a href="index.php?controller=Auth&action=registro" class="btn btn-dark">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mensajes de Alerta -->
    <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exito'): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <strong>¡Registro completado!</strong> Tu cuenta y la de tu mascota se han creado correctamente. Ya puedes iniciar sesión.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Sección Principal (Hero Banner) -->
    <header class="hero-section text-center text-white d-flex align-items-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Tu clínica veterinaria de confianza</h1>
            <p class="lead mb-4">Cuidamos de tus mascotas con profesionalismo, dedicación y cariño.</p>
            <a href="index.php?controller=Auth&action=registro" class="btn btn-dark btn-lg px-4 rounded-pill">Reservar una Cita</a>
        </div>
    </header>

    <!-- Sección de Servicios -->
    <section id="servicios" class="py-5 bg-light">
        <div class="container py-4">
            <h2 class="text-center fw-bold mb-5">Nuestros Servicios</h2>
            <div class="row g-4">
                <!-- Servicio 1 -->
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4 border-0 shadow-sm custom-card">
                        <div class="icon-box mx-auto mb-3 text-primary bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-syringe fa-2x"></i>
                        </div>
                        <h4 class="card-title fw-bold">Vacunación</h4>
                        <p class="card-text text-muted">Programas completos de vacunación para mantener a tu mascota protegida contra enfermedades comunes.</p>
                    </div>
                </div>
                <!-- Servicio 2 -->
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4 border-0 shadow-sm custom-card">
                        <div class="icon-box mx-auto mb-3 text-success bg-success-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-notes-medical fa-2x"></i>
                        </div>
                        <h4 class="card-title fw-bold">Cirugía</h4>
                        <p class="card-text text-muted">Procedimientos quirúrgicos especializados realizados por veterinarios certificados con equipamiento moderno.</p>
                    </div>
                </div>
                <!-- Servicio 3 -->
                <div class="col-md-4">
                    <div class="card h-100 text-center p-4 border-0 shadow-sm custom-card">
                        <div class="icon-box mx-auto mb-3 text-info bg-info-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-scissors fa-2x"></i>
                        </div>
                        <h4 class="card-title fw-bold">Peluquería</h4>
                        <p class="card-text text-muted">Servicios profesionales de aseo y estética para mantener a tu mascota limpia, cómoda y saludable.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>