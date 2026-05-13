<?php

/**
 * 
 * @var array $pacientes Lista de todos los pacientes
 */
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes - Vet-Burgos Admin</title>
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
                <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Admin'); ?></h6>
                <small class="text-info">Veterinario / Admin</small>
            </div>

            <ul class="nav nav-pills flex-column mb-auto gap-2">
                <li class="nav-item">
                    <a href="index.php?controller=Admin&action=dashboard" class="nav-link text-white opacity-75 nav-hover rounded-3">
                        <i class="fa-solid fa-calendar-days me-2"></i> Agenda de Citas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?controller=Admin&action=clientes" class="nav-link text-white opacity-75 nav-hover rounded-3">
                        <i class="fa-solid fa-users me-2"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?controller=Admin&action=pacientes" class="nav-link active bg-primary text-white fw-bold rounded-3">
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Listado de Pacientes (Mascotas)</h3>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">Paciente</th>
                                    <th class="py-3">Especie / Raza</th>
                                    <th class="py-3">Peso</th>
                                    <th class="py-3">Propietario</th>
                                    <th class="py-3 text-center px-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($pacientes)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">No hay pacientes registrados en el sistema.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($pacientes as $p): ?>
                                        <tr>
                                            <td class="px-4">
                                                <div class="fw-bold"><?php echo htmlspecialchars($p['nombre'] ?? $p['mascota_nombre'] ?? 'Sin nombre'); ?></div>
                                            </td>
                                            <td>
                                                <div class="small fw-bold text-dark"><?php echo htmlspecialchars($p['especie'] ?? 'Desconocida'); ?></div>
                                                <div class="text-muted small"><?php echo htmlspecialchars($p['raza'] ?? ''); ?></div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                                                    <?php echo !empty($p['peso']) ? $p['peso'] . ' kg' : '---'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($p['dueno_nombre'] ?? 'Desconocido'); ?>
                                            </td>
                                            <td class="text-center px-4">
                                                <a href="index.php?controller=Admin&action=verPaciente&id=<?php echo $p['id_mascota'] ?? ''; ?>" class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                                    <i class="fa-solid fa-eye me-1"></i> Ver Ficha
                                                </a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>