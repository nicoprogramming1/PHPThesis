<?php
function eliminarBebida($MiConexion, $idBebida) {
    // Sanitiza y verifica el ID de la bebida para evitar SQL injection
    $idBebida = mysqli_real_escape_string($MiConexion, $idBebida);

    // Iniciar una transacción para garantizar la consistencia de los datos
    mysqli_begin_transaction($MiConexion);

    try {
        // Eliminar proveedor de la tabla proveedor y los registros asociados en otras tablas
        $SQL = "DELETE from bebida WHERE idBebida = '$idBebida'";

        $resultado = mysqli_query($MiConexion, $SQL);

        // Comprobar el resultado de la consulta
        if ($resultado) {
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