<?php
function EliminarPromotor($conexion, $idPromotor)
{
    // Sanitizar el ID del promotor para evitar ataques de inyección SQL
    $idPromotor = mysqli_real_escape_string($conexion, $idPromotor);

    // Consulta para eliminar el promotor de la base de datos
    $SQL_Delete_Promotor = "DELETE FROM promotores WHERE idPromotores = '$idPromotor'";

    // Ejecutamos la consulta
    if (mysqli_query($conexion, $SQL_Delete_Promotor)) {
        $Mensaje = 'Eliminación exitosa';
        return true;
    } else {
        $Mensaje = 'Se ha producido un error';
        return false;
    }
}
?>