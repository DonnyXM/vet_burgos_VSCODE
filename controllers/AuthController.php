<?php

// Requerimos los modelos que vamos a utilizar
require_once 'models/Usuario.php';
require_once 'models/Mascota.php';

class AuthController
{

    // Muestra la vista del formulario de registro
    public function registro()
    {
        require_once 'views/auth/registro.php';
    }

    // Muestra la vista del formulario de login
    public function login()
    {
        require_once 'views/auth/login.php';
    }

    /**
     * Procesa los datos enviados por el formulario de registro (POST)
     */
    public function guardarRegistro()
    {
        // 1. Comprobamos que los datos vengan por el método POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // 2. Recogemos y limpiamos los datos del DUEÑO (evitar espacios en blanco extra)
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // 3. Recogemos y limpiamos los datos de la MASCOTA
            $nombre_mascota = trim($_POST['nombre_mascota']);
            $especie = $_POST['especie'];
            $raza = trim($_POST['raza']);

            // 4. Instanciamos los modelos
            $modeloUsuario = new Usuario();
            $modeloMascota = new Mascota();

            // 5. Intentamos registrar al usuario en la BD
            $id_nuevo_usuario = $modeloUsuario->registrar($nombre, $email, $password);

            // 6. Evaluamos si el usuario se guardó con éxito
            if ($id_nuevo_usuario) {

                // Si el usuario se guardó, registramos su primera mascota vinculándola con su ID
                $mascota_guardada = $modeloMascota->registrarMascota($id_nuevo_usuario, $nombre_mascota, $especie, $raza);

                if ($mascota_guardada) {
                    // ¡Éxito total! Redirigimos al inicio (temporalmente) con un mensaje de éxito en la URL
                    header("Location: index.php?controller=Home&action=index&registro=exito");
                    exit();
                } else {
                    echo "Error: Usuario creado, pero hubo un fallo al guardar la mascota.";
                }
            } else {
                // Si retorna false, probablemente el email ya existe en la BD
                echo "Error: No se pudo crear el usuario. Es posible que el correo electrónico ya esté registrado.";
            }
        } else {
            // Si alguien intenta entrar a esta URL sin enviar el formulario, lo echamos al registro
            header("Location: index.php?controller=Auth&action=registro");
            exit();
        }
    }
}
