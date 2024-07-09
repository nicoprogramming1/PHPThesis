<?php
function InsertarTipoTicket($conexion, $tipoTicket, $precioTicket, $idBebida1, $idBebida2)
{
    // Escapar los datos para evitar inyecciones SQL (opcional, pero recomendado)
    $tipoTicket = mysqli_real_escape_string($conexion, $tipoTicket);
    $precioTicket = floatval($precioTicket);
    $idBebida1 = intval($idBebida1);
    $idBebida2 = intval($idBebida2);

    // Realizar la inserción en la tabla tipo_ticket
    $SQL = "INSERT INTO tipo_ticket (tipoTicket, precioTicket, idBebida1, idBebida2) 
            VALUES ('$tipoTicket', $precioTicket, $idBebida1, $idBebida2)";
    $resultado = mysqli_query($conexion, $SQL);

    if ($resultado) {
        // Inserción exitosa, puedes mostrar un mensaje de éxito o redirigir a otra página
        echo "";
    } else {
        // Ocurrió un error en la inserción
        echo "Error al registrar el tipo de ticket: " . mysqli_error($conexion);
    }
}
?>