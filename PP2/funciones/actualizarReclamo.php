<?php 
function actualizarReclamo($vConexion, $idReclamoModificar, $detalleReclamo, $idRecepcionCompra, $idProveedor) {
    // Realiza las validaciones y el saneamiento de los datos
    $idReclamoModificar = mysqli_real_escape_string($vConexion, $idReclamoModificar);
    $detalleReclamo = mysqli_real_escape_string($vConexion, $detalleReclamo);
    $idRecepcionCompra = mysqli_real_escape_string($vConexion, $idRecepcionCompra);
    $idProveedor = mysqli_real_escape_string($vConexion, $idProveedor);

    $SQLdetalle = "UPDATE detalle_reclamo SET
            detalleReclamo = '$detalleReclamo',
            idRecepcionCompra = '$idRecepcionCompra',
            idProveedor = '$idProveedor'
            WHERE idReclamo = $idReclamoModificar";

    if (!mysqli_query($vConexion, $SQLdetalle)) {
        return false;
    } else {
        return true;
    }
}
?>