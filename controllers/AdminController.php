<?php

require_once 'models/Cita.php';
require_once 'models/Usuario.php';
require_once 'models/Mascota.php';

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

    /**
     * Muestra la lista de clientes
     */
    public function clientes()
    {
        $this->verificarAcceso();

        $modeloUsuario = new Usuario();
        $clientes = $modeloUsuario->obtenerTodosLosClientes();

        require_once 'views/admin/clientes.php';
    }

    /**
     * Muestra la lista de pacientes (mascotas)
     */
    public function pacientes()
    {
        $this->verificarAcceso();

        $modeloMascota = new Mascota();
        $pacientes = $modeloMascota->obtenerTodasLasMascotas();

        require_once 'views/admin/pacientes.php';
    }

    /**
     * Finaliza la consulta médica: actualiza peso y guarda notas
     */
    public function finalizarConsulta()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_cita = $_POST['id_cita'];
            $id_mascota = $_POST['id_mascota'];
            $peso = trim($_POST['peso']);
            $notas = trim($_POST['notas']);

            // Necesitamos usar ambos modelos
            require_once 'models/Cita.php';
            require_once 'models/Mascota.php';

            $modeloCita = new Cita();
            $modeloMascota = new Mascota();

            // 1. Actualizamos el peso de la mascota
            $modeloMascota->actualizarPeso($id_mascota, $peso);

            // 2. Completamos la cita guardando las notas médicas
            $modeloCita->completarCitaConNotas($id_cita, $notas);

            // Recargamos el panel
            header("Location: index.php?controller=Admin&action=dashboard&exito=consulta_finalizada");
            exit();
        }
    }

    public function verPaciente()
    {
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=Admin&action=pacientes");
            exit();
        }

        $id_mascota = $_GET['id'];
        $modeloMascota = new Mascota();

        // Obtenemos info básica (incluyendo el nombre del dueño)
        $mascota = $modeloMascota->obtenerMascotaPorIdAdmin($id_mascota);
        $historial = $modeloMascota->obtenerHistorialMedico($id_mascota);

        require_once 'views/admin/detalle_paciente.php';
    }

    /**
     * Cancela una cita guardando el motivo de la misma
     */
    public function cancelarCitaConMotivo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id_cita = $_POST['id_cita'];
            $motivo_cancelacion = "CANCELADA: " . trim($_POST['motivo_cancelacion']);

            require_once 'models/Cita.php';
            $modeloCita = new Cita();

            // Usamos la misma lógica de completar pero para cancelar
            $modeloCita->cancelarCitaConNotas($id_cita, $motivo_cancelacion);

            header("Location: index.php?controller=Admin&action=dashboard&exito=cita_cancelada");
            exit();
        }
    }
}
