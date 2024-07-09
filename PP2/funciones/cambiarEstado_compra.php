<?php
function cancelarCompra($conexion, $idCompra) {
    $estadoCancelado = 1; // ID del estado para cancelación

    // Consulta SQL para actualizar el estado de la compra
    $sql = "UPDATE compra SET idEstadoCompra = ? WHERE idCompra = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ii", $estadoCancelado, $idCompra);

        // Ejecutar la sentencia preparada
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Compra cancelada con éxito
        } else {
            $stmt->close();
            return false; // Error al cancelar la compra
        }
    } else {
        return false; // Error en la sentencia preparada
    }
}
?>