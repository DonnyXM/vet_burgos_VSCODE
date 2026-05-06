<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reservar Cita - Vet-Burgos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="mb-4">
            <a href="index.php?controller=Cliente&action=dashboard" class="text-decoration-none text-muted">
                <i class="fa-solid fa-arrow-left me-2"></i> Volver a mi panel
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4 text-center">Reservar Nueva Cita</h3>

                        <form action="index.php?controller=Cita&action=guardar" method="POST">

                            <!-- SELECCIÓN DE MASCOTA (Dinámico) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">¿Para quién es la cita?</label>
                                <select name="id_mascota" class="form-select bg-light border-0 py-2" required>
                                    <option value="" disabled selected>Selecciona tu mascota...</option>
                                    <?php foreach ($mascotas as $mascota): ?>
                                        <option value="<?php echo $mascota['id_mascota']; ?>">
                                            <?php echo htmlspecialchars($mascota['nombre']) . ' (' . htmlspecialchars($mascota['especie']) . ')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- SELECCIÓN DE SERVICIO (Dinámico) -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Servicio solicitado</label>
                                <select name="id_servicio" class="form-select bg-light border-0 py-2" required>
                                    <option value="" disabled selected>Elige un servicio...</option>
                                    <?php foreach ($servicios as $servicio): ?>
                                        <option value="<?php echo $servicio['id_servicio']; ?>">
                                            <?php echo htmlspecialchars($servicio['nombre_servicio']) . ' - ' . $servicio['precio'] . '€'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- FECHA Y HORA -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Fecha</label>
                                    <!-- min=... evita que cojan días en el pasado (requeriría algo de JS, aquí lo dejamos simple por ahora) -->
                                    <input type="date" name="fecha" class="form-control bg-light border-0 py-2" required>
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <label class="form-label fw-bold">Hora</label>
                                    <input type="time" name="hora" class="form-control bg-light border-0 py-2" required min="09:00" max="20:00">
                                    <small class="text-muted">Horario: 09:00 a 20:00</small>
                                </div>
                            </div>

                            <!-- MOTIVO / OBSERVACIONES -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Motivo de la visita (Opcional)</label>
                                <textarea name="motivo" class="form-control bg-light border-0" rows="3" placeholder="Ej: Le toca la vacuna de la rabia, o lleva dos días tosiendo..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">Confirmar Reserva</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>