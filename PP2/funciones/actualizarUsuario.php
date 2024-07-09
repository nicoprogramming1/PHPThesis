<?php
function actualizarUsuario($vConexion, $idUsuario) {
    // Ciframos la nueva clave usando MD5, si se ha proporcionado una nueva clave
    if (!empty($_POST['clave'])) {
        $claveCifrada = md5($_POST['clave']);
    } else {
        // Consulta para obtener la clave actual del usuario
        $SQL_Select_Clave = "SELECT clave FROM usuarios WHERE idUsuario = '".$idUsuario."'";

        // Ejecutamos la consulta
        $rs1 = mysqli_query($vConexion, $SQL_Select_Clave);

        // Obtenemos el resultado de la consulta
        $data1 = mysqli_fetch_array($rs1);

        // Obtenemos la clave
        $claveCifrada = $data1['clave'];
    }

    // Obtenemos el idRol
    $idRol = $_POST['rol'];

    // Consulta para actualizar el usuario existente
    $SQL_Update = "UPDATE usuarios SET
                   email = '".$_POST['email']."',
                   clave = '$claveCifrada',
                   nombre = '".$_POST['nombre']."',
                   apellido = '".$_POST['apellido']."',
                   idRol = $idRol
                   WHERE idUsuario = ".$idUsuario;

    if (!mysqli_query($vConexion, $SQL_Update)) {
        // Si surge un error, finalizo la ejecución del script con un mensaje
        die('<h4>Error al intentar modificar el registro.</h4>');
    }

    return true;
}
?>