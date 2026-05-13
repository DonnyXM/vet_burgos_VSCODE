<?php

require_once 'models/Mascota.php';

class MascotaController
{

    /**
     * Muestra el formulario para añadir una nueva mascota
     */
    public function anadir()
    {
        // 1. Verificamos que el usuario esté logueado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit();
        }

        // 2. Cargamos la vista del formulario
        require_once 'views/cliente/agregar_mascota.php';
    }

    /**
     * Procesa los datos del formulario y guarda la nueva mascota en la BD
     */
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Recogemos los datos básicos del formulario
            $nombre = trim($_POST['nombre']);
            $especie = $_POST['especie'];
            $raza = trim($_POST['raza']);
            $id_dueno = $_SESSION['usuario_id'];
            $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;

            // El peso será nulo al registrarla; lo actualizará el veterinario en consulta
            $peso = null;

            $modeloMascota = new Mascota();
            $resultado = $modeloMascota->registrarMascota($id_dueno, $nombre, $especie, $raza, $peso, $fecha_nacimiento);

            if ($resultado) {

                // Redirigimos al panel del cliente con éxito
                header("Location: index.php?controller=Cliente&action=dashboard&exito=mascota_creada");
                exit();
            } else {
                echo "Error al guardar la mascota.";
            }
        }
    }
}
