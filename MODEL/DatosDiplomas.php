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
    public function insertarDiploma($nombre, $cedula, $edad, $genero, $carrera, $coordinador, $institucion, $fecha) {
        try {
            $sql = "INSERT INTO diplomas (nombre_estudiante, cedula_estudiante, edad_estudiante, genero_estudiante, carrera, coordinador, institucion, fecha_terminacion) 
                    VALUES (:nombre, :cedula, :edad, :genero, :carrera, :coordinador, :institucion, :fecha)";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':edad', $edad);
            $stmt->bindParam(':genero', $genero);
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

     // Obtener estadísticas completas
    public function obtenerEstadisticasCompletas() {
        try {
            // Estadísticas generales
            $totalEstudiantes = $this->obtenerTotalEstudiantes();
            $totalProgramas = $this->obtenerTotalProgramas();
            $estadisticasGenero = $this->obtenerEstadisticasGenero();
            $estadisticasProgramas = $this->obtenerEstadisticasPorPrograma();
            
            return [
                'total_estudiantes' => $totalEstudiantes,
                'total_programas' => $totalProgramas,
                'total_masculino' => $estadisticasGenero['Masculino'] ?? 0,
                'total_femenino' => $estadisticasGenero['Femenino'] ?? 0,
                'total_otro' => $estadisticasGenero['Otro'] ?? 0,
                'programas' => $estadisticasProgramas
            ];
        } catch (PDOException $e) {
            return [];
        }
    }
    
    // Obtener total de estudiantes
    private function obtenerTotalEstudiantes() {
        try {
            $sql = "SELECT COUNT(*) as total FROM diplomas";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    // Obtener total de programas únicos
    private function obtenerTotalProgramas() {
        try {
            $sql = "SELECT COUNT(DISTINCT carrera) as total FROM diplomas";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            return 0;
        }
    }
    
    // Obtener estadísticas por género
    private function obtenerEstadisticasGenero() {
        try {
            $sql = "SELECT genero_estudiante, COUNT(*) as total FROM diplomas GROUP BY genero_estudiante";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $estadisticas = [];
            foreach ($resultados as $row) {
                $estadisticas[$row['genero_estudiante']] = $row['total'];
            }
            
            return $estadisticas;
        } catch (PDOException $e) {
            return [];
        }
    }
    
    // Obtener estadísticas por programa
    private function obtenerEstadisticasPorPrograma() {
        try {
            $sql = "SELECT 
                        carrera as programa,
                        SUM(CASE WHEN genero_estudiante = 'Masculino' THEN 1 ELSE 0 END) as masculino,
                        SUM(CASE WHEN genero_estudiante = 'Femenino' THEN 1 ELSE 0 END) as femenino,
                        SUM(CASE WHEN genero_estudiante = 'Otro' THEN 1 ELSE 0 END) as otro,
                        COUNT(*) as total
                    FROM diplomas 
                    GROUP BY carrera 
                    ORDER BY total DESC";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>