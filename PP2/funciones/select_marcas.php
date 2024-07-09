<?php
function Listar_Marcas($vConexion) {
    $Listado = array();

    $SQL = "SELECT * FROM marca";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_assoc($rs)) {
        $Listado[$i]['IDMARCA'] = $data['idMarca'];
        $Listado[$i]['MARCA'] = $data['marca'];
        $i++;
    }

    return $Listado;
}
?>