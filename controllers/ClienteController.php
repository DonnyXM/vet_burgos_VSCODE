<?php
// controllers/ClienteController.php

require_once 'models/Mascota.php';
require_once 'models/Cita.php'; // <-- Añadimos el modelo Cita

class ClienteController
{

    public function dashboard()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit();
        }

        $id_usuario = $_SESSION['usuario_id'];

        // Obtenemos las mascotas
        $modeloMascota = new Mascota();
        $mascotas = $modeloMascota->obtenerMascotasPorUsuario($id_usuario);

        // Obtenemos la próxima cita
        $modeloCita = new Cita();
        $proxima_cita = $modeloCita->obtenerProximaCita($id_usuario);

        require_once 'views/cliente/dashboard.php';
    }

    /**
     * Muestra el historial médico detallado de una mascota
     */
    public function historial()
    {
        // Verificar que hay sesión
        if (!isset($_SESSION['usuario_id']) || strtolower(trim($_SESSION['usuario_rol'])) !== 'cliente') {
            header("Location: index.php?controller=Auth&action=login");
            exit();
        }

        // Verificar que nos han pasado un ID por la URL
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?controller=Cliente&action=dashboard");
            exit();
        }

        $id_mascota = $_GET['id'];
        $id_dueno = $_SESSION['usuario_id'];

        $modeloMascota = new Mascota();

        // Obtenemos los datos de la mascota y su historial
        $mascota = $modeloMascota->obtenerMascotaPorId($id_mascota, $id_dueno);
        $historial = $modeloMascota->obtenerHistorialMedico($id_mascota, $id_dueno);

        // Si la mascota no existe o no es de este dueño, lo echamos
        if (!$mascota) {
            header("Location: index.php?controller=Cliente&action=dashboard");
            exit();
        }

        // Cargamos la nueva vista
        require_once 'views/cliente/historial.php';
    }
}
