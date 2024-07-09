<?php
function ModificarPromotores($conexion, $idPromotor, $nuevoNombre, $nuevoApellido)
{
    // Sanitizar los datos para evitar ataques de inyección SQL
    $idPromotor = mysqli_real_escape_string($conexion, $idPromotor);
    $nuevoNombre = mysqli_real_escape_string($conexion, $nuevoNombre);
    $nuevoApellido = mysqli_real_escape_string($conexion, $nuevoApellido);

    // Consulta para actualizar el nombre del promotor en la base de datos
    $SQL_Update_Promotor = "UPDATE promotores SET nombre = '$nuevoNombre', apellido = '$nuevoApellido' WHERE idPromotores = '$idPromotor'";

    // Ejecutamos la consulta
    if (mysqli_query($conexion, $SQL_Update_Promotor)) {
        return true; // Modificación exitosa
    } else {
        return false; // Error al modificar el promotor
    }
}
?>