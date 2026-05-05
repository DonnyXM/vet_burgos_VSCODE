<?php
// models/Mascota.php

require_once 'config/database.php';

class Mascota
{
    private $db;

    public function __construct()
    {
        // Usamos la clase estática
        $this->db = Database::conectar();
    }

    public function registrarMascota($id_dueno, $nombre, $especie, $raza)
    {
        try {
            $sql = "INSERT INTO mascotas (id_dueno, nombre, especie, raza) 
                    VALUES (:id_dueno, :nombre, :especie, :raza)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id_dueno', $id_dueno);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':especie', $especie);
            $stmt->bindParam(':raza', $raza);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
