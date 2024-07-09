<?php
function EliminarTipoTicket($conexion, $idTipoTicket)
{
    $idTipoTicket = mysqli_real_escape_string($conexion, $idTipoTicket);

    // Consulta para eliminar el asistente de la base de datos
    $SQL_Delete_TipoTicket = "DELETE FROM tipo_ticket WHERE idTipoTicket = '$idTipoTicket'";

    // Ejecutamos la consulta
    if (mysqli_query($conexion, $SQL_Delete_TipoTicket)) {
        return true; // Eliminación exitosa
    } else {
        return false; // Error al eliminar el tipo de ticket
    }
}
?>