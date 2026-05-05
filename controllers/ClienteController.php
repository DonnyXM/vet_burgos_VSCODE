<?php

// Requerimos el modelo que vamos a utilizar para sacar los datos
require_once 'models/Mascota.php';

/**
 * Controlador Cliente
 * Gestiona todas las vistas y acciones del área privada del usuario logueado.
 */
class ClienteController
{

    /**
     * Muestra el panel principal del cliente (Dashboard) con sus datos reales.
     */
    public function dashboard()
    {
        // 1. PROTECCIÓN DE RUTA: Verificamos si hay sesión iniciada
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=Auth&action=login");
            exit();
        }

        // 2. Instanciamos el modelo de Mascota
        $modeloMascota = new Mascota();

        // 3. Obtenemos el ID del usuario directamente de la sesión actual
        $id_usuario = $_SESSION['usuario_id'];

        // 4. Pedimos al modelo que busque las mascotas de este usuario en la BD
        // Guardamos el resultado en la variable $mascotas
        $mascotas = $modeloMascota->obtenerMascotasPorUsuario($id_usuario);

        // 5. Cargamos la vista. 
        // Como la variable $mascotas se ha creado justo antes del require, 
        // la vista 'dashboard.php' podrá acceder a ella y usarla.
        require_once 'views/cliente/dashboard.php';
    }
}
