<?php
function eliminarRecibo($MiConexion, $idRecibo) {
    // Sanitiza y verifica el ID del recibo para evitar SQL injection
    $idRecibo = mysqli_real_escape_string($MiConexion, $idRecibo);

    // Iniciar una transacción para garantizar la consistencia de los datos
    mysqli_begin_transaction($MiConexion);

    try {
        // Eliminar cotizacion de la tabla recibo
        $SQLRecibo = "DELETE
                         FROM recibo
                         WHERE idRecibo = '$idRecibo'";

        $resultadoRecibo = mysqli_query($MiConexion, $SQLRecibo);

        // Comprobar el resultado de la consulta
        if ($resultadoRecibo) {
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