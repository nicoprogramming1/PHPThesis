<?php
function cancelarReclamo($conexion, $idReclamo) {
    $estadoCancelado = 2; // ID del estado para cancelación

    $fechaActual = date('Y-m-d H:i:s');

    // Consulta SQL para actualizar el estado de la recepción
    $sql = "UPDATE reclamo SET idEstadoReclamo = ?, fechaCambioEstadoReclamo = ? WHERE idReclamo = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("iss", $estadoCancelado, $fechaActual, $idReclamo);

        // Ejecutar la sentencia preparada
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Reclamo cancelado con éxito
        } else {
            $stmt->close();
            return false; // Error al cancelar el reclamo
        }
    } else {
        return false; // Error en la sentencia preparada
    }
}

function enviarReclamo($conexion, $idReclamo) {
    $estadoEnviado = 1; // ID del estado para enviar
    $fechaActual = date('Y-m-d H:i:s');

    // Consulta SQL para actualizar el estado de la recepción
    $sql = "UPDATE reclamo SET idEstadoReclamo = ?, fechaCambioEstadoReclamo = ? WHERE idReclamo = ?";

    if ($stmt = $conexion->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("iss", $estadoEnviado, $fechaActual, $idReclamo);

        // Ejecutar la sentencia preparada
        if ($stmt->execute()) {
            $stmt->close();
            return true; // Reclamo enviado con éxito
        } else {
            $stmt->close();
            return false; // Error al enviar el reclamo
        }
    } else {
        return false; // Error en la sentencia preparada
    }
}

?>