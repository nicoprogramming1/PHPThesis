<?php
function ActualizarEstadoVenta($conexion, $idVenta, $idNuevoEstado)
{
    $query = "UPDATE venta SET idEstado = ? WHERE idVenta = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ii', $idNuevoEstado, $idVenta);
    return $stmt->execute();
}
?>