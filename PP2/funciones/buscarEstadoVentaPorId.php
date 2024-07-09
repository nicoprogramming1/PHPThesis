<?php
function ObtenerEstadoVentaPorId($conexion, $idEstado)
{
    $query = "SELECT estado FROM estado_venta WHERE idEstado = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $idEstado);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el idEstado
    if ($result && mysqli_num_rows($result) === 1) {
        $fila = mysqli_fetch_assoc($result);
        return $fila['estado']; // Devolver solo el valor del campo "estado"
    } else {
        return null; // No se encontró el idEstado o hubo un error en la consulta
    }
}
?>