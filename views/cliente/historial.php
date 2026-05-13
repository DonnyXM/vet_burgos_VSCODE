<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Médico - Vet-Burgos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="d-md-none bg-white border-bottom p-3 d-flex justify-content-between align-items-center sticky-top shadow-sm">
        <h5 class="m-0 fw-bold text-primary"><i class="fa-solid fa-stethoscope"></i> Vet-Burgos</h5>
        <button class="btn btn-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <div class="d-flex vh-100 overflow-hidden">

        <div class="flex-grow-1 overflow-auto p-3 p-md-5">

            <div class="d-flex align-items-center mb-4">
                <a href="index.php?controller=Cliente&action=dashboard" class="btn btn-light border me-3 rounded-circle">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h3 class="fw-bold mb-0">Historial Médico de <?php echo htmlspecialchars($mascota['nombre']); ?></h3>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                        <div class="mb-3">
                            <i class="fa-solid fa-paw fa-4x text-primary opacity-50"></i>
                        </div>
                        <h4 class="fw-bold"><?php echo htmlspecialchars($mascota['nombre']); ?></h4>
                        <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill mb-3">
                            <?php echo htmlspecialchars($mascota['especie']); ?>
                        </span>
                        <ul class="list-group list-group-flush text-start mt-3">
                            <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                                <span class="text-muted">Raza</span>
                                <span class="fw-bold"><?php echo htmlspecialchars($mascota['raza']); ?></span>
                            </li>
                            <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                                <span class="text-muted">Total Visitas</span>
                                <span class="fw-bold"><?php echo count($historial); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-xl-8">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom p-4">
                            <h5 class="fw-bold m-0"><i class="fa-solid fa-file-medical me-2 text-primary"></i> Registro de Intervenciones</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="py-3 px-4">Fecha</th>
                                            <th class="py-3">Servicio</th>
                                            <th class="py-3">Motivo / Notas</th>
                                            <th class="py-3">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($historial)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center py-5 text-muted">Aún no hay registros médicos para esta mascota.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($historial as $cita): ?>
                                                <tr>
                                                    <td class="py-3 px-4">
                                                        <div class="fw-bold"><?php echo date('d/m/Y', strtotime($cita['fecha'])); ?></div>
                                                    </td>
                                                    <td><span class="fw-bold text-dark"><?php echo htmlspecialchars($cita['nombre_servicio']); ?></span></td>
                                                    <td>
                                                        <div class="small fw-bold text-muted mb-1">Motivo: <?php echo htmlspecialchars($cita['motivo'] ?? 'Visita rutinaria'); ?></div>
                                                        <?php if (!empty($cita['notas_veterinario'])): ?>
                                                            <div class="p-2 bg-success-subtle rounded border-start border-success border-3 small text-dark">
                                                                <i class="fa-solid fa-comment-medical me-1"></i> <?php echo htmlspecialchars($cita['notas_veterinario']); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($cita['estado'] == 'Completada'): ?>
                                                            <span class="badge bg-success">Realizada</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($cita['estado']); ?></span>
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

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>