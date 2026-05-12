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
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario_id'])) {

            // 1. Recogemos los datos
            $id_dueno = $_SESSION['usuario_id'];
            $nombre = trim($_POST['nombre']);
            $especie = $_POST['especie'];
            $raza = trim($_POST['raza']);

            // 2. Instanciamos el modelo y guardamos
            $modeloMascota = new Mascota();
            $exito = $modeloMascota->registrarMascota($id_dueno, $nombre, $especie, $raza);

            if ($exito) {
                // Si va bien, volvemos al dashboard con un mensaje de éxito diferente
                header("Location: index.php?controller=Cliente&action=dashboard&mascota=exito");
            } else {
                echo "Error al guardar la mascota en la base de datos.";
            }
        }
    }
}
