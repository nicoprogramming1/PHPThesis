<?php
function ObtenerOrdenCompraPorIDParaConsulta($conexion, $idOrdenCompra) {
    // Escapar el ID de la orden de compra para evitar SQL Injection
    $idOrdenCompra = (int) $idOrdenCompra;
    
    $Listado = array();

    // Consulta para obtener los datos de la orden de compra
    $sql = "SELECT oc.idOrdenCompra, oc.fechaOrdenCompra, oc.fechaModificacion, oc.fechaEnvio, eo.detalleEstadoOrdenCompra, p.nombreProveedor
            FROM orden_compra oc, estado_ordencompra eo, proveedor p
            WHERE oc.idOrdenCompra = $idOrdenCompra AND oc.idProveedor = p.idProveedor AND eo.idEstadoOrdenCompra = oc.idEstadoOrdenCompra";
    
    $rs = mysqli_query($conexion, $sql);

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