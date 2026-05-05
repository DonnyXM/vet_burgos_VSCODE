<?php

/**
 * Clase Database
 * Gestiona la conexión a MySQL de forma estática para que esté disponible
 * en cualquier parte del proyecto sin problemas de variables globales.
 */
class Database
{

    public static function conectar()
    {
        $host = 'localhost';
        $dbname = 'vet_burgos';
        $username = 'root';
        $password = 'root';

        try {
            $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            // Configuramos PDO para que lance excepciones (errores) claros
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die("ERROR de conexión a la Base de Datos: " . $e->getMessage());
        }
    }
}
