<?php
function ObtenerBebidaPorId($vConexion, $idBebida) {
    $Bebida = array();

    // Sanitiza y verifica el ID de la bebida para evitar SQL injection
    $idBebida = mysqli_real_escape_string($vConexion, $idBebida);

    // Consulta para obtener los detalles de la bebida
    $SQL = "SELECT b.idBebida, b.bebida, b.idVolumen, b.idMarca, v.volumen, m.marca
            FROM bebida b, marca m, volumen v
            WHERE b.idBebida = $idBebida AND b.idVolumen = v.idVolumen AND b.idMarca = m.idMarca";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $Bebida['IDBEBIDA'] = $data['idBebida'];
        $Bebida['BEBIDA'] = $data['bebida'];
        $Bebida['IDMARCA'] = $data['idMarca'];
        $Bebida['MARCA'] = $data['marca'];
        $Bebida['IDVOLUMEN'] = $data['idVolumen'];
        $Bebida['VOLUMEN'] = $data['volumen'];
    }

    return $Bebida;
}

function ObtenerBebidaPorTipoTicketId($vConexion, $idTipoTicket) {
    $Bebidas = array();

    // Sanitiza y verifica el ID del ticket para evitar SQL injection
    $idTipoTicket = mysqli_real_escape_string($vConexion, $idTipoTicket);

    // Consulta para obtener los detalles de la bebida 1 asociada al tipo de ticket
    $SQL1 = "SELECT b.idBebida, b.bebida
            FROM tipo_ticket t
            INNER JOIN bebida b ON b.idBebida = t.idBebida1
            WHERE t.idTipoTicket = $idTipoTicket";

    $rs1 = mysqli_query($vConexion, $SQL1);

    if ($rs1 && mysqli_num_rows($rs1) > 0) {
        while ($data1 = mysqli_fetch_array($rs1)) {
            $Bebidas[] = $data1['idBebida'];
        }
    }

    // Consulta para obtener los detalles de la bebida 2 asociada al tipo de ticket
    $SQL2 = "SELECT b.idBebida, b.bebida
            FROM tipo_ticket t
            INNER JOIN bebida b ON b.idBebida = t.idBebida2
            WHERE t.idTipoTicket = $idTipoTicket";

    $rs2 = mysqli_query($vConexion, $SQL2);

    if ($rs2 && mysqli_num_rows($rs2) > 0) {
        while ($data2 = mysqli_fetch_array($rs2)) {
            $Bebidas[] = $data2['idBebida'];
        }
    }

    return $Bebidas;
}
?>