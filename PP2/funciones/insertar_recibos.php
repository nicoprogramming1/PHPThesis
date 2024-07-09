<?php
function InsertarReciboEnBaseDeDatos($conexion)
{
    // Obtener los datos del formulario
    $nroRecibo = mysqli_real_escape_string($conexion, $_POST['nroRecibo']);
    $detalleRecibo = mysqli_real_escape_string($conexion, $_POST['detalleRecibo']);
    $idCompra = intval($_POST['idCompra']);
    $fechaRecibo = $_POST['fechaRecibo']; // Asegurarse de que el formato sea válido

    // Obtener el archivo del recibo
    $recibo = $_FILES['recibo'];

    // Verificar si se subió un archivo
    if ($recibo['error'] == UPLOAD_ERR_OK) {
        // Leer el contenido del archivo y convertirlo a base64
        $reciboContenido = base64_encode(file_get_contents($recibo['tmp_name']));
    } else {
        // Si no se subió un archivo, puedes manejarlo aquí según tus necesidades
        $reciboContenido = null; // O lo que consideres apropiado
    }

    // Iniciar una transacción
    mysqli_begin_transaction($conexion);

    // Preparar la consulta para la inserción en la tabla 'recibo'
    $sqlInsertRecibo = "INSERT INTO recibo (nroRecibo, fechaRecibo, detalleRecibo, idCompra, recibo) 
                        VALUES ('$nroRecibo', STR_TO_DATE('$fechaRecibo', '%d/%m/%y'), '$detalleRecibo', $idCompra, '$reciboContenido')";

    // Ejecutar la consulta de inserción
    $resultadoInsertRecibo = mysqli_query($conexion, $sqlInsertRecibo);

    if ($resultadoInsertRecibo) {
        // Confirmar la transacción si la inserción fue exitosa
        mysqli_commit($conexion);
        return true;
    } else {
        // Si hubo algún error, deshacer la transacción
        mysqli_rollback($conexion);
        return false;
    }
}
?>