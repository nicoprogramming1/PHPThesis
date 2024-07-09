<?php
function Listar_Volumenes($vConexion) {
    $Listado = array();

    $SQL = "SELECT * FROM volumen";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_assoc($rs)) {
        $Listado[$i]['IDVOLUMEN'] = $data['idVolumen'];
        $Listado[$i]['VOLUMEN'] = $data['volumen'];
        $i++;
    }

    return $Listado;
}
?>