<?php
function Listar_Asistentes($vConexion) {
    $Listado = array();

    $SQL = "SELECT * FROM asistentes";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDASISTENTES'] = $data['idAsistentes'];
        $Listado[$i]['NOMBRE'] = $data['nombre'];
        $Listado[$i]['IDDNI'] = $data['idDni'];
        $i++;
    }

    return $Listado;
}
?>