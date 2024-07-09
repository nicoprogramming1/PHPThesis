<?php
function Listar_Ciudades($vConexion) {
    $Listado = array();

    $SQL = "SELECT * FROM ciudad";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_assoc($rs)) {
        $Listado[$i]['IDCIUDAD'] = $data['idCiudad'];
        $Listado[$i]['CIUDAD'] = $data['ciudad'];
        $i++;
    }

    return $Listado;
}
?>