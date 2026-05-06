<?php

/**
 * Declaración de variables para el editor de código (IDE).
 * @var array $citas Lista de todas las citas del sistema
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Veterinario - Vet-Burgos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <div class="d-flex vh-100 overflow-hidden">

        <!-- ==========================================
             BARRA LATERAL (SIDEBAR) VETERINARIO
             ========================================== -->
        <div class="bg-dark text-white d-flex flex-column p-3 sidebar" style="width: 280px;">

            <div class="text-center mb-4 mt-3">
                <div class="bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-user-doctor fa-2x"></i>
                </div>
                <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h6>
                <small class="text-info">Veterinario / Admin</small>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-2">
                <li class="nav-item">
                    <a href="index.php?controller=Admin&action=dashboard" class="nav-link active bg-primary text-white fw-bold rounded-3">
                        <i class="fa-solid fa-calendar-days me-2"></i> Agenda de Citas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white opacity-75 nav-hover rounded-3">
                        <i class="fa-solid fa-users me-2"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white opacity-75 nav-hover rounded-3">
                        <i class="fa-solid fa-dog me-2"></i> Pacientes
                    </a>
                </li>
            </ul>

            <hr class="border-light opacity-25">

            <a href="index.php?controller=Auth&action=logout" class="btn btn-outline-light w-100 fw-bold rounded-3">
                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Salir del turno
            </a>
        </div>

        <!-- ==========================================
             ÁREA DE CONTENIDO PRINCIPAL
             ========================================== -->
        <div class="flex-grow-1 overflow-auto p-4 p-md-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Gestión de Citas</h3>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Fecha y Hora</th>
                                    <th class="py-3">Cliente</th>
                                    <th class="py-3">Paciente</th>
                                    <th class="py-3">Servicio</th>
                                    <th class="py-3">Estado</th>
                                    <th class="py-3 px-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($citas)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            No hay citas registradas en el sistema.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($citas as $cita):
                                        // Configuración de colores para los estados
                                        $badge_class = 'bg-warning text-dark';
                                        if ($cita['estado'] == 'Completada') $badge_class = 'bg-success';
                                        if ($cita['estado'] == 'Cancelada') $badge_class = 'bg-danger';
                                    ?>
                                        <tr>
                                            <td class="py-3 px-4">
                                                <div class="fw-bold"><?php echo date('d/m/Y', strtotime($cita['fecha'])); ?></div>
                                                <div class="small text-muted"><?php echo date('H:i', strtotime($cita['hora'])); ?></div>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($cita['cliente_nombre']); ?>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($cita['mascota_nombre']); ?></strong>
                                                <span class="text-muted small">(<?php echo htmlspecialchars($cita['especie']); ?>)</span>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($cita['nombre_servicio']); ?>
                                                <?php if (!empty($cita['motivo'])): ?>
                                                    <i class="fa-solid fa-circle-info text-info ms-1" title="<?php echo htmlspecialchars($cita['motivo']); ?>" style="cursor: help;"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge <?php echo $badge_class; ?> rounded-pill px-3 py-2">
                                                    <?php echo $cita['estado']; ?>
                                                </span>
                                            </td>
                                            <td class="px-4 text-center">
                                                <?php if ($cita['estado'] == 'Pendiente'): ?>
                                                    <!-- Botón para Completar -->
                                                    <a href="index.php?controller=Admin&action=cambiarEstado&id=<?php echo $cita['id_cita']; ?>&estado=Completada" class="btn btn-sm btn-outline-success rounded-circle me-1" title="Marcar como Completada">
                                                        <i class="fa-solid fa-check"></i>
                                                    </a>
                                                    <!-- Botón para Cancelar -->
                                                    <a href="index.php?controller=Admin&action=cambiarEstado&id=<?php echo $cita['id_cita']; ?>&estado=Cancelada" class="btn btn-sm btn-outline-danger rounded-circle" title="Cancelar Cita">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">Cerrada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS (necesario para los tooltips) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>