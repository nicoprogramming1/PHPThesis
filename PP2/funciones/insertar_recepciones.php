<?php
function InsertarRecepcionEnBaseDeDatos($conexion, $ListadoBebidas)
{
    // Obtener los datos del formulario
    $nroRemito = mysqli_real_escape_string($conexion, $_POST['nroRemito']);
    $fechaRemito = $_POST['fechaRemito'];
    $detalleRemito = mysqli_real_escape_string($conexion, $_POST['detalleRemito']);
    // Obtener el archivo del remito
    $remito = $_FILES['remito'];

    $fechaRecepcionCompra = $_POST['fechaRecepcion'];
    $idEstadoRecepcionCompra = $_POST['estadoRecepcion'];
    $idCompra = $_POST['compra'];
    $detalleRecepcion = mysqli_real_escape_string($conexion, $_POST['detalleRecepcion']);

    // Verificar si se subió un archivo
    if ($remito['error'] == UPLOAD_ERR_OK) {
        // Leer el contenido del archivo
        $remitoContenido = file_get_contents($remito['tmp_name']);

        // Escapar el contenido del archivo para evitar SQL Injection
        $remitoContenido = mysqli_real_escape_string($conexion, $remitoContenido);
    } else {
        // Si no se subió un archivo
        $remitoContenido = null;
    }

    // Iniciar una transacción
    mysqli_begin_transaction($conexion);

    // Realizar la inserción en la tabla 'recepcion_compra'
    $sqlInsertRecepcion = "INSERT INTO recepcion_compra (fechaRecepcionCompra, idEstadoRecepcionCompra, idCompra) VALUES (STR_TO_DATE('$fechaRecepcionCompra', '%d/%m/%y'), '$idEstadoRecepcionCompra', '$idCompra')";
    $resultadoInsertRecepcion = mysqli_query($conexion, $sqlInsertRecepcion);

    if ($resultadoInsertRecepcion) {
        // Obtener el 'idRecepcionCompra' generado
        $idRecepcionCompra = mysqli_insert_id($conexion);

        // Realizar la inserción en la tabla 'remito'
        $sqlInsertRemito = "INSERT INTO remito (nroRemito, fechaRemito, remito, detalleRemito) VALUES ('$nroRemito', STR_TO_DATE('$fechaRemito', '%d/%m/%y'), '$remitoContenido', '$detalleRemito')";
        $resultadoInsertRemito = mysqli_query($conexion, $sqlInsertRemito);

        if ($resultadoInsertRemito) {
            // Obtener el 'idRemito' generado
            $idRemito = mysqli_insert_id($conexion);

            // Inserción en la tabla 'detalle_recepcioncompra' con 'idRecepcionCompra'
            $sqlInsertDetalleRecepcion = "INSERT INTO detalle_recepcioncompra (detalleRecepcion, idRemito, idRecepcionCompra, detalleMercaderia) VALUES ('$detalleRecepcion', $idRemito, $idRecepcionCompra, '')";
            $resultadoInsertDetalleRecepcion = mysqli_query($conexion, $sqlInsertDetalleRecepcion);

            if ($resultadoInsertDetalleRecepcion) {
                // Procesar y guardar detalleMercaderia
                $detalleMercaderia = '';

                foreach ($ListadoBebidas as $bebida) {
                    $idBebida = $bebida['IDBEBIDA'];
                    $cantidadIngresada = intval($_POST['cantidad_' . $idBebida]);

                    if ($cantidadIngresada > 0) {
                        // Recuperar nombre de la bebida y marca
                        $sqlGetBebidaMarca = "SELECT b.bebida, m.marca 
                                                FROM bebida b 
                                                INNER JOIN marca m ON b.idMarca = m.idMarca 
                                                WHERE b.idBebida = $idBebida";
                        $resultBebidaMarca = mysqli_query($conexion, $sqlGetBebidaMarca);

                        if ($resultBebidaMarca && mysqli_num_rows($resultBebidaMarca) > 0) {
                            $row = mysqli_fetch_assoc($resultBebidaMarca);
                            $nombreBebida = $row['bebida'];
                            $nombreMarca = $row['marca'];

                            // Agregar detalles a detalleMercaderia
                            $detalleMercaderia .= "$nombreBebida - $nombreMarca - $cantidadIngresada\n";

                            // Actualizar cantidad en tabla 'bebida'
                            $sqlUpdateBebida = "UPDATE bebida SET cantidadBebidas = cantidadBebidas + $cantidadIngresada WHERE idBebida = $idBebida";
                            $resultadoUpdateBebida = mysqli_query($conexion, $sqlUpdateBebida);

                            if (!$resultadoUpdateBebida) {
                                $Mensaje = "Error al actualizar la cantidad de bebida ID: $idBebida";
                                mysqli_rollback($conexion);
                                return false;
                            }
                        }
                    }
                }

                // Actualizar el detalleMercaderia en la tabla 'detalle_recepcioncompra'
                $detalleMercaderia = mysqli_real_escape_string($conexion, $detalleMercaderia);
                $sqlUpdateDetalleMercaderia = "UPDATE detalle_recepcioncompra 
                                                SET detalleMercaderia = '$detalleMercaderia' 
                                                WHERE idRemito = $idRemito 
                                                AND idRecepcionCompra = $idRecepcionCompra";
                $resultadoUpdateDetalleMercaderia = mysqli_query($conexion, $sqlUpdateDetalleMercaderia);

                if ($resultadoUpdateDetalleMercaderia) {
                    // Confirmar la transacción
                    mysqli_commit($conexion);
                    return true;
                } else {
                    // Si hubo algún error al actualizar detalleMercaderia, deshacer la transacción
                    mysqli_rollback($conexion);
                    return false;
                }
            } else {
                // Si hubo un error en la inserción en 'detalle_recepcioncompra', deshacer la transacción
                mysqli_rollback($conexion);
                return false;
            }
        } else {
            // Si hubo un error en la inserción en 'remito', deshacer la transacción
            mysqli_rollback($conexion);
            return false;
        }
    } else {
        // Si hubo un error en la inserción en 'recepcion_compra', deshacer la transacción
        mysqli_rollback($conexion);
        return false;
    }
}
?>