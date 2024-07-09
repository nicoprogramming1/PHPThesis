<?php
function Listar_Reclamos($vConexion) {
    $Listado = array();

    $SQL = "SELECT re.idReclamo, re.fechaReclamo, re.idEstadoReclamo, d.idRecepcionCompra, d.idProveedor, d.detalleReclamo, p.nombreProveedor, e.estadoReclamo, p.nombreProveedor, rc.fechaRecepcionCompra, re.fechaCambioEstadoReclamo
            FROM reclamo re, detalle_reclamo d, estado_reclamo e, proveedor p, recepcion_compra rc
            WHERE re.idEstadoReclamo = e.idEstadoReclamo AND d.idProveedor = p.idProveedor AND d.idReclamo = re.idReclamo AND d.idRecepcionCompra = rc.idRecepcionCompra AND re.idEstadoReclamo = 0";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDRECLAMO'] = $data['idReclamo'];
        $Listado[$i]['FECHARECLAMO'] = $data['fechaReclamo'];
        $Listado[$i]['DETALLERECLAMO'] = $data['detalleReclamo'];
        $Listado[$i]['FECHACAMBIOESTADORECLAMO'] = $data['fechaCambioEstadoReclamo'];
        $Listado[$i]['IDESTADORECLAMO'] = $data['idEstadoReclamo'];
        $Listado[$i]['ESTADORECLAMO'] = $data['estadoReclamo'];
        $Listado[$i]['IDRECEPCIONCOMPRA'] = $data['idRecepcionCompra'];
        $Listado[$i]['FECHARECEPCIONCOMPRA'] = $data['fechaRecepcionCompra'];
        $Listado[$i]['IDPROVEEDOR'] = $data['idProveedor'];
        $Listado[$i]['PROVEEDOR'] = $data['nombreProveedor'];
        $i++;
    }

    return $Listado;
}
?>