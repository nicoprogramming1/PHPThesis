<?php
function ObtenerRecepcionPorId($vConexion, $idRecepcionCompra) {
    $recepcionCompra = array();

    // Sanitiza y verifica el ID de la recepcion para evitar SQL injection
    $idRecepcionCompra = mysqli_real_escape_string($vConexion, $idRecepcionCompra);

    // Consulta para obtener los detalles de la recepcion
    $SQL = "SELECT rc.idRecepcionCompra, rc.fechaRecepcionCompra, e.estadoRecepcion, e.idEstadoRecepcion, rc.idCompra, d.detalleRecepcion, re.idRemito, re.detalleRemito, re.fechaRemito, re.nroRemito, re.remito, d.detalleMercaderia
            FROM recepcion_compra rc, detalle_recepcioncompra d, remito re, estado_recepcion e
            WHERE rc.idRecepcionCompra = $idRecepcionCompra AND d.idRecepcionCompra = rc.idRecepcionCompra AND rc.idEstadoRecepcionCompra = e.idEstadoRecepcion AND d.idRemito = re.idRemito";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $recepcionCompra['IDRECEPCIONCOMPRA'] = $data['idRecepcionCompra'];
        $recepcionCompra['FECHARECEPCIONCOMPRA'] = $data['fechaRecepcionCompra'];
        $recepcionCompra['ESTADORECEPCION'] = $data['estadoRecepcion'];
        $recepcionCompra['IDESTADORECEPCION'] = $data['idEstadoRecepcion'];
        $recepcionCompra['IDCOMPRA'] = $data['idCompra'];
        $recepcionCompra['DETALLERECEPCION'] = $data['detalleRecepcion'];
        $recepcionCompra['IDREMITO'] = $data['idRemito'];
        $recepcionCompra['DETALLEREMITO'] = $data['detalleRemito'];
        $recepcionCompra['FECHAREMITO'] = $data['fechaRemito'];
        $recepcionCompra['NROREMITO'] = $data['nroRemito'];
        $recepcionCompra['REMITO'] = $data['remito'];
        $recepcionCompra['DETALLEMERCADERIA'] = $data['detalleMercaderia'];
    }

    return $recepcionCompra;
}
?>