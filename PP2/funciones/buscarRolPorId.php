<?php
function buscarRolPorId($vConexion, $idUsuario)
{
    $rol = array();

    // Sanitiza y verifica el ID del usuario para evitar SQL injection
    $idUsuario = mysqli_real_escape_string($vConexion, $idUsuario);

    // Consulta para obtener los detalles del rol
    $SQL = "SELECT r.idRol, r.rol
            from roles r, usuarios u
            where u.idUsuario = $idUsuario AND u.idRol = r.idRol";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $rol['IDROL'] = $data['idRol'];
        $rol['ROL'] = $data['rol'];
    }

    return $rol;
}
?>