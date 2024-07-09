<?php
function InsertarCompraEnBaseDeDatos($conexion) {
    // Recoge los datos del formulario
    $detalleCompra = mysqli_real_escape_string($conexion, $_POST['detalleCompra']);
    $factura = mysqli_real_escape_string($conexion, $_POST['factura']);
    $ordenCompra = mysqli_real_escape_string($conexion, $_POST['ordenCompra']);
    $fechaEntregaPrevista = mysqli_real_escape_string($conexion, $_POST['fechaEntregaPrevista']);

    // Iniciar una transacción
    mysqli_begin_transaction($conexion);

    // Realiza la inserción en la tabla compra
    $queryCompra = "INSERT INTO compra (fechaEntregaPrevista) VALUES ('$fechaEntregaPrevista')";
    $resultCompra = mysqli_query($conexion, $queryCompra);

    // Verifica si la inserción en la tabla compra fue exitosa
    if ($resultCompra) {
        // Obtener el último ID generado por la base de datos (idCompra)
        $idCompra = mysqli_insert_id($conexion);

        // Realiza la inserción en la tabla detalle_compra
        $queryDetalleCompra = "INSERT INTO detalle_compra (detalleCompra, idFactura, idOrdenCompra, idCompra) VALUES ('$detalleCompra', '$factura', '$ordenCompra', '$idCompra')";
        $resultDetalleCompra = mysqli_query($conexion, $queryDetalleCompra);

        if ($resultDetalleCompra) {
            // Confirmar la transacción
            mysqli_commit($conexion);

            // Ambas inserciones fueron exitosas
            return true;
        } else {
            // Ocurrió un error al insertar en la tabla detalle_compra
            // Revertir la transacción
            mysqli_rollback($conexion);
            return false;
        }
    } else {
        // Ocurrió un error al insertar en la tabla compra
        // Revertir la transacción
        mysqli_rollback($conexion);
        return false;
    }
}
?>