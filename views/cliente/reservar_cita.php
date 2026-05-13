<!-- views/cliente/reservar.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Cita - Vet-Burgos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <!-- ==========================================
         CABECERA MÓVIL (Solo se ve en móviles)
         ========================================== -->
    <div class="d-md-none bg-white border-bottom p-3 d-flex justify-content-between align-items-center sticky-top shadow-sm">
        <h5 class="m-0 fw-bold text-primary"><i class="fa-solid fa-stethoscope"></i> Vet-Burgos</h5>
        <!-- Botón Hamburguesa -->
        <button class="btn btn-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div class="d-flex vh-100 overflow-hidden">

        <!-- ==========================================
             BARRA LATERAL (Responsive con Offcanvas)
             ========================================== -->
        <div class="offcanvas-md offcanvas-start bg-white border-end d-flex flex-column p-3" tabindex="-1" id="menuLateral" style="width: 280px;">

            <div class="offcanvas-header d-md-none border-bottom mb-3">
                <h5 class="offcanvas-title fw-bold">Menú</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#menuLateral"></button>
            </div>

            <div class="text-center mb-4 mt-md-3">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['usuario_nombre']); ?>&background=0a2850&color=fff&size=128"
                    class="rounded-circle mb-2 shadow-sm" width="80" alt="Avatar">
                <h6 class="fw-bold mb-0 text-dark"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h6>
                <small class="text-muted">Propietario</small>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-2">
                <li class="nav-item">
                    <a href="index.php?controller=Cliente&action=dashboard" class="nav-link text-dark nav-hover rounded-3">
                        <i class="fa-solid fa-border-all me-2"></i> Resumen
                    </a>
                </li>
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

        <!-- ==========================================
             ÁREA DE CONTENIDO PRINCIPAL
             ========================================== -->
        <div class="flex-grow-1 overflow-auto p-3 p-md-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Programar Nueva Cita</h3>
            </div>

            <!-- Contenedor del formulario centrado -->
            <div class="row">
                <div class="col-12 col-xl-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">

                            <p class="text-muted mb-4">Rellena el siguiente formulario para solicitar una visita a nuestra clínica. Te confirmaremos la reserva al instante.</p>

                            <!-- FORMULARIO DE RESERVA -->
                            <form action="index.php?controller=Cita&action=guardar" method="POST">

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">¿Para qué mascota es?</label>
                                        <select name="id_mascota" class="form-select bg-light border-0 py-2" required>
                                            <option value="" disabled selected>Selecciona tu mascota...</option>
                                            <!-- Bucle de mascotas -->
                                            <?php foreach ($mascotas as $mascota): ?>
                                                <option value="<?php echo $mascota['id_mascota']; ?>">
                                                    <?php echo htmlspecialchars($mascota['nombre']); ?> (<?php echo htmlspecialchars($mascota['especie']); ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Servicio requerido</label>
                                        <select name="id_servicio" class="form-select bg-light border-0 py-2" required>
                                            <option value="" disabled selected>Selecciona un servicio...</option>
                                            <!-- Bucle de servicios -->
                                            <?php foreach ($servicios as $servicio): ?>
                                                <option value="<?php echo $servicio['id_servicio']; ?>">
                                                    <?php echo htmlspecialchars($servicio['nombre_servicio']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Fecha deseada</label>
                                        <!-- El min de HTML5 evita que se seleccionen fechas del pasado -->
                                        <input type="date" name="fecha" class="form-control bg-light border-0 py-2" min="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small">Hora</label>
                                        <input type="time" name="hora" class="form-control bg-light border-0 py-2" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold small">Motivo de la consulta (Opcional)</label>
                                    <textarea name="motivo" class="form-control bg-light border-0" rows="3" placeholder="Describe brevemente los síntomas o el motivo de tu visita..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                    <i class="fa-regular fa-calendar-check me-2"></i> Confirmar Reserva
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS (necesario para el menú móvil) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>