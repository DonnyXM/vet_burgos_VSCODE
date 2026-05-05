<!-- views/auth/registro.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Vet-Burgos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="container-fluid vh-100">
        <div class="row h-100">

            <!-- MITAD IZQUIERDA: Banner Azul (Oculto en móviles pequeños) -->
            <div class="col-md-5 bg-primary text-white d-none d-md-flex flex-column justify-content-center p-5"
                style="background: linear-gradient(rgba(10, 40, 80, 0.85), rgba(10, 40, 80, 0.95)), url('https://images.unsplash.com/photo-1544568100-847a948585b9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80') center/cover;">

                <a href="index.php" class="text-white text-decoration-none mb-5 h3 fw-bold">
                    <i class="fa-solid fa-stethoscope"></i> Vet-Burgos
                </a>

                <h1 class="display-5 fw-bold mb-4">Únete a nuestra familia veterinaria</h1>

                <div class="d-flex align-items-center mb-4">
                    <i class="fa-solid fa-circle-check fs-3 me-3 text-info"></i>
                    <div>
                        <h5 class="mb-1 fw-bold">Reservas fáciles</h5>
                        <p class="mb-0 opacity-75">Agenda citas en segundos desde cualquier dispositivo.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <i class="fa-solid fa-circle-check fs-3 me-3 text-info"></i>
                    <div>
                        <h5 class="mb-1 fw-bold">Registros digitales</h5>
                        <p class="mb-0 opacity-75">Accede al historial médico completo de tus mascotas.</p>
                    </div>
                </div>
            </div>

            <!-- MITAD DERECHA: Formulario de Registro -->
            <div class="col-md-7 bg-white d-flex align-items-center justify-content-center p-4">
                <div class="w-100" style="max-width: 500px;">

                    <div class="text-center mb-4 d-md-none">
                        <!-- Logo visible solo en móviles -->
                        <a href="index.php" class="text-primary text-decoration-none h2 fw-bold">
                            <i class="fa-solid fa-stethoscope"></i> Vet-Burgos
                        </a>
                    </div>

                    <h2 class="fw-bold mb-1">Crea tu cuenta</h2>
                    <p class="text-muted mb-4">Completa el formulario para comenzar</p>

                    <!-- El action irá dirigido al método que guardará en la BBDD -->
                    <form action="index.php?controller=Auth&action=guardarRegistro" method="POST">

                        <h6 class="text-primary fw-bold text-uppercase mb-3 mt-4" style="font-size: 0.8rem;">Detalles del Dueño</h6>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Nombre completo</label>
                            <input type="text" name="nombre" class="form-control bg-light border-0 py-2" placeholder="Ej: María García López" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Correo electrónico</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2" placeholder="tu@ejemplo.com" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small">Contraseña</label>
                            <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Mínimo 8 caracteres" required minlength="8">
                        </div>

                        <h6 class="text-primary fw-bold text-uppercase mb-3 mt-4" style="font-size: 0.8rem;">Detalles de tu Primera Mascota</h6>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Nombre de la mascota</label>
                            <input type="text" name="nombre_mascota" class="form-control bg-light border-0 py-2" placeholder="Ej: Luna" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Especie</label>
                                <select name="especie" class="form-select bg-light border-0 py-2" required>
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="Perro">Perro</option>
                                    <option value="Gato">Gato</option>
                                    <option value="Exótico">Animal Exótico</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small">Raza</label>
                                <input type="text" name="raza" class="form-control bg-light border-0 py-2" placeholder="Ej: Labrador">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2 fw-bold rounded-3 mt-2">Completar registro</button>

                        <p class="text-center text-muted mt-4 small">
                            ¿Ya tienes una cuenta? <a href="index.php?controller=Auth&action=login" class="text-primary text-decoration-none fw-bold">Inicia sesión</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>