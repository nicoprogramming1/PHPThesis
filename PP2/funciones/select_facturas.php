<?php
function Listar_Facturas($vConexion) {
    $Listado = array();

    $SQL = "SELECT f.nroFactura, f.idFactura, f.fechaFactura, d.total, e.estadoFactura, p.nombreProveedor
    FROM factura f, detalle_factura d, estado_factura e, proveedor p
    WHERE d.idFactura = f.idFactura AND d.idProveedor = p.idProveedor AND e.idEstadoFactura = f.idEstadoFactura";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDFACTURA'] = $data['idFactura'];
        $Listado[$i]['NROFACTURA'] = $data['nroFactura'];
        $Listado[$i]['IMPORTE'] = $data['total'];
        $Listado[$i]['FECHAFACTURA'] = $data['fechaFactura'];
        $Listado[$i]['ESTADOFACTURA'] = $data['estadoFactura'];
        $Listado[$i]['PROVEEDOR'] = $data['nombreProveedor'];
        $i++;
    }

    return $Listado;
}
?>