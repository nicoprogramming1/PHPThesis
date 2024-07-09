<?php
function ModificarRol($vConexion, $idRol, $nuevoNombre) {
    // Sanitizar los datos para evitar ataques de inyección SQL
    $idRol = mysqli_real_escape_string($vConexion, $idRol);
    $nuevoNombre = mysqli_real_escape_string($vConexion, $nuevoNombre);

    // Consulta para actualizar el nombre del rol en la base de datos
    $SQL_Update_Rol = "UPDATE roles SET rol = '$nuevoNombre' WHERE idRol = '$idRol'";

    // Ejecutamos la consulta
    if (mysqli_query($vConexion, $SQL_Update_Rol)) {
        return true; // Modificación exitosa
    } else {
        return false; // Error al modificar el rol
    }
}
?>