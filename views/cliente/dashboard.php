<!-- views/cliente/dashboard.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel - Vet-Burgos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tu archivo CSS personalizado -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <!-- Contenedor principal: Usamos Flexbox para dividir la pantalla (Sidebar + Contenido) -->
    <div class="d-flex vh-100 overflow-hidden">

        <!-- ==========================================
             BARRA LATERAL (SIDEBAR) - 280px de ancho
             ========================================== -->
        <div class="bg-white border-end d-flex flex-column p-3 sidebar" style="width: 280px;">

            <!-- Perfil del usuario -->
            <div class="text-center mb-4 mt-3">
                <!-- Usamos una API gratuita que genera un avatar con la inicial del nombre del usuario -->
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario_nombre']); ?>&background=0a2850&color=fff&size=128"
                    class="rounded-circle mb-2 shadow-sm" width="80" alt="Avatar">
                <h6 class="fw-bold mb-0 text-dark"><?php echo $_SESSION['usuario_nombre']; ?></h6>
                <small class="text-muted">Propietario</small>
            </div>

            <!-- Menú de navegación lateral -->
            <ul class="nav nav-pills flex-column mb-auto gap-2">
                <li class="nav-item">
                    <a href="#" class="nav-link active bg-primary-subtle text-primary fw-bold rounded-3">
                        <i class="fa-solid fa-border-all me-2"></i> Resumen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark nav-hover rounded-3">
                        <i class="fa-solid fa-paw me-2"></i> Mis Mascotas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark nav-hover rounded-3">
                        <i class="fa-regular fa-calendar-check me-2"></i> Reservar Cita
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-dark nav-hover rounded-3">
                        <i class="fa-solid fa-file-medical me-2"></i> Historial Médico
                    </a>
                </li>
            </ul>

            <hr>

            <!-- Botón de Cerrar Sesión (empujado abajo gracias a mb-auto arriba) -->
            <a href="index.php?controller=Auth&action=logout" class="btn btn-outline-danger w-100 fw-bold rounded-3">
                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Cerrar Sesión
            </a>
        </div>

        <!-- ==========================================
             ÁREA DE CONTENIDO PRINCIPAL
             ========================================== -->
        <div class="flex-grow-1 overflow-auto p-4 p-md-5">

            <!-- Cabecera del panel -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Panel de Control</h3>
                <!-- Icono de notificaciones -->
                <button class="btn btn-light position-relative rounded-circle shadow-sm border" style="width: 45px; height: 45px;">
                    <i class="fa-regular fa-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </button>
            </div>

            <!-- Alerta de próxima cita (Bloque azul del mockup) -->
            <div class="alert alert-primary border-0 shadow-sm rounded-3 mb-5 d-flex align-items-center" role="alert">
                <i class="fa-regular fa-calendar text-primary fs-4 me-3"></i>
                <div>
                    <strong class="text-primary">Próxima Cita:</strong> No tienes citas programadas próximamente.
                </div>
            </div>

            <!-- Sección Mis Mascotas -->
            <h5 class="fw-bold mb-4">Mis Mascotas</h5>

            <div class="row g-4">

                <?php
                // Comprobamos si la variable $mascotas (que viene del controlador) está vacía
                if (empty($mascotas)):
                ?>
                    <!-- Si no tiene mascotas, mostramos este mensaje amigable -->
                    <div class="col-12">
                        <div class="alert alert-light text-center border p-5 rounded-4 shadow-sm">
                            <i class="fa-solid fa-bone text-muted fa-3x mb-3"></i>
                            <h5 class="fw-bold text-dark">Aún no tienes mascotas registradas</h5>
                            <p class="text-muted">Añade a tu primer compañero peludo haciendo clic en el botón azul de la esquina.</p>
                        </div>
                    </div>

                    <?php
                // Si tiene mascotas, hacemos un bucle para recorrerlas una a una
                else:
                    foreach ($mascotas as $mascota):

                        // LÓGICA DE IMÁGENES: Asignamos una foto por defecto según la especie
                        $img_url = 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; // Perro por defecto

                        // strtolower convierte el texto a minúsculas para comparar sin fallos
                        if (strtolower($mascota['especie']) == 'gato') {
                            $img_url = 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; // Gato
                        } elseif (strtolower($mascota['especie']) == 'exótico' || strtolower($mascota['especie']) == 'exotico') {
                            $img_url = 'https://images.unsplash.com/photo-1425082661705-1834bfd0999c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; // Exótico (pájaro/conejo)
                        }
                    ?>
                        <!-- Tarjeta dinámica de Mascota -->
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 pet-card">
                                <img src="<?php echo $img_url; ?>" class="card-img-top" alt="Foto de <?php echo htmlspecialchars($mascota['nombre']); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-4 text-center">
                                    <!-- htmlspecialchars() es crucial en seguridad web para evitar ataques XSS (inyección de scripts en HTML) -->
                                    <h5 class="fw-bold mb-0 text-capitalize"><?php echo htmlspecialchars($mascota['nombre']); ?></h5>

                                    <p class="text-muted small mb-3">
                                        <?php echo htmlspecialchars($mascota['especie']); ?>
                                        <?php if (!empty($mascota['raza'])) echo ' - ' . htmlspecialchars($mascota['raza']); ?>
                                    </p>

                                    <a href="#" class="btn btn-outline-dark w-100 rounded-pill">Ver Historial</a>
                                </div>
                            </div>
                        </div>

                <?php
                    // Cerramos el foreach y el else
                    endforeach;
                endif;
                ?>

            </div>

        </div>
    </div>

    <!-- BOTÓN FLOTANTE PARA AÑADIR MASCOTA -->
    <a href="#" class="btn btn-primary rounded-circle shadow-lg d-flex justify-content-center align-items-center position-fixed bottom-0 end-0 m-4 btn-flotante" title="Añadir Mascota">
        <i class="fa-solid fa-plus fs-4"></i>
    </a>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>