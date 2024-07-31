<?php
if (!empty($_POST['BotonConsultar'])) {
    $selectedFecha1 = $_POST['fechaInicio'];
    $selectedFecha2 = $_POST['fechaFin'];

    $selectedFecha1 = mysqli_real_escape_string($MiConexion, $selectedFecha1);
    $selectedFecha2 = mysqli_real_escape_string($MiConexion, $selectedFecha2);


    // Consulta SQL para listar las compras filtradas por rango de fechas de fechaCompra
    $sql = "SELECT f.nroFactura, f.fechaFactura, e.estadoCompra, p.nombreProveedor,
               d.total, c.fechaCompra, c.fechaEntregaPrevista, dc.idOrdenCompra, c.idCompra
        FROM factura f
        INNER JOIN detalle_compra dc ON f.idFactura = dc.idFactura
        INNER JOIN compra c ON dc.idCompra = c.idCompra
        INNER JOIN estado_compra e ON c.idEstadoCompra = e.idEstadoCompra
        INNER JOIN detalle_factura d ON f.idFactura = d.idFactura
        INNER JOIN proveedor p ON d.idProveedor = p.idProveedor
        WHERE c.fechaCompra BETWEEN '$selectedFecha1' AND '$selectedFecha2'
        ORDER BY c.fechaCompra DESC";

    $Resultado = mysqli_query($MiConexion, $sql);

} else {
    // Consulta SQL para listar todas las compras sin aplicar un filtro de fechas
    $sql = "SELECT f.nroFactura, f.fechaFactura, e.estadoCompra, p.nombreProveedor,
               d.total, c.fechaCompra, c.fechaEntregaPrevista, dc.idOrdenCompra, c.idCompra
        FROM factura f
        INNER JOIN detalle_compra dc ON f.idFactura = dc.idFactura
        INNER JOIN compra c ON dc.idCompra = c.idCompra
        INNER JOIN estado_compra e ON c.idEstadoCompra = e.idEstadoCompra
        INNER JOIN detalle_factura d ON f.idFactura = d.idFactura
        INNER JOIN proveedor p ON d.idProveedor = p.idProveedor
        ORDER BY c.fechaCompra DESC";

    $Resultado = mysqli_query($MiConexion, $sql);
}
$contador = 1;
if ($Resultado) {
    while ($compra = mysqli_fetch_assoc($Resultado)) {
        echo '<tr>';
        echo '<td>' . $contador . '</td>';
        echo '<td>' . $compra['idCompra'] . '</td>';
        echo '<td>' . $compra['nroFactura'] . '</td>';
        echo '<td>' . $compra['nombreProveedor'] . '</td>';
        echo '<td>' . $compra['fechaCompra'] . '</td>';
        echo '<td>' . $compra['fechaEntregaPrevista'] . '</td>';
        echo '<td>' . $compra['total'] . '</td>';
        echo '<td>' . $compra['estadoCompra'] . '</td>';
        echo '<td>' . $compra['idOrdenCompra'] . '</td>';
        echo '<td>' . '</td>';
        $contador++;
    }
} else {
    // Manejo de errores
    echo "Error al consultar las compras: " . mysqli_error($MiConexion);
}
?>