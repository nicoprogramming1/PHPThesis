<?php
function InsertarCotizacionEnBaseDeDatos($conexion) {
    $detalleCotizacion = mysqli_real_escape_string($conexion, $_POST['detalleCotizacion']);
    $fechaCotizacion = mysqli_real_escape_string($conexion, $_POST['fechaCotizacion']);
    $proveedor = mysqli_real_escape_string($conexion, $_POST['proveedor']);
    
    // Inicializa las variables
    $cotizacionImagen = '';
    $cotizacionTexto = '';

    // Verifica si cotizacionImagen o cotizacionTexto está presente y asigna el valor adecuado
    if (!empty($_FILES['cotizacionImagen']['tmp_name'])) {
        // Lógica para manejar cotizacionImagen
        $imagenTemporal = file_get_contents($_FILES['cotizacionImagen']['tmp_name']);
        $cotizacionImagen = mysqli_real_escape_string($conexion, base64_encode($imagenTemporal));
    } elseif (!empty($_POST['cotizacionTexto'])) {
        // Lógica para manejar cotizacionTexto
        $cotizacionTexto = mysqli_real_escape_string($conexion, $_POST['cotizacionTexto']);
    }

    // Realiza la inserción en la tabla cotizacion
    $query = "INSERT INTO cotizacion (detalleCotizacion, fechaCotizacion, idProveedor, cotizacionImagen, cotizacionTexto) VALUES ('$detalleCotizacion', STR_TO_DATE('$fechaCotizacion', '%d/%m/%y'), '$proveedor', '$cotizacionImagen', '$cotizacionTexto')";

    $resultado = mysqli_query($conexion, $query);

    return $resultado;
}
?>

