<?php
require_once 'config/database.php';

class Cita
{
    private $db;

    public function __construct()
    {
        $this->db = Database::conectar();
    }

    /**
     * Guarda una nueva cita médica en la base de datos
     */
    public function guardarCita($id_mascota, $id_servicio, $fecha, $hora, $motivo)
    {
        try {
            $sql = "INSERT INTO citas (id_mascota, id_servicio, fecha, hora, estado, motivo) 
                    VALUES (:id_mascota, :id_servicio, :fecha, :hora, 'Pendiente', :motivo)";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id_mascota', $id_mascota);
            $stmt->bindParam(':id_servicio', $id_servicio);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':hora', $hora);
            $stmt->bindParam(':motivo', $motivo);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene la próxima cita programada para un usuario específico (usando INNER JOIN)
     * 
     * @param int $id_dueno El ID del usuario logueado
     * @return array|bool Retorna un array con los datos de la cita o false si no hay
     */
    public function obtenerProximaCita($id_dueno)
    {
        try {
            // Consulta avanzada uniendo citas, mascotas y servicios
            // CURDATE() asegura que solo busquemos citas de hoy en adelante
            $sql = "SELECT c.fecha, c.hora, c.estado, m.nombre AS mascota_nombre, s.nombre_servicio 
                    FROM citas c
                    INNER JOIN mascotas m ON c.id_mascota = m.id_mascota
                    INNER JOIN servicios s ON c.id_servicio = s.id_servicio
                    WHERE m.id_dueno = :id_dueno AND c.fecha >= CURDATE()
                    ORDER BY c.fecha ASC, c.hora ASC
                    LIMIT 1"; // Solo queremos la más próxima

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_dueno', $id_dueno);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Obtiene TODAS las citas de la clínica para el panel del veterinario.
     * Une 4 tablas: citas, mascotas, usuarios (dueños) y servicios.
     */
    public function obtenerTodasLasCitas()
    {
        try {
            $sql = "SELECT c.id_cita, c.fecha, c.hora, c.estado, c.motivo, c.notas_veterinario, 
               m.id_mascota, m.nombre AS mascota_nombre, m.especie, m.peso,
               u.nombre AS cliente_nombre, 
               s.nombre_servicio 
        FROM citas c
                    INNER JOIN mascotas m ON c.id_mascota = m.id_mascota
                    INNER JOIN usuarios u ON m.id_dueno = u.id_usuario
                    INNER JOIN servicios s ON c.id_servicio = s.id_servicio
                    ORDER BY c.fecha DESC, c.hora DESC";
            // Ordenamos de más reciente a más antigua

            $stmt = $this->db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Actualiza el estado de una cita (Pendiente, Completada, Cancelada)
     */
    public function actualizarEstado($id_cita, $nuevo_estado)
    {
        try {
            $sql = "UPDATE citas SET estado = :estado WHERE id_cita = :id_cita";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $nuevo_estado);
            $stmt->bindParam(':id_cita', $id_cita);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function completarCitaConNotas($id_cita, $notas)
    {
        try {
            // Cambiamos estado a Completada y guardamos el texto
            $sql = "UPDATE citas SET estado = 'Completada', notas_veterinario = :notas WHERE id_cita = :id_cita";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':notas' => $notas, ':id_cita' => $id_cita]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function cancelarCitaConNotas($id_cita, $notas)
    {
        try {
            $sql = "UPDATE citas SET estado = 'Cancelada', notas_veterinario = :notas WHERE id_cita = :id_cita";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':notas' => $notas, ':id_cita' => $id_cita]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
