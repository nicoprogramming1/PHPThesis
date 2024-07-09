<?php
function ObtenerBebidaPorVolumen($vConexion, $idVolumen) {
    $Bebida = array();

    // Sanitiza y verifica el ID de la bebida para evitar SQL injection
    $idVolumen = mysqli_real_escape_string($vConexion, $idVolumen);

    // Consulta para obtener los detalles de la bebida
    $SQL = "SELECT b.idBebida, b.bebida, m.marca
            FROM bebida b, marca m
            WHERE b.idMarca = m.idMarca AND b.idVolumen = $idVolumen";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $Bebida['IDBEBIDA'] = $data['idBebida'];
        $Bebida['BEBIDA'] = $data['bebida'];
        $Bebida['MARCA'] = $data['marca'];
    }

    return $Bebida;
}
?>