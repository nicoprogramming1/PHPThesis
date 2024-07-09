<?php
function Listar_Recibos($vConexion) {
    $Listado = array();

    $SQL = "SELECT r.nroRecibo, r.idRecibo, r.detalleRecibo, r.fechaRecibo, r.recibo, c.idCompra, c.fechaCompra
    FROM recibo r, compra c
    WHERE r.idCompra = c.idCompra";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDRECIBO'] = $data['idRecibo'];
        $Listado[$i]['NRORECIBO'] = $data['nroRecibo'];
        $Listado[$i]['DETALLERECIBO'] = $data['detalleRecibo'];
        $Listado[$i]['FECHARECIBO'] = $data['fechaRecibo'];
        $Listado[$i]['RECIBO'] = $data['recibo'];
        $Listado[$i]['IDCOMPRA'] = $data['idCompra'];
        $Listado[$i]['FECHACOMPRA'] = $data['fechaCompra'];
        $i++;
    }

    return $Listado;
}
?>