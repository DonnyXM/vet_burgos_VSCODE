<?php

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

    /**
     * Obtiene todas las mascotas asociadas a un ID de usuario específico.
     * 
     * @param int $id_dueno El ID del usuario logueado
     * @return array Retorna un array con todas las mascotas (o un array vacío si no tiene)
     */
    public function obtenerMascotasPorUsuario($id_dueno)
    {
        try {
            // 1. Preparamos la consulta SQL. 
            // Seleccionamos todo (*) de la tabla mascotas donde el dueño coincida.
            $sql = "SELECT * FROM mascotas WHERE id_dueno = :id_dueno";
            $stmt = $this->db->prepare($sql);

            // 2. Vinculamos el parámetro por seguridad (evita inyección SQL)
            $stmt->bindParam(':id_dueno', $id_dueno);

            // 3. Ejecutamos la consulta
            $stmt->execute();

            // 4. Devolvemos todos los resultados como un array asociativo
            // FETCH_ASSOC hace que las columnas de la BD sean las claves del array (ej: $fila['nombre'])
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si hay un error, devolvemos un array vacío para que no se rompa la vista
            return [];
        }
    }

    /**
     * Comprueba si una mascota pertenece al usuario indicado (evita IDOR al reservar citas).
     */
    public function perteneceAUsuario($id_mascota, $id_dueno)
    {
        try {
            $sql = 'SELECT 1 FROM mascotas WHERE id_mascota = :id_mascota AND id_dueno = :id_dueno LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_mascota', (int) $id_mascota, PDO::PARAM_INT);
            $stmt->bindValue(':id_dueno', (int) $id_dueno, PDO::PARAM_INT);
            $stmt->execute();

            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene todas las mascotas registradas en la clínica junto con el nombre de su dueño
     */
    public function obtenerTodasLasMascotas()
    {
        try {
            $sql = "SELECT m.id_mascota, m.nombre AS mascota_nombre, m.especie, m.raza, m.peso, u.nombre AS dueno_nombre 
                    FROM mascotas m 
                    INNER JOIN usuarios u ON m.id_dueno = u.id_usuario 
                    ORDER BY m.nombre ASC";

            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    /**
     * Obtiene el historial de citas/servicios de una mascota específica
     */
    public function obtenerHistorialMedico($id_mascota)
    {
        try {
            // Seleccionamos también las notas_veterinario
            $sql = "SELECT c.fecha, c.hora, c.estado, c.motivo, c.notas_veterinario, s.nombre_servicio, s.precio 
                    FROM citas c 
                    INNER JOIN servicios s ON c.id_servicio = s.id_servicio 
                    WHERE c.id_mascota = :id_mascota 
                    ORDER BY c.fecha DESC, c.hora DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_mascota', $id_mascota, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Obtiene los datos básicos de una sola mascota
     */
    public function obtenerMascotaPorId($id_mascota, $id_dueno)
    {
        try {
            $sql = "SELECT * FROM mascotas WHERE id_mascota = :id_mascota AND id_dueno = :id_dueno";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_mascota', $id_mascota, PDO::PARAM_INT);
            $stmt->bindParam(':id_dueno', $id_dueno, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function actualizarPeso($id_mascota, $peso)
    {
        try {
            $sql = "UPDATE mascotas SET peso = :peso WHERE id_mascota = :id_mascota";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':peso' => $peso, ':id_mascota' => $id_mascota]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function obtenerMascotaPorIdAdmin($id_mascota)
    {
        $sql = "SELECT m.*, u.nombre AS dueno_nombre, u.email AS dueno_email 
                FROM mascotas m 
                INNER JOIN usuarios u ON m.id_dueno = u.id_usuario 
                WHERE m.id_mascota = :id_mascota";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_mascota' => $id_mascota]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
