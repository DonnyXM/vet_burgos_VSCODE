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
}
