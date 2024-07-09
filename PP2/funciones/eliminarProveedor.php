<?php
function eliminarProveedor($MiConexion, $idProveedor) {
    // Sanitiza y verifica el ID del proveedor para evitar SQL injection
    $idProveedor = mysqli_real_escape_string($MiConexion, $idProveedor);

    // Iniciar una transacción para garantizar la consistencia de los datos
    mysqli_begin_transaction($MiConexion);

    try {
        // Eliminar proveedor de la tabla proveedor y los registros asociados en otras tablas
        $SQLProveedor = "DELETE p, d, t, e
                         FROM proveedor p
                         LEFT JOIN domicilio d ON p.idDomicilio = d.idDomicilio
                         LEFT JOIN telefono t ON p.idTelefono = t.idTelefono
                         LEFT JOIN email e ON p.idEmail = e.idEmail
                         WHERE p.idProveedor = '$idProveedor'";

        $resultadoProveedor = mysqli_query($MiConexion, $SQLProveedor);

        // Comprobar el resultado de la consulta
        if ($resultadoProveedor) {
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