<?php
function InsertarReclamo($MiConexion, $detalleReclamo, $idProveedor, $idRecepcionCompra)
{
    $detalleReclamo = mysqli_real_escape_string($MiConexion, $detalleReclamo);
    $idProveedor = mysqli_real_escape_string($MiConexion, $idProveedor);
    $idRecepcionCompra = mysqli_real_escape_string($MiConexion, $idRecepcionCompra);

    // Iniciar una transacción
    mysqli_begin_transaction($MiConexion);

    // Realizar la inserción en la tabla 'reclamo'
    $queryReclamo = "INSERT INTO reclamo (fechaReclamo) VALUES (DEFAULT)";

    $resultadoQueryReclamo = mysqli_query($MiConexion, $queryReclamo);

    if ($resultadoQueryReclamo) {
        // Obtener el 'idReclamo' generado
        $idReclamo = mysqli_insert_id($MiConexion);

        // Realizar la inserción en la tabla 'detalle_reclamo'
        $queryDetalle = "INSERT INTO detalle_reclamo (detalleReclamo, idProveedor, idRecepcionCompra, idReclamo) VALUES ('$detalleReclamo', '$idProveedor', '$idRecepcionCompra', '$idReclamo')";

        $resultadoQueryDetalle = mysqli_query($MiConexion, $queryDetalle);

        if ($resultadoQueryDetalle) {
            // Confirmar la transacción
                    mysqli_commit($MiConexion);
                    return true;
                } else {
                    // Si hubo algún error al actualizar detalle_reclamo, deshacer la transacción
                    mysqli_rollback($MiConexion);
                    return false;
        }
    }
}
?>