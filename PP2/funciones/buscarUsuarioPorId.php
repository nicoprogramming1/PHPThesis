<?php
function ObtenerUsuarioPorId($vConexion, $idUsuario)
{
    $usuario = array();

    // Asegúrate de realizar la validación y saneamiento de la entrada para prevenir SQL Injection
    $idUsuario = mysqli_real_escape_string($vConexion, $idUsuario);

    // Realiza la consulta para obtener el usaurio por su ID
    $SQL = "SELECT u.idUsuario, u.email, u.nombre, u.apellido, u.idRol, r.rol
            FROM usuarios u, email e, roles r
            WHERE u.idUsuario = $idUsuario AND u.idRol = r.idRol";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_assoc($rs);
        if ($data) {
            $usuario['IDUSUARIO'] = $data['idUsuario'];
            $usuario['EMAIL'] = $data['email'];
            $usuario['NOMBRE'] = $data['nombre'];
            $usuario['APELLIDO'] = $data['apellido'];
            $usuario['IDROL'] = $data['idRol'];
            $usuario['ROL'] = $data['rol'];
        }
    }

    return $usuario;
}
?>