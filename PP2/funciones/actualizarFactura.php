<?php 
function actualizarFactura($vConexion, $idFactura, $nroFactura, $importeFactura, $nuevaFecha, $nuevoDetalle, $idProveedor, $facturaNueva, $nuevoEstado) {
    // Realiza las validaciones y el saneamiento de los datos
    $idFactura = mysqli_real_escape_string($vConexion, $idFactura);
    $nroFactura = mysqli_real_escape_string($vConexion, $nroFactura);
    $importeFactura = mysqli_real_escape_string($vConexion, $importeFactura);
    $nuevaFecha = mysqli_real_escape_string($vConexion, $nuevaFecha);
    $nuevoDetalle = mysqli_real_escape_string($vConexion, $nuevoDetalle);
    $idProveedor = mysqli_real_escape_string($vConexion, $idProveedor);
    $nuevoEstado = mysqli_real_escape_string($vConexion, $nuevoEstado);

    // Obtiene la fecha y hora actuales en el formato (YYYY-MM-DD)
    $fechaHoraActual = date('Y-m-d H:i:s');

    // Formatea la fecha actual en el formato correcto para fechaPago (YYYY-MM-DD)
    $fechaPagoActual = date('Y-m-d');

    // Verifica si el nuevo estado es "Pagada" (idEstadoFactura = 2)
    if ($nuevoEstado == 2) {
        // Obtiene la fecha y hora actuales en el formato correcto (YYYY-MM-DD)
        $fechaPagoActual = date('Y-m-d');

        $SQL = "UPDATE factura SET
                fechaPago = '$fechaPagoActual'
                WHERE idFactura = $idFactura";

        if (!mysqli_query($vConexion, $SQL)) {
            return false;
        }
    }

    // Actualiza la imagen de la factura solo si se proporciona una nueva
    if (!empty($facturaNueva)) {
        $facturaNueva = mysqli_real_escape_string($vConexion, $facturaNueva);
        $SQL = "UPDATE detalle_factura SET 
                    total = '$importeFactura',
                    detalleFactura = '$nuevoDetalle', 
                    idProveedor = $idProveedor,
                    factura = '$facturaNueva'
                WHERE idFactura = $idFactura";
    } else {
        $SQL = "UPDATE detalle_factura SET 
                    total = '$importeFactura',
                    detalleFactura = '$nuevoDetalle', 
                    idProveedor = $idProveedor
                WHERE idFactura = $idFactura";
    }

    

    if (mysqli_query($vConexion, $SQL)) {
        // Actualiza los detalles de la factura
        $SQL = "UPDATE factura SET 
                    nroFactura = '$nroFactura',  
                    fechaFactura = '$nuevaFecha',
                    idEstadoFactura = '$nuevoEstado'
                WHERE idFactura = $idFactura";

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