<?php
function Listar_Eventos($vConexion) {
    $Listado = array();

    $SQL = "SELECT idEvento, detalleEvento, fechaEvento FROM evento";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_assoc($rs)) {
        $Listado[$i]['IDEVENTO'] = $data['idEvento'];
        $Listado[$i]['FECHAEVENTO'] = $data['fechaEvento'];
        $Listado[$i]['DETALLEEVENTO'] = $data['detalleEvento'];
        $i++;
    }

    return $Listado;
}
?>