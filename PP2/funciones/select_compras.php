<?php
function Listar_Compras($vConexion) {
    $Listado = array();

    $SQL = "SELECT f.nroFactura, f.idFactura, df.total, c.idCompra, e.estadoCompra, c.fechaEntregaPrevista, c.fechaCompra, p.nombreProveedor, dc.idOrdenCompra
            FROM factura f
            INNER JOIN detalle_factura df ON f.idFactura = df.idFactura
            INNER JOIN detalle_compra dc ON dc.idFactura = f.idFactura
            INNER JOIN compra c ON dc.idCompra = c.idCompra
            INNER JOIN estado_compra e ON e.idEstadoCompra = c.idEstadoCompra
            INNER JOIN proveedor p ON df.idProveedor = p.idProveedor";

    $rs = mysqli_query($vConexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($rs)) {
        $Listado[$i]['IDCOMPRA'] = $data['idCompra'];
        $Listado[$i]['NROFACTURA'] = $data['nroFactura'];
        $Listado[$i]['PROVEEDOR'] = $data['nombreProveedor'];
        $Listado[$i]['FECHACOMPRA'] = $data['fechaCompra'];
        $Listado[$i]['FECHAENTREGAPREVISTA'] = $data['fechaEntregaPrevista'];
        $Listado[$i]['IMPORTE'] = $data['total'];
        $Listado[$i]['ESTADOCOMPRA'] = $data['estadoCompra'];
        $Listado[$i]['IDORDENCOMPRA'] = $data['idOrdenCompra'];
        $i++;
    }

    return $Listado;
}
?>