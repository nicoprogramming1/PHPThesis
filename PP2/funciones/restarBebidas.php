<?php
function restarBebidas($MiConexion, $detalleRestarBebida, $ListadoBebidas) {
    // Sanitiza y verifica el ID del detalle de la bebida para evitar SQL injection
    $detalleRestarBebida = mysqli_real_escape_string($MiConexion, $detalleRestarBebida);

    // Iniciar una transacción para garantizar la consistencia de los datos
    mysqli_begin_transaction($MiConexion);

    $SQL = "INSERT into restarsumar_bebida (detalleRestarSumarBebida) values ('$detalleRestarBebida')";
    $resultadoInsertRestar = mysqli_query($MiConexion, $SQL);

    if ($resultadoInsertRestar) {
        // Obtener el 'idRestarBebida' generado
        $idRestarBebida = mysqli_insert_id($MiConexion);

        foreach ($ListadoBebidas as $bebida) {
            $idBebida = $bebida['IDBEBIDA'];
            $cantidadIngresada = intval($_POST['cantidad_' . $idBebida]);

            if ($cantidadIngresada > 0) {
                // Insertar el detalle de las bebidas en tabla detalle_restarbebida
                $sqlInsertDetalleRestarBebida = "INSERT into detalle_restarsumarbebida (idRestarSumarBebida, idBebida, cantidad) values ('$idRestarBebida', '$idBebida', '$cantidadIngresada')";
                $resultadoInsertDetalleRestar = mysqli_query($MiConexion, $sqlInsertDetalleRestarBebida);

                // Actualizar cantidad en tabla 'bebida'
                $sqlUpdateBebida = "UPDATE bebida SET cantidadBebidas = cantidadBebidas - '$cantidadIngresada' WHERE idBebida = '$idBebida'";
                $resultadoUpdateBebida = mysqli_query($MiConexion, $sqlUpdateBebida);

                if (!$resultadoInsertDetalleRestar || !$resultadoUpdateBebida) {
                    $Mensaje = "Error al actualizar la cantidad de bebida ID: $idBebida";
                    mysqli_rollback($MiConexion);
                    return false;
                }
            }
        }

        // Si todo fue exitoso, confirmamos la transacción
        mysqli_commit($MiConexion);
        return true;
    } else {
        mysqli_rollback($MiConexion);
        return false;
    }
}

function restarBebidas2($MiConexion, $idBebida1, $idBebida2, $cantidadIngresada1, $cantidadIngresada2) {
    // Sanitiza y verifica los datos para evitar SQL injection
    $idBebida1 = mysqli_real_escape_string($MiConexion, $idBebida1);
    $idBebida2 = mysqli_real_escape_string($MiConexion, $idBebida2);
    $cantidadIngresada1 = intval($cantidadIngresada1);
    $cantidadIngresada2 = intval($cantidadIngresada2);

    // Iniciar una transacción para garantizar la consistencia de los datos
    mysqli_begin_transaction($MiConexion);

    $detalleRestarBebida = "Por venta";

    $SQL = "INSERT into restarsumar_bebida (detalleRestarSumarBebida) values ('$detalleRestarBebida')";
    $resultadoInsertRestar = mysqli_query($MiConexion, $SQL);

    if ($resultadoInsertRestar) {
        // Obtener el 'idRestarBebida' generado
        $idRestarBebida = mysqli_insert_id($MiConexion);

        if ($cantidadIngresada1 > 0) {
        // Restar la cantidad de la primera bebida del stock
        $sqlUpdateBebida1 = "UPDATE bebida SET cantidadBebidas = cantidadBebidas - $cantidadIngresada1 WHERE idBebida = $idBebida1";
        $resultadoUpdateBebida1 = mysqli_query($MiConexion, $sqlUpdateBebida1);

        // Insertar el detalle de las bebidas en tabla detalle_restarbebida
                $sqlInsertDetalleRestarBebida = "INSERT into detalle_restarsumarbebida (idRestarSumarBebida, idBebida, cantidad) values ('$idRestarBebida', '$idBebida1', '$cantidadIngresada1')";
                $resultadoInsertDetalleRestar = mysqli_query($MiConexion, $sqlInsertDetalleRestarBebida);


        // Restar la cantidad de la segunda bebida del stock
        $sqlUpdateBebida2 = "UPDATE bebida SET cantidadBebidas = cantidadBebidas - $cantidadIngresada2 WHERE idBebida = $idBebida2";
        $resultadoUpdateBebida2 = mysqli_query($MiConexion, $sqlUpdateBebida2);

        // Insertar el detalle de las bebidas en tabla detalle_restarbebida
                $sqlInsertDetalleRestarBebida = "INSERT into detalle_restarsumarbebida (idRestarSumarBebida, idBebida, cantidad) values ('$idRestarBebida', '$idBebida2', '$cantidadIngresada2')";
                $resultadoInsertDetalleRestar = mysqli_query($MiConexion, $sqlInsertDetalleRestarBebida);
            

        if (!$resultadoUpdateBebida1 || !$resultadoUpdateBebida2) {
            // Si hay un error al restar las bebidas, mostrar un mensaje de error
            $Mensaje = "Error al restar la cantidad de bebida.";
            $Estilo = 'danger';
            mysqli_rollback($MiConexion);
            return false;
        }

        // Si todo fue exitoso, confirmamos la transacción
        mysqli_commit($MiConexion);
        return true;
    }
    } else {
        mysqli_rollback($MiConexion);
        return false;
    }
}
?>