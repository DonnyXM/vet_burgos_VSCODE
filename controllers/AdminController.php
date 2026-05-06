<?php

require_once 'models/Cita.php';

class AdminController
{

    /**
     * Verifica la seguridad: Comprueba si es un veterinario o admin
     */
    private function verificarAcceso()
    {
        // Obtenemos el rol de la sesión y lo pasamos a minúsculas para evitar fallos
        $rol = isset($_SESSION['usuario_rol']) ? strtolower(trim($_SESSION['usuario_rol'])) : '';

        // Si no hay sesión iniciada, O el rol NO es ni veterinario ni admin, lo echamos
        if (!isset($_SESSION['usuario_id']) || ($rol !== 'veterinario' && $rol !== 'admin')) {
            // Lo redirigimos a la página principal
            header("Location: index.php");
            exit();
        }
    }

    /**
     * Muestra el panel general de la clínica
     */
    public function dashboard()
    {
        // 1. Verificamos seguridad
        $this->verificarAcceso();

        // 2. Obtenemos todas las citas de la base de datos
        $modeloCita = new Cita();
        $citas = $modeloCita->obtenerTodasLasCitas();

        // 3. Cargamos la vista del administrador
        require_once 'views/admin/dashboard.php';
    }

    /**
     * Cambia el estado de una cita (Recibe datos por URL / GET)
     */
    public function cambiarEstado()
    {
        $this->verificarAcceso();

        if (isset($_GET['id']) && isset($_GET['estado'])) {
            $id_cita = $_GET['id'];
            $estado = $_GET['estado']; // 'Completada' o 'Cancelada'

            $modeloCita = new Cita();
            $modeloCita->actualizarEstado($id_cita, $estado);
        }

        // Después de actualizar, recargamos el panel
        header("Location: index.php?controller=Admin&action=dashboard");
        exit();
    }
}
