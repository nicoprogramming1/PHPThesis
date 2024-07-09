<?php
$contador = 1;
foreach ($ListadoAsistentes as $asistente) {
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $asistente['IDASISTENTES'] . '</td>';
    echo '<td>' . $asistente['NOMBRE'] . '</td>';
    
    // Obtener el número de DNI por su ID
    $idDni = $asistente['IDDNI'];
    $numeroDni = ObtenerNumeroDniPorID($MiConexion, $idDni);
    
    echo '<td>' . $numeroDni . '</td>';
    
    // Reemplazamos el input checkbox por un input radio y le damos el mismo nombre para que formen un grupo
    echo '<td><input type="radio" name="seleccionar[]" value="' . $asistente['IDASISTENTES'] . '"></td>';
    echo '</tr>';
    $contador++;
}
?>