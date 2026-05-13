<?php
// models/Usuario.php

require_once 'config/database.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        // En lugar de global $pdo, llamamos a la clase estática
        $this->db = Database::conectar();
    }

    public function registrar($nombre, $email, $password)
    {
        try {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, 'cliente')";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $passwordHash);

            $stmt->execute();

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Si quieres ver por qué falla (ej. correo duplicado), puedes descomentar la siguiente línea temporalmente:
            // echo "Error en Usuario: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Verifica las credenciales de un usuario para el inicio de sesión.
     * 
     * @param string $email Correo electrónico del usuario
     * @param string $password Contraseña escrita en el formulario
     * @return array|bool Retorna un array con los datos si es correcto, o false si falla.
     */
    public function login($email, $password)
    {
        try {
            // 1. Buscamos al usuario por su email en la BD
            $sql = "SELECT id_usuario, nombre, email, password, rol FROM usuarios WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // 2. Obtenemos la fila de la base de datos como un array asociativo
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // 3. Si el usuario existe, verificamos la contraseña
            // password_verify es la función de PHP que compara el texto plano con el hash guardado
            if ($usuario && password_verify($password, $usuario['password'])) {
                // Por seguridad, quitamos la contraseña del array antes de devolver los datos
                unset($usuario['password']);
                return $usuario;
            } else {
                return false; // Credenciales incorrectas
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene todos los usuarios que son clientes y cuenta cuántas mascotas tienen
     */
    public function obtenerTodosLosClientes()
    {
        try {
            $sql = "SELECT u.id_usuario, u.nombre, u.email, COUNT(m.id_mascota) AS total_mascotas 
                    FROM usuarios u 
                    LEFT JOIN mascotas m ON u.id_usuario = m.id_dueno 
                    WHERE u.rol = 'cliente' 
                    GROUP BY u.id_usuario 
                    ORDER BY u.nombre ASC";

            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
