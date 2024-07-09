<?php
function ObtenerCompraPorId($vConexion, $idCompra) {
    $Compra = array();

    // Sanitiza y verifica el ID de la compra para evitar SQL injection
    $idCompra = mysqli_real_escape_string($vConexion, $idCompra);

    // Consulta para obtener los detalles de la compra
    $SQL = "SELECT c.idCompra, c.fechaEntregaPrevista, dc.detalleCompra, dc.idOrdenCompra, f.idFactura
            FROM compra c
            INNER JOIN detalle_compra dc ON c.idCompra = dc.idCompra
            INNER JOIN factura f ON dc.idFactura = f.idFactura
            WHERE c.idCompra = $idCompra";

    $rs = mysqli_query($vConexion, $SQL);

    if ($rs) {
        $data = mysqli_fetch_array($rs);

        $Compra['idCompra'] = $data['idCompra'];
        $Compra['fechaEntregaPrevista'] = $data['fechaEntregaPrevista'];
        $Compra['detalleCompra'] = $data['detalleCompra'];
        $Compra['idOrdenCompra'] = $data['idOrdenCompra'];
        $Compra['idFactura'] = $data['idFactura'];
    }

    return $Compra;
}
?>