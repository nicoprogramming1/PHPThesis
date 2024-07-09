<?php
$idFactura = $factura['idFactura'];

// Consulta SQL para recuperar la imagen
$SQL = "SELECT factura FROM detalle_factura WHERE idFactura = $idFactura";
$Resultado = mysqli_query($MiConexion, $SQL);

if ($Resultado && mysqli_num_rows($Resultado) > 0) {
    $fila = mysqli_fetch_assoc($Resultado);
    $imagen = $fila['factura'];

    // Configurar las cabeceras para mostrar la imagen (ajusta el tipo MIME según el formato de tus imágenes)
    header('Content-Type: image/jpeg');
    echo $imagen; // Muestra la imagen
} else {
    // Manejo de errores si la imagen no se encuentra
    echo 'Imagen no encontrada';
}
?>