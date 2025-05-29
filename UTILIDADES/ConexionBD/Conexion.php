<?php
// UTILIDADES/ConexionBD/Conexion.php
class Conexion {
    private $host = "localhost";
    private $puerto = "3306";
    private $usuario = "root";
    private $password = "root";
    private $base_datos = "diplomas_db";
    private $conexion;
    
    public function __construct() {
        $this->conectar();
    }
    
    private function conectar() {
        try {
            $this->conexion = new PDO(
                "mysql:host=" . $this->host . 
                ";port=" . $this->puerto . 
                ";dbname=" . $this->base_datos . ";charset=utf8",
                $this->usuario,
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public function getConexion() {
        return $this->conexion;
    }
    
    public function cerrarConexion() {
        $this->conexion = null;
    }
}
?>