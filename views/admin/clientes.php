<?php

/**
 * Declaración de variables para el editor de código (IDE).
 * @var array $citas Lista de todas las citas del sistema
 */
?>
<!-- views/admin/dashboard.php -->
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

    <!-- ==========================================
         CABECERA MÓVIL VETERINARIO (Solo se ve en móviles)
         ========================================== -->
    <div class="d-md-none bg-dark text-white border-bottom border-secondary p-3 d-flex justify-content-between align-items-center sticky-top shadow-sm">
        <h5 class="m-0 fw-bold"><i class="fa-solid fa-user-doctor me-2"></i> Vet-Burgos Admin</h5>
        <!-- Botón Hamburguesa Claro -->
        <button class="btn btn-outline-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateralAdmin">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- Contenedor principal -->
    <div class="d-flex vh-100 overflow-hidden">

        <!-- ==========================================
             BARRA LATERAL (Responsive con Offcanvas)
             ========================================== -->
        <div class="offcanvas-md offcanvas-start bg-dark text-white d-flex flex-column p-3" tabindex="-1" id="menuLateralAdmin" style="width: 280px;">

            <!-- Cabecera del menú solo para móvil (con botón de cerrar blanco) -->
            <div class="offcanvas-header d-md-none border-bottom border-secondary mb-3">
                <h5 class="offcanvas-title fw-bold">Menú Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" data-bs-target="#menuLateralAdmin"></button>
            </div>

            <div class="text-center mb-4 mt-md-3">
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

        <!-- ==========================================
             ÁREA DE CONTENIDO PRINCIPAL
             ========================================== -->
        <!-- p-3 en móvil, p-md-5 en escritorio -->
        <div class="flex-grow-1 overflow-auto p-3 p-md-5">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">Listado de Clientes</h3>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="min-width: 600px;">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-4">ID</th>
                                    <th class="py-3">Nombre del Cliente</th>
                                    <th class="py-3">Correo Electrónico</th>
                                    <th class="py-3 text-center">Nº de Mascotas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($clientes)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">No hay clientes registrados.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <tr>
                                            <td class="py-3 px-4 text-muted">#<?php echo $cliente['id_usuario']; ?></td>
                                            <td class="fw-bold"><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                                            <td class="text-center">
                                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                                    <?php echo $cliente['total_mascotas']; ?>
                                                </span>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>