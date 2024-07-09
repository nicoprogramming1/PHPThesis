<?php 
function actualizarRecepcion($vConexion, $idRecepcionModificar, $idEstadoRecepcion, $fechaRecepcionCompra, $idCompra, $detalleRecepcion, $detalleRemito, $nroRemito, $remito, $fechaRemito, $idRemito) {
    // Realiza las validaciones y el saneamiento de los datos
    $idRecepcionModificar = mysqli_real_escape_string($vConexion, $idRecepcionModificar);
    $idEstadoRecepcion = mysqli_real_escape_string($vConexion, $idEstadoRecepcion);
    $fechaRecepcionCompra = mysqli_real_escape_string($vConexion, $fechaRecepcionCompra);
    $idCompra = mysqli_real_escape_string($vConexion, $idCompra);
    $detalleRecepcion = mysqli_real_escape_string($vConexion, $detalleRecepcion);
    $idRemito = mysqli_real_escape_string($vConexion, $idRemito);
    $detalleRemito = mysqli_real_escape_string($vConexion, $detalleRemito);
    $nroRemito = mysqli_real_escape_string($vConexion, $nroRemito);
    $fechaRemito = mysqli_real_escape_string($vConexion, $fechaRemito);

    $SQL = "UPDATE recepcion_compra SET
            fechaRecepcionCompra = '$fechaRecepcionCompra',
            idCompra = '$idCompra',
            idEstadoRecepcionCompra = '$idEstadoRecepcion'
            WHERE idRecepcionCompra = $idRecepcionModificar";

    if (!mysqli_query($vConexion, $SQL)) {
        return false;
    }

    // Actualiza la imagen del remito solo si se proporciono uno nuevo
    if (!empty($remito)) {
        $remito = mysqli_real_escape_string($vConexion, $remito);
        $SQL = "UPDATE remito SET 
                    fechaRemito = '$fechaRemito',
                    detalleRemito = '$detalleRemito', 
                    nroRemito = $nroRemito,
                    remito = '$remito'
                WHERE idRemito = $idRemito";
    } else {
        $SQL = "UPDATE remito SET 
                    fechaRemito = '$fechaRemito',
                    detalleRemito = '$detalleRemito', 
                    nroRemito = $nroRemito
                WHERE idRemito = $idRemito";
    }

    

    if (mysqli_query($vConexion, $SQL)) {
        // Actualiza los detalles de la recepcion
        $SQL = "UPDATE detalle_recepcioncompra SET 
                    detalleRecepcion = '$detalleRecepcion'
                WHERE idRecepcionCompra = $idRecepcionModificar";

        if (mysqli_query($vConexion, $SQL)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>