<?php
function ObtenerReclamoPorId($vConexion, $idReclamo) {
    $reclamo = array();

    // Sanitiza y verifica el ID del reclamo para evitar SQL injection
    $idReclamo = mysqli_real_escape_string($vConexion, $idReclamo);

    // Consulta para obtener los detalles del reclamo
    $SQL = "SELECT re.idReclamo, re.fechaReclamo, re.idEstadoReclamo, d.idRecepcionCompra, d.idProveedor, d.detalleReclamo, p.nombreProveedor, e.estadoReclamo, p.nombreProveedor, rc.fechaRecepcionCompra
            FROM reclamo re, detalle_reclamo d, estado_reclamo e, proveedor p, recepcion_compra rc
            WHERE re.idEstadoReclamo = e.idEstadoReclamo AND d.idProveedor = p.idProveedor AND d.idReclamo = re.idReclamo AND d.idRecepcionCompra = rc.idRecepcionCompra AND re.idReclamo = $idReclamo";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $reclamo['IDRECLAMO'] = $data['idReclamo'];
        $reclamo['FECHARECLAMO'] = $data['fechaReclamo'];
        $reclamo['DETALLERECLAMO'] = $data['detalleReclamo'];
        $reclamo['IDESTADORECLAMO'] = $data['idEstadoReclamo'];
        $reclamo['ESTADORECLAMO'] = $data['estadoReclamo'];
        $reclamo['IDRECEPCIONCOMPRA'] = $data['idRecepcionCompra'];
        $reclamo['FECHARECEPCIONCOMPRA'] = $data['fechaRecepcionCompra'];
        $reclamo['IDPROVEEDOR'] = $data['idProveedor'];
        $reclamo['PROVEEDOR'] = $data['nombreProveedor'];
    }

    return $reclamo;
}
?>