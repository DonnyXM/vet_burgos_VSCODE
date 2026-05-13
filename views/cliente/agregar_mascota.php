<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Mascota - Vet-Burgos</title>
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

                        <div class="text-center mb-4">
                            <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-paw fa-2x"></i>
                            </div>
                            <h3 class="fw-bold mb-0">Agregar Nueva Mascota</h3>
                            <p class="text-muted">Introduce los datos de tu nuevo compañero</p>
                        </div>

                        <form action="index.php?controller=Mascota&action=guardar" method="POST">

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nombre de la mascota</label>
                                <input type="text" name="nombre" class="form-control bg-light border-0 py-2" placeholder="Ej: Milo" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Especie</label>
                                    <select name="especie" class="form-select bg-light border-0 py-2" required>
                                        <option value="" disabled selected>Selecciona...</option>
                                        <option value="Perro">Perro</option>
                                        <option value="Gato">Gato</option>
                                        <option value="Exótico">Animal Exótico</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold small">Raza (Opcional)</label>
                                    <input type="text" name="raza" class="form-control bg-light border-0 py-2" placeholder="Ej: Siamés">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">Fecha de nacimiento <span class="text-muted fw-normal">- Opcional</span></label>
                                <input type="date" name="fecha_nacimiento" class="form-control bg-light border-0 py-2" max="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3 shadow-sm">
                                <i class="fa-solid fa-plus me-2"></i> Guardar Mascota
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>