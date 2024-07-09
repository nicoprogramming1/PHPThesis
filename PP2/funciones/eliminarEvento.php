<?php
function eliminarEventoPorId($MiConexion, $idEvento) {
    // Sanitiza y verifica el ID de la marca para evitar SQL injection
    $idEvento = mysqli_real_escape_string($MiConexion, $idEvento);

    // Iniciar una transacción para garantizar la consistencia de los datos
    mysqli_begin_transaction($MiConexion);

    try {
        $SQL = "DELETE from evento WHERE idEvento = '$idEvento'";

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