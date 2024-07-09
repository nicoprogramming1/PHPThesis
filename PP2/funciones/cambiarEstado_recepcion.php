<?php
function cancelarRecepcion($conexion, $idRecepcionCompra) {
    $estadoCancelado = 2; // ID del estado para cancelación

    // Consulta SQL para actualizar el estado de la recepcion
    $sql = "UPDATE recepcion_compra SET idEstadoRecepcionCompra = ? WHERE idRecepcionCompra = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ii", $estadoCancelado, $idRecepcionCompra);

        // Ejecutar la sentencia preparada
        if ($stmt->execute()) {
            $stmt->close();
            return true; // recepcion cancelada con éxito
        } else {
            $stmt->close();
            return false; // Error al cancelar la recepcion
        }
    } else {
        return false; // Error en la sentencia preparada
    }
}
?>