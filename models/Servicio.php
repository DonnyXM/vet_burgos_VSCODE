<?php
require_once 'config/database.php';

class Servicio
{
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    /**
     * Obtiene todos los servicios disponibles en la clínica
     */
    public function obtenerTodos()
    {
        try {
            $stmt = $this->db->query("SELECT * FROM servicios");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
