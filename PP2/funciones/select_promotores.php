<?php
function Listar_Promotores($vConexion) {
    $Listado = array();

    $SQL = "SELECT * FROM promotores";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDPROMOTORES'] = $data['idPromotores'];
        $Listado[$i]['NOMBRE'] = $data['nombre'];
        $Listado[$i]['APELLIDO'] = $data['apellido'];
        $i++;
    }

    return $Listado;
}
?>