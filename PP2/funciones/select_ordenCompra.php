<?php
function Listar_ordenCompra($vConexion) {
    $Listado = array();
    $SQL = "SELECT oc.idOrdenCompra, oc.fechaOrdenCompra, oc.fechaModificacion, oc.fechaEnvio, eo.detalleEstadoOrdenCompra, p.nombreProveedor
    FROM orden_compra oc, estado_ordencompra eo, proveedor p
    WHERE oc.idProveedor = p.idProveedor AND eo.idEstadoOrdenCompra = oc.idEstadoOrdenCompra AND oc.idEstadoOrdenCompra = 0
    ORDER BY oc.fechaOrdenCompra DESC";

    $rs = mysqli_query($vConexion, $SQL);
    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDORDENCOMPRA'] = $data['idOrdenCompra'];
        $Listado[$i]['FECHAORDENCOMPRA'] = $data['fechaOrdenCompra'];
        $Listado[$i]['ESTADOORDENCOMPRA'] = $data['detalleEstadoOrdenCompra'];
        $Listado[$i]['PROVEEDORORDENCOMPRA'] = $data['nombreProveedor'];
        $Listado[$i]['FECHAMODIFICACION'] = $data['fechaModificacion'];
        $Listado[$i]['FECHAENVIO'] = $data['fechaEnvio'];
        $i++;
    }
    return $Listado;
}
?>