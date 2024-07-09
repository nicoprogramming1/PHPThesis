<?php
function ObtenerBebidaPorMarca($vConexion, $idMarca) {
    $Bebida = array();

    // Sanitiza y verifica el ID de la bebida para evitar SQL injection
    $idMarca = mysqli_real_escape_string($vConexion, $idMarca);

    // Consulta para obtener los detalles de la bebida
    $SQL = "SELECT b.idBebida, b.bebida, v.volumen
            FROM bebida b, marca m, volumen v
            WHERE b.idVolumen = v.idVolumen AND b.idMarca = $idMarca";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $Bebida['IDBEBIDA'] = $data['idBebida'];
        $Bebida['BEBIDA'] = $data['bebida'];
        $Bebida['VOLUMEN'] = $data['volumen'];
    }

    return $Bebida;
}
?>