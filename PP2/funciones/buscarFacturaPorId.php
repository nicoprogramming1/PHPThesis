<?php
function ObtenerFacturaPorId($vConexion, $idFactura) {
    $factura = array();

    // Asegúrate de realizar la validación y saneamiento de la entrada para prevenir SQL Injection
    $idFactura = mysqli_real_escape_string($vConexion, $idFactura);

    // Realiza la consulta para obtener la factura por su ID
    $SQL = "SELECT f.nroFactura, f.fechaFactura, f.idEstadoFactura, d.total, d.detalleFactura, d.factura, p.nombreProveedor
            FROM factura f, proveedor p, detalle_factura d
            WHERE f.idFactura = $idFactura AND d.idProveedor = p.idProveedor AND d.idFactura = f.idFactura";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_assoc($rs);
        if ($data) {
            $factura['nroFactura'] = $data['nroFactura'];
            $factura['fechaFactura'] = $data['fechaFactura'];
            $factura['idEstadoFactura'] = $data['idEstadoFactura'];
            $factura['importe'] = $data['total'];
            $factura['detalleFactura'] = $data['detalleFactura'];
            $factura['nombreProveedor'] = $data['nombreProveedor'];
            $factura['factura'] = $data['factura'];
        }
    }

    return $factura;
}
?>