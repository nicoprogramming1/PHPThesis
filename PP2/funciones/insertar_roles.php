<?php
function InsertarRol($vConexion, $nombreRol) {
    // Consulta para verificar si el rol ya existe en la base de datos
    $SQL_Select_Rol = "SELECT COUNT(*) AS total FROM roles WHERE rol = '$nombreRol'";

    // Ejecutamos la consulta
    $rs = mysqli_query($vConexion, $SQL_Select_Rol);

    // Obtenemos el resultado de la consulta
    $data = mysqli_fetch_array($rs);

    // Verificamos si el rol ya existe
    if ($data['total'] > 0) {
        return false; // El rol ya existe, no se puede insertar nuevamente
    }

    // Consulta para insertar el nuevo rol
    $SQL_Insert = "INSERT INTO roles (rol) VALUES ('$nombreRol')";

    // Ejecutamos la consulta
    if (mysqli_query($vConexion, $SQL_Insert)) {
        return true; // Registro exitoso
    } else {
        return false; // Error al insertar el registro
    }
}
?>