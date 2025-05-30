<?php
// CONTROLLER/estadisticas.php
header('Content-Type: application/json');
require_once '../MODEL/DatosDiplomas.php';

class EstadisticasControlador {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new DatosDiplomas();
    }
    
    public function obtenerEstadisticas() {
        try {
            $estadisticas = $this->modelo->obtenerEstadisticasCompletas();
            echo json_encode($estadisticas);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error al obtener estadísticas']);
        }
    }
}

$controller = new EstadisticasControlador();
$controller->obtenerEstadisticas();
?>