<?php
function InsertarUsuarios($vConexion, $datosUsuario) {
    // Ciframos la nueva clave usando MD5
    $claveCifrada = md5($datosUsuario['clave']);

    // Consulta para obtener el idRol correspondiente al rol seleccionado
    $SQL_Select_Roles = "SELECT idRol FROM roles WHERE rol = '".$datosUsuario['roles']."'";

    // Ejecutamos la consulta
    $rs = mysqli_query($vConexion, $SQL_Select_Roles);

    // Obtenemos el resultado de la consulta
    $data = mysqli_fetch_array($rs);

    // Verificamos que se haya encontrado el idRol
    if (!$data) {
        return false; // Error al obtener el idRol
    }

    // Obtenemos el idRol
    $idRol = $data['idRol'];

    // Consulta para insertar el nuevo usuario
    $SQL_Insert = "INSERT INTO usuarios (email, clave, nombre, apellido, idRol)
                   VALUES ('".$datosUsuario['email']."', '$claveCifrada', '".$datosUsuario['nombre']."',
                           '".$datosUsuario['apellido']."', $idRol)";

    // Ejecutamos la consulta
    if (mysqli_query($vConexion, $SQL_Insert)) {
        return true; // Registro exitoso
    } else {
        return false; // Error al insertar el registro
    }
}
?>