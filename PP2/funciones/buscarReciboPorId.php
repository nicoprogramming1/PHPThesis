<?php
function ObtenerReciboPorId($vConexion, $idRecibo) {
    $recibo = array();

    // Asegúrate de realizar la validación y saneamiento de la entrada para prevenir SQL Injection
    $idRecibo = mysqli_real_escape_string($vConexion, $idRecibo);

    // Realiza la consulta para obtener el recibo por su ID
    $SQL = "SELECT r.idRecibo, r.nroRecibo, r.detalleRecibo, r.fechaRecibo, r.recibo, c.idCompra, c.fechaCompra
            FROM recibo r, compra c
            WHERE r.idRecibo = $idRecibo AND r.idCompra = c.idCompra";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_assoc($rs);
        if ($data) {
            $recibo['NRORECIBO'] = $data['nroRecibo'];
            $recibo['IDRECIBO'] = $data['idRecibo'];
            $recibo['DETALLERECIBO'] = $data['detalleRecibo'];
            $recibo['FECHARECIBO'] = $data['fechaRecibo'];
            $recibo['IDCOMPRA'] = $data['idCompra'];
            $recibo['FECHACOMPRA'] = $data['fechaCompra'];
            $recibo['RECIBO'] = $data['recibo'];
        }
    }

    return $recibo;
}
?>