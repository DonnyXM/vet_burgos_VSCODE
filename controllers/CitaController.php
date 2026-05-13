<?php

require_once 'models/Mascota.php';
require_once 'models/Servicio.php';
require_once 'models/Cita.php';

class CitaController
{

    /**
     * Muestra el formulario para reservar una cita
     */
    public function reservar()
    {
        // 1. Verificamos que el usuario esté logueado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit();
        }

        // 2. Obtenemos las MASCOTAS del usuario para el desplegable
        $modeloMascota = new Mascota();
        $mascotas = $modeloMascota->obtenerMascotasPorUsuario($_SESSION['usuario_id']);

        // 3. Obtenemos los SERVICIOS de la clínica para el desplegable
        $modeloServicio = new Servicio();
        $servicios = $modeloServicio->obtenerTodos();

        // 4. Cargamos la vista del formulario
        require_once 'views/cliente/reservar_cita.php';
    }

    /**
     * Procesa los datos del formulario y guarda la cita
     */
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario_id'])) {

            $id_mascota = $_POST['id_mascota'];
            $id_servicio = $_POST['id_servicio'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];
            $motivo = trim($_POST['motivo']);

            $modeloCita = new Cita();
            $exito = $modeloCita->guardarCita($id_mascota, $id_servicio, $fecha, $hora, $motivo);

            if ($exito) {
                // Si va bien, volvemos al dashboard con un mensaje de éxito
                header("Location: index.php?controller=Cliente&action=dashboard&cita=exito");
            } else {
                echo "Error al guardar la cita.";
            }
        }
    }
}
