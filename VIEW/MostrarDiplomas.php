<?php

require_once '../MODEL/DatosDiplomas.php';

date_default_timezone_set('America/Bogota'); 

$modelo = new DatosDiplomas();
$diplomas = $modelo->obtenerTodosDiplomas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Diplomas Creados</title>
    <link rel="stylesheet" href="CSS/StyleMostrarDiplomas.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Diplomas Creados</h1>
            <p>Lista de todos los diplomas generados en el sistema</p>
        </div>

        <a href="http://localhost/Diplomas/VIEW/GestionDiplomas.html" class="back-btn">← Crear Nuevo Diploma</a>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'diploma_creado'): ?>
            <div class="success-alert">
                ✅ ¡Diploma creado exitosamente!
            </div>
        <?php endif; ?>

        <?php if (empty($diplomas)): ?>
            <div class="no-diplomas">
                <h3>📜 No hay diplomas creados</h3>
                <p>Aún no se han generado diplomas en el sistema.</p>
                <a href="http://localhost/Diplomas/VIEW/GestionDiplomas.html" class="create-btn">Crear Primer Diploma</a>
            </div>
        <?php else: ?>
            <div class="diplomas-grid">
                <?php foreach ($diplomas as $diploma): ?>
                    <div class="diploma-card">
                        <div class="diploma-header">
                            <div class="diploma-title">🎓 DIPLOMA DE GRADO</div>
                            <div class="diploma-id">ID: #<?php echo str_pad($diploma['id'], 4, '0', STR_PAD_LEFT); ?></div>
                        </div>
                        
                        <div class="diploma-body">
                            <div class="info-row">
                                <span class="info-label">👤 Estudiante:</span>
                                <span class="info-value"><?php echo htmlspecialchars($diploma['nombre_estudiante']); ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">🆔 Cédula:</span>
                                <span class="info-value"><?php echo htmlspecialchars($diploma['cedula_estudiante']); ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">📚 Carrera:</span>
                                <span class="info-value"><?php echo htmlspecialchars($diploma['carrera']); ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">👨‍🏫 Coordinador:</span>
                                <span class="info-value"><?php echo htmlspecialchars($diploma['coordinador']); ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">🏛️ Institución:</span>
                                <span class="info-value"><?php echo htmlspecialchars($diploma['institucion']); ?></span>
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">📅 Terminación:</span>
                                <span class="info-value"><?php echo date('d/m/Y', strtotime($diploma['fecha_terminacion'])); ?></span>
                            </div>
                        </div>
                        
                        <div class="diploma-footer">
                            Creado el <?php echo date('d/m/Y H:i', strtotime($diploma['fecha_creacion'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>