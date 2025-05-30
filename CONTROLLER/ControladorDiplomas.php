<?php
require_once  '../MODEL/DatosDiplomas.php';

class DiplomaControlador {
    private $modelo;
    
    public function __construct() {
        $this->modelo = new DatosDiplomas();
    }
    
    // Procesar formulario para crear diploma
    public function crearDiploma() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['ne']);
            $cedula = trim($_POST['ce']);
            $edad = trim($_POST['ed']);
            $genero = trim($_POST['ge']);
            $carrera = trim($_POST['ca']);
            $coordinador = trim($_POST['co']);
            $institucion = trim($_POST['in']);
            $fecha = $_POST['fa'];
            
            // Validar que no esten vacíos
            if (empty($nombre) || empty($cedula) || empty($edad) || empty($genero) || empty($carrera) || empty($coordinador)
                || empty($institucion) || empty($fecha)) {
                // Mostrar mensaje de error
                header("Location: ../view/GestionDiplomas.html?error=campos_vacios");
                exit;
            }
            
            // Insertar en la base de datos
            $resultado = $this->modelo->insertarDiploma($nombre, $cedula, $edad, $genero, $carrera, $coordinador, $institucion, $fecha);
            
            if ($resultado) {
                header("Location: http://localhost/Diplomas/VIEW/MostrarDiplomas.php?success=diploma_creado");
            } else {
                header("Location: http://localhost/Diplomas/VIEW/GestionDiplomas.html?error=error_insertar");
            }
            exit;
        }
    }
    
    // Mostrar todos los diplomas
    public function mostrarDiplomas() {
        return $this->modelo->obtenerTodosDiplomas();
    }
    
    // Mostrar diploma específico
    public function mostrarDiploma($id) {
        return $this->modelo->obtenerDiplomaPorId($id);
    }
}

// Procesar la solicitud
$controller = new DiplomaControlador();
$controller->crearDiploma();
?>