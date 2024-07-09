<?php
function ObtenerTipoTicketPorID($conexion, $idTipoTicket)
{
    // Escapar el ID del tipo ticket para evitar SQL Injection
    $idTipoTicket = (int) $idTipoTicket;

    // Consulta para obtener los datos del tipo de ticket por su ID, incluyendo las bebidas
    $sql = "SELECT t.*, b1.bebida AS bebida1, b2.bebida AS bebida2 
            FROM tipo_ticket t
            LEFT JOIN bebida b1 ON t.idBebida1 = b1.idBebida
            LEFT JOIN bebida b2 ON t.idBebida2 = b2.idBebida
            WHERE t.idTipoTicket = $idTipoTicket";

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Obtener los datos del tipo ticket como un array asociativo
        $datosTipoTicket = mysqli_fetch_assoc($resultado);

        // Liberar la memoria del resultado
        mysqli_free_result($resultado);

        return $datosTipoTicket;
    } else {
        return false; // No se encontró el tipo ticket con el ID especificado
    }
}
?>