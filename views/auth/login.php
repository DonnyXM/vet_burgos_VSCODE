<!-- views/auth/login.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Vet-Burgos</title>
    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <!-- Contenedor centrado en pantalla completa (vh-100) -->
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <!-- Tarjeta del formulario -->
        <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px; border-radius: 15px;">
            <div class="card-body p-5">

                <div class="text-center mb-4">
                    <a href="index.php" class="text-primary text-decoration-none h3 fw-bold">
                        <i class="fa-solid fa-stethoscope"></i> Vet-Burgos
                    </a>
                </div>

                <h4 class="fw-bold mb-3 text-center">¡Hola de nuevo!</h4>

                <!-- Si el controlador detecta credenciales incorrectas, mostramos este error -->
                <?php if (isset($_GET['error']) && $_GET['error'] == 'credenciales'): ?>
                    <div class="alert alert-danger text-center small py-2">
                        Correo electrónico o contraseña incorrectos.
                    </div>
                <?php endif; ?>

                <!-- Formulario que envía los datos al método procesarLogin -->
                <form action="index.php?controller=Auth&action=procesarLogin" method="POST">

                    <div class="mb-3">
                        <label class="form-label text-muted small">Correo electrónico</label>
                        <input type="email" name="email" class="form-control bg-light border-0 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted small">Contraseña</label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-2" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">Entrar a mi cuenta</button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small">
                        ¿No tienes cuenta? <a href="index.php?controller=Auth&action=registro" class="text-primary fw-bold text-decoration-none">Regístrate aquí</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

</body>

</html>