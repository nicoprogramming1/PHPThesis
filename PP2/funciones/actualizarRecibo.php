<?php 
function actualizarRecibo($conexion, $idReciboModificar, $nroRecibo, $fechaRecibo, $detalleRecibo, $idCompra, $reciboNuevo) {
    // Escapar variables para prevenir SQL injection
    $idReciboModificar = mysqli_real_escape_string($conexion, $idReciboModificar);
    $nroRecibo = mysqli_real_escape_string($conexion, $nroRecibo);
    $fechaRecibo = mysqli_real_escape_string($conexion, $fechaRecibo);
    $detalleRecibo = mysqli_real_escape_string($conexion, $detalleRecibo);
    $idCompra = mysqli_real_escape_string($conexion, $idCompra);

    $query = "UPDATE recibo SET 
                nroRecibo = '$nroRecibo',
                fechaRecibo = STR_TO_DATE('$fechaRecibo', '%d/%m/%y'),
                detalleRecibo = '$detalleRecibo',
                idCompra = '$idCompra'";

    if (!empty($reciboNuevo)) {
        // Si hay una nueva imagen de recibo, actualízala
        $reciboNuevo = mysqli_real_escape_string($conexion, base64_encode($reciboNuevo));
        $query .= ", recibo = '$reciboNuevo'";
    }

    $query .= " WHERE idRecibo = $idReciboModificar";

    // Ejecutar la consulta y manejar errores
    if (mysqli_query($conexion, $query)) {
        return true;
    } else {
        return false;
    }
}
?>