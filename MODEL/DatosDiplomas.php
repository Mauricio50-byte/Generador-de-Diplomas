<?php
// MODEL/DatosDiplomas.php
require_once '../UTILIDADES/ConexionBD/Conexion.php';

class DatosDiplomas {
    private $conexion;
    
    public function __construct() {
        $conn = new Conexion();
        $this->conexion = $conn->getConexion();
    }
    
    // Insertar un nuevo diploma
    public function insertarDiploma($nombre, $cedula, $carrera, $coordinador, $institucion, $fecha) {
        try {
            $sql = "INSERT INTO diplomas (nombre_estudiante, cedula_estudiante, carrera, coordinador, institucion, fecha_terminacion) 
                    VALUES (:nombre, :cedula, :carrera, :coordinador, :institucion, :fecha)";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':carrera', $carrera);
            $stmt->bindParam(':coordinador', $coordinador);
            $stmt->bindParam(':institucion', $institucion);
            $stmt->bindParam(':fecha', $fecha);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    // Obtener todos los diplomas
    public function obtenerTodosDiplomas() {
        try {
            $sql = "SELECT * FROM diplomas ORDER BY fecha_creacion DESC";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
    
    // Obtener diploma por ID
    public function obtenerDiplomaPorId($id) {
        try {
            $sql = "SELECT * FROM diplomas WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }
}
?>