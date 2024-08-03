<?php
function Listar_Recepciones($vConexion) {
    $Listado = array();

    $SQL = "SELECT rc.idRecepcionCompra, rc.idCompra, rc.fechaRecepcionCompra, e.estadoRecepcion, re.nroRemito
            FROM recepcion_compra rc, estado_recepcion e, remito re, detalle_recepcioncompra d
            WHERE rc.idEstadoRecepcionCompra = e.idEstadoRecepcion AND rc.idRecepcionCompra = d.idRecepcionCompra AND d.idRemito = re.idRemito
            ORDER BY rc.fechaRecepcionCompra DESC";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDRECEPCIONCOMPRA'] = $data['idRecepcionCompra'];
        $Listado[$i]['IDCOMPRA'] = $data['idCompra'];
        $Listado[$i]['FECHARECEPCIONCOMPRA'] = $data['fechaRecepcionCompra'];
        $Listado[$i]['ESTADORECEPCIONCOMPRA'] = $data['estadoRecepcion'];
        $Listado[$i]['NROREMITO'] = $data['nroRemito'];
        $i++;
    }

    return $Listado;
}
?>