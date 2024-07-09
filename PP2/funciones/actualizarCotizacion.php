<?php 
function actualizarCotizacion($vConexion, $idCotizacionModificar, $fechaCotizacion, $cotizacionTexto, $imagenNueva, $detalleCotizacion, $idProveedor) {
    // Realiza las validaciones y el saneamiento de los datos
    $idCotizacionModificar = mysqli_real_escape_string($vConexion, $idCotizacionModificar);
    $fechaCotizacion = mysqli_real_escape_string($vConexion, $fechaCotizacion);
    $cotizacionTexto = mysqli_real_escape_string($vConexion, $cotizacionTexto);
    $detalleCotizacion = mysqli_real_escape_string($vConexion, $detalleCotizacion);
    $idProveedor = mysqli_real_escape_string($vConexion, $idProveedor);

    // Actualiza la imagen de la cotización solo si se proporciona una nueva
    $SQL = "UPDATE cotizacion SET 
                cotizacionTexto = '$cotizacionTexto',
                fechaCotizacion = '$fechaCotizacion',
                detalleCotizacion = '$detalleCotizacion',
                idProveedor = '$idProveedor'";

    // Si se proporciona una nueva imagen
    if (!empty($imagenNueva)) {
        $imagenNueva = mysqli_real_escape_string($vConexion, base64_encode($imagenNueva));
        $SQL .= ", cotizacionImagen = '$imagenNueva'";
    }

    $SQL .= " WHERE idCotizacion = '$idCotizacionModificar'";

    if (mysqli_query($vConexion, $SQL)) {
        return true;
    } else {
        return false;
    }
}
?>