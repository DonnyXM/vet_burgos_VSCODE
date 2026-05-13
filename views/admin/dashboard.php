<?php

/**
 * @var array $citas Lista de todas las citas del sistema
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Veterinario - Vet-Burgos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="bg-light">

    <div class="d-md-none bg-dark text-white border-bottom border-secondary p-3 d-flex justify-content-between align-items-center sticky-top shadow-sm">
        <h5 class="m-0 fw-bold"><i class="fa-solid fa-user-doctor me-2"></i> Vet-Burgos Admin</h5>
        <button class="btn btn-outline-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateralAdmin">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div class="d-flex vh-100 overflow-hidden">

        <div class="offcanvas-md offcanvas-start bg-dark text-white d-flex flex-column p-3" tabindex="-1" id="menuLateralAdmin" style="width: 280px;">
            <div class="offcanvas-header d-md-none border-bottom border-secondary mb-3">
                <h5 class="offcanvas-title fw-bold">Menú Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menuLateralAdmin"></button>
            </div>

            <div class="text-center mb-4 mt-md-3">
                <div class="bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-user-doctor fa-2x"></i>
                </div>
                <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h6>
                <small class="text-info">Admin</small>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-2">
                <li class="nav-item">
                    <a href="index.php?controller=Admin&action=dashboard" class="nav-link active bg-primary text-white fw-bold rounded-3">
                        <i class="fa-solid fa-calendar-days me-2"></i> Agenda de Citas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?controller=Admin&action=clientes" class="nav-link text-white opacity-75 nav-hover rounded-3">
                        <i class="fa-solid fa-users me-2"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?controller=Admin&action=pacientes" class="nav-link text-white opacity-75 nav-hover rounded-3">
                        <i class="fa-solid fa-dog me-2"></i> Pacientes
                    </a>
                </li>
            </ul>

            <hr class="border-light opacity-25">

            <a href="index.php?controller=Auth&action=logout" class="btn btn-outline-light w-100 fw-bold rounded-3">
                <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Salir del turno
            </a>
        </div>

        <div class="flex-grow-1 overflow-auto p-3 p-md-5">

            <?php if (isset($_GET['exito'])): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    <?php
                    echo ($_GET['exito'] == 'consulta_finalizada') ? 'Consulta finalizada con éxito.' : 'Cita cancelada correctamente.';
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Gestión de Citas</h3>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Fecha y Hora</th>
                                    <th class="py-3">Cliente</th>
                                    <th class="py-3">Paciente</th>
                                    <th class="py-3">Servicio</th>
                                    <th class="py-3">Estado / Información</th>
                                    <th class="py-3 px-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($citas)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">No hay citas registradas.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($citas as $cita):
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
                                                <div class="fw-bold"><?php echo htmlspecialchars($cita['cliente_nombre']); ?></div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary-subtle text-primary rounded-circle p-2 me-3 d-none d-sm-block">
                                                        <i class="fa-solid fa-paw"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?php echo htmlspecialchars($cita['mascota_nombre']); ?></div>
                                                        <div class="small text-muted">
                                                            <?php echo htmlspecialchars($cita['especie']); ?>
                                                            <?php if (!empty($cita['peso'])): ?> • <?php echo $cita['peso']; ?> kg<?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($cita['nombre_servicio']); ?>
                                                <?php if (!empty($cita['motivo'])): ?>
                                                    <i class="fa-solid fa-circle-info text-info ms-1" title="<?php echo htmlspecialchars($cita['motivo']); ?>" style="cursor: help;"></i>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <span class="badge <?php echo $badge_class; ?> rounded-pill px-3 py-2 mb-1">
                                                    <?php echo $cita['estado']; ?>
                                                </span>
                                                <?php if (!empty($cita['notas_veterinario'])): ?>
                                                    <div class="mt-1 small text-muted" style="max-width: 200px; line-height: 1.2;">
                                                        <i class="fa-solid fa-comment-dots opacity-50 me-1"></i>
                                                        <em><?php echo htmlspecialchars($cita['notas_veterinario']); ?></em>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <td class="px-4 text-center">
                                                <?php if ($cita['estado'] == 'Pendiente'): ?>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <button type="button" class="btn btn-sm btn-outline-success rounded-circle" data-bs-toggle="modal" data-bs-target="#modalFinalizar<?php echo $cita['id_cita']; ?>" title="Finalizar">
                                                            <i class="fa-solid fa-stethoscope"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" data-bs-toggle="modal" data-bs-target="#modalCancelar<?php echo $cita['id_cita']; ?>" title="Cancelar">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small">Cerrada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <div class="modal fade text-start" id="modalFinalizar<?php echo $cita['id_cita']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header border-bottom-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-success"><i class="fa-solid fa-notes-medical me-2"></i>Consulta de <?php echo htmlspecialchars($cita['mascota_nombre']); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <form action="index.php?controller=Admin&action=finalizarConsulta" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                                                            <input type="hidden" name="id_mascota" value="<?php echo $cita['id_mascota']; ?>">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold small">Peso Actual (kg)</label>
                                                                <input type="number" step="0.01" name="peso" class="form-control bg-light border-0" value="<?php echo $cita['peso']; ?>" required>
                                                            </div>
                                                            <div class="mb-2">
                                                                <label class="form-label fw-bold small">Notas Médicas / Diagnóstico</label>
                                                                <textarea name="notas" class="form-control bg-light border-0" rows="4" placeholder="¿Qué se le ha hecho al paciente?" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 pt-0">
                                                            <button type="submit" class="btn btn-success fw-bold w-100 rounded-3">Guardar y Finalizar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade text-start" id="modalCancelar<?php echo $cita['id_cita']; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                                <div class="modal-content rounded-4 border-0 shadow">
                                                    <div class="modal-header border-bottom-0 pb-0">
                                                        <h5 class="modal-title fw-bold text-danger">Anular Cita</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <form action="index.php?controller=Admin&action=cancelarCitaConMotivo" method="POST">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                                                            <div class="mb-2">
                                                                <label class="form-label fw-bold small">Motivo de la cancelación</label>
                                                                <textarea name="motivo_cancelacion" class="form-control bg-light border-0" rows="3" placeholder="Ej: El cliente llamó para anular..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-top-0 pt-0">
                                                            <button type="submit" class="btn btn-danger fw-bold w-100 rounded-3">Confirmar Cancelación</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>