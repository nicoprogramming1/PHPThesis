<?php
function eliminarCotizacion($MiConexion, $idCotizacion) {
    // Sanitiza y verifica el ID del cotizacion para evitar SQL injection
    $idCotizacion = mysqli_real_escape_string($MiConexion, $idCotizacion);

    // Iniciar una transacción para garantizar la consistencia de los datos
    mysqli_begin_transaction($MiConexion);

    try {
        // Eliminar cotizacion de la tabla cotizacion
        $SQLCotizacion = "DELETE
                         FROM cotizacion
                         WHERE idCotizacion = '$idCotizacion'";

        $resultadoCotizacion = mysqli_query($MiConexion, $SQLCotizacion);

        // Comprobar el resultado de la consulta
        if ($resultadoCotizacion) {
            // Confirmar la transacción si la consulta se realizó con éxito
            mysqli_commit($MiConexion);
            return true;
        } else {
            // Deshacer la transacción si la consulta falló
            mysqli_rollback($MiConexion);
            return false;
        }
    } catch (Exception $e) {
        // Deshacer la transacción en caso de excepción
        mysqli_rollback($MiConexion);
        return false;
    }
}
?>