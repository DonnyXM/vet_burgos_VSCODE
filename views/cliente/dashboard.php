<?php

/**
 * Declaración de variables para el editor de código (IDE).
 * Estas variables son inyectadas por ClienteController.php
 * 
 * @var array $mascotas Lista de mascotas del usuario
 * @var array|bool $proxima_cita Datos de la cita más cercana
 */
?>
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

    <!-- ==========================================
         NUEVO: CABECERA MÓVIL (Solo se ve en móviles)
         ========================================== -->
    <div class="d-md-none bg-white border-bottom p-3 d-flex justify-content-between align-items-center sticky-top shadow-sm">
        <h5 class="m-0 fw-bold text-primary"><i class="fa-solid fa-stethoscope"></i> Vet-Burgos</h5>
        <!-- Botón Hamburguesa -->
        <button class="btn btn-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Contenedor principal -->
    <div class="d-flex vh-100 overflow-hidden">

        <!-- ==========================================
             BARRA LATERAL (Responsive con Offcanvas)
             ========================================== -->
        <!-- Añadimos las clases 'offcanvas-md offcanvas-start' y el ID 'menuLateral' -->
        <div class="offcanvas-md offcanvas-start bg-white border-end d-flex flex-column p-3" tabindex="-1" id="menuLateral" style="width: 280px;">

            <!-- Cabecera del menú solo para móvil (con botón de cerrar X) -->
            <div class="offcanvas-header d-md-none border-bottom mb-3">
                <h5 class="offcanvas-title fw-bold">Menú</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#menuLateral"></button>
            </div>

            <!-- El cuerpo del menú lateral (Lo que ya tenías) -->
            <div class="text-center mb-4 mt-md-3">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario_nombre']); ?>&background=0a2850&color=fff&size=128"
                    class="rounded-circle mb-2 shadow-sm" width="80" alt="Avatar">
                <h6 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h6>
                <small class="text-muted">Propietario</small>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-2">
                <li class="nav-item">
                    <a href="index.php?controller=Cliente&action=dashboard" class="nav-link active bg-primary-subtle text-primary fw-bold rounded-3">
                        <i class="fa-solid fa-border-all me-2"></i> Resumen
                    </a>
                </li>
                <!-- ... tus otros enlaces ... -->
                <li class="nav-item">
                    <a href="index.php?controller=Cita&action=reservar" class="nav-link text-dark nav-hover rounded-3">
                        <i class="fa-regular fa-calendar-check me-2"></i> Reservar Cita
                    </a>
                </li>
            </ul>

            <hr>

            <a href="index.php?controller=Auth&action=logout" class="btn btn-outline-danger w-100 fw-bold rounded-3">
                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Cerrar Sesión
            </a>
        </div>
        <!-- FIN BARRA LATERAL -->

        <!-- ==========================================
             ÁREA DE CONTENIDO PRINCIPAL
             ========================================== -->
        <!-- Cambiamos p-4 por p-3 para que en móvil tenga menos margen y aproveche la pantalla -->
        <div class="flex-grow-1 overflow-auto p-3 p-md-5">

            <!-- ... Aquí va todo el contenido que ya tenías (alertas, mascotas, etc) ... -->

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
                        <!-- Puntito rojo de notificación (decorativo por ahora) -->
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>
                </div>

                <!-- MENSAJE DE ÉXITO AL RESERVAR CITA -->
                <?php if (isset($_GET['cita']) && $_GET['cita'] == 'exito'): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="fa-solid fa-check-circle me-2"></i> ¡Reserva confirmada con éxito!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- MENSAJE DE ÉXITO AL AÑADIR MASCOTA -->
                <?php if (isset($_GET['mascota']) && $_GET['mascota'] == 'exito'): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="fa-solid fa-paw me-2"></i> ¡Nueva mascota añadida a tu familia correctamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- BANNER DE PRÓXIMA CITA (Dinámico) -->
                <?php if ($proxima_cita): ?>
                    <!-- Si hay una cita, mostramos el banner azul con los datos -->
                    <div class="alert alert-primary border-0 shadow-sm rounded-3 mb-5 d-flex align-items-center" role="alert">
                        <i class="fa-regular fa-calendar-check text-primary fs-3 me-3"></i>
                        <div>
                            <h6 class="mb-1 fw-bold text-primary">Próxima Cita Confirmada</h6>
                            <span class="text-dark">
                                <strong><?php echo date('d/m/Y', strtotime($proxima_cita['fecha'])); ?></strong> a las <strong><?php echo date('H:i', strtotime($proxima_cita['hora'])); ?></strong>
                                para <strong><?php echo htmlspecialchars($proxima_cita['mascota_nombre']); ?></strong>
                                (<?php echo htmlspecialchars($proxima_cita['nombre_servicio']); ?>).
                            </span>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Si NO hay citas, mostramos el banner gris oscuro por defecto -->
                    <div class="alert alert-secondary border-0 shadow-sm rounded-3 mb-5 d-flex align-items-center" role="alert">
                        <i class="fa-regular fa-calendar text-secondary fs-3 me-3"></i>
                        <div>
                            <strong class="text-secondary">Próxima Cita:</strong> No tienes citas programadas próximamente.
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ==========================================
                 SECCIÓN MIS MASCOTAS (Dinámica)
                 ========================================== -->
                <h5 class="fw-bold mb-4">Mis Mascotas</h5>

                <div class="row g-4">

                    <?php
                    // Comprobamos si la variable $mascotas está vacía
                    if (empty($mascotas)):
                    ?>
                        <!-- Estado vacío: Si no tiene mascotas -->
                        <div class="col-12">
                            <div class="alert alert-light text-center border p-5 rounded-4 shadow-sm">
                                <i class="fa-solid fa-bone text-muted fa-3x mb-3"></i>
                                <h5 class="fw-bold text-dark">Aún no tienes mascotas registradas</h5>
                                <p class="text-muted">Añade a tu primer compañero peludo haciendo clic en el botón azul de la esquina.</p>
                            </div>
                        </div>

                        <?php
                    // Si tiene mascotas, hacemos un bucle para imprimirlas
                    else:
                        foreach ($mascotas as $mascota):

                            // LÓGICA DE IMÁGENES: Asignamos foto según especie
                            $img_url = 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; // Perro por defecto

                            if (strtolower($mascota['especie']) == 'gato') {
                                $img_url = 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; // Gato
                            } elseif (strtolower($mascota['especie']) == 'exótico' || strtolower($mascota['especie']) == 'exotico') {
                                $img_url = 'https://images.unsplash.com/photo-1425082661705-1834bfd0999c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'; // Exótico
                            }
                        ?>
                            <!-- Tarjeta dinámica de Mascota -->
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 pet-card">
                                    <img src="<?php echo $img_url; ?>" class="card-img-top" alt="Foto de <?php echo htmlspecialchars($mascota['nombre']); ?>" style="height: 200px; object-fit: cover;">
                                    <div class="card-body p-4 text-center">
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
                        endforeach;
                    endif;
                    ?>

                </div>

            </div>
        </div>

        <!-- BOTÓN FLOTANTE PARA AÑADIR MASCOTA (Acción futura) -->
        <a href="index.php?controller=Mascota&action=anadir" class="btn btn-primary rounded-circle shadow-lg d-flex justify-content-center align-items-center position-fixed bottom-0 end-0 m-4 btn-flotante" title="Añadir Mascota">
            <i class="fa-solid fa-plus fs-4"></i>
        </a>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>