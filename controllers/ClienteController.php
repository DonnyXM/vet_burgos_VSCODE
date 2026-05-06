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
}
