<?php
function ModificarTipoTicket($conexion, $idTipoTicketSeleccionado, $nuevoTipoTicket, $nuevoPrecioTipoTicket, $nuevoPrimeraBebida, $nuevoSegundaBebida)
{
    // Sanitizar los datos para evitar ataques de inyección SQL
    $idTipoTicketSeleccionado = mysqli_real_escape_string($conexion, $idTipoTicketSeleccionado);
    $nuevoTipoTicket = mysqli_real_escape_string($conexion, $nuevoTipoTicket);
    $nuevoPrecioTipoTicket = mysqli_real_escape_string($conexion, $nuevoPrecioTipoTicket);
    $nuevoPrimeraBebida = mysqli_real_escape_string($conexion, $nuevoPrimeraBebida);
    $nuevoSegundaBebida = mysqli_real_escape_string($conexion, $nuevoSegundaBebida);

    // Consulta para actualizar al tipo de ticket en la base de datos
    $SQL_Update_TipoTicket = "UPDATE tipo_ticket SET tipoTicket = '$nuevoTipoTicket', precioTicket = '$nuevoPrecioTipoTicket', idbebida1 = '$nuevoPrimeraBebida', idbebida2 = '$nuevoSegundaBebida' WHERE idTipoTicket = '$idTipoTicketSeleccionado'";

    // Ejecutamos la consulta
    if (mysqli_query($conexion, $SQL_Update_TipoTicket)) {
        return true; // Modificación exitosa
    } else {
        return false; // Error al modificar el tipo de ticket
    }
}
?>