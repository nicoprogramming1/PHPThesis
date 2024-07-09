<?php 
function DatosLogin($vUsuario, $vClave, $vConexion)
{
    $Usuario = array();

    $SQL = "SELECT u.idUsuario, u.email, r.rol, u.nombre, u.apellido
            FROM usuarios as u
            JOIN roles as r ON u.idRol = r.idRol
            WHERE u.email = '$vUsuario' AND u.clave = MD5('$vClave')";

    $rs = mysqli_query($vConexion, $SQL);

    $data = mysqli_fetch_array($rs);
    if (!empty($data)) {
        $Usuario['ID'] = $data['idUsuario'];
        $Usuario['EMAIL'] = $data['email'];
        $Usuario['ROL'] = $data['rol'];
        $Usuario['NOMBRE'] = $data['nombre'];
        $Usuario['APELLIDO'] = $data['apellido'];
    }
    return $Usuario;
}

?>