<?php
function InsertarFacturaEnBaseDeDatos($conexion)
{
    // Obtener los datos del formulario
    $nroFactura = mysqli_real_escape_string($conexion, $_POST['nroFactura']);
    $importeFactura = floatval($_POST['importeFactura']);
    $detalleFactura = mysqli_real_escape_string($conexion, $_POST['detalleFactura']);
    $idProveedor = intval($_POST['proveedor']);
    $fechaFactura = $_POST['fechaFactura']; // Asegúrate de que el formato sea válido

    // Obtener el archivo de la factura
    $factura = $_FILES['factura'];

    // Verificar si se subió un archivo
    if ($factura['error'] == UPLOAD_ERR_OK) {
        // Leer el contenido del archivo
        $facturaContenido = file_get_contents($factura['tmp_name']);

        // Escapar el contenido del archivo para evitar SQL Injection
        $facturaContenido = mysqli_real_escape_string($conexion, $facturaContenido);
    } else {
        // Si no se subió un archivo, puedes manejarlo aquí según tus necesidades
        $facturaContenido = null; // O lo que consideres apropiado
    }

    // Iniciar una transacción
    mysqli_begin_transaction($conexion);

    // Realizar la inserción en la tabla 'factura' y obtener el 'idFactura' autoincremental
    $sqlInsertFactura = "INSERT INTO factura (nroFactura, fechaFactura) VALUES ('$nroFactura', STR_TO_DATE('$fechaFactura', '%d/%m/%y'))";
    $resultadoInsertFactura = mysqli_query($conexion, $sqlInsertFactura);

    if ($resultadoInsertFactura) {
        // Obtener el 'idFactura' generado
        $idFactura = mysqli_insert_id($conexion);

        // Realizar la inserción en la tabla 'detalle_factura'
        $sqlInsertDetalleFactura = "INSERT INTO detalle_factura (factura, detalleFactura, total, idProveedor, idFactura)
                                    VALUES ('$facturaContenido', '$detalleFactura', $importeFactura, $idProveedor, $idFactura)";

        $resultadoInsertDetalleFactura = mysqli_query($conexion, $sqlInsertDetalleFactura);

        if ($resultadoInsertDetalleFactura) {
            // Si todo salió bien, confirmar la transacción
            mysqli_commit($conexion);
            return true;
        } else {
            // Si hubo un error en la inserción en la tabla 'detalle_factura', deshacer la transacción
            mysqli_rollback($conexion);
            return false;
        }
    } else {
        // Si hubo un error en la inserción en la tabla 'factura', deshacer la transacción
        mysqli_rollback($conexion);
        return false;
    }
}
?>