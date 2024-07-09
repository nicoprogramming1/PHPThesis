<?php
function ObtenerAsistentesPorEvento($conexion, $idEvento)
{
    $asistentes = array();

    $query = "SELECT asistente FROM asistentes_evento
              WHERE idEvento = ?";

    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $idEvento);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $asistenteData = explode(' - ', $row['asistente']); // Dividir el nombre y el DNI usando el guion como delimitador
        $asistenteNombre = $asistenteData[0]; // Obtener el nombre
        $asistenteDni = $asistenteData[1]; // Obtener el DNI
        $asistentes[] = array('nombre' => $asistenteNombre, 'dni' => $asistenteDni); // Agregar a la lista de asistentes
    }

    return $asistentes;
}
?>