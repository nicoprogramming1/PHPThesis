<?php
function ListarRoles($vConexion) {
    $Listado = array();

    $SQL = "SELECT rol, idRol FROM roles";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['ROLES'] = $data['rol'];
        $Listado[$i]['IDROL'] = $data['idRol'];
        $i++;
    }

    return $Listado;
}
?>