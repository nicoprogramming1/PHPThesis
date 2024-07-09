<?php
if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    // Asegúrate de que las fechas tengan el formato de timestamp
    $fechaInicio = date("Y-m-d H:i:s", strtotime($fechaInicio));
    $fechaFin = date("Y-m-d H:i:s", strtotime($fechaFin));

    // Consulta SQL para listar las compras filtradas por rango de fechas de fechaCompra
    $SQL = "SELECT f.nroFactura, f.fechaFactura, e.estadoCompra, p.nombreProveedor, d.total, c.fechaCompra, c.fechaEntregaPrevista, dc.idOrdenCompra, c.idCompra
            FROM factura f, estado_compra e, proveedor p, detalle_factura d, compra c, detalle_compra dc
            WHERE c.idEstadoCompra = e.idEstadoCompra AND d.idProveedor = p.idProveedor AND f.idFactura = dc.idFactura
            AND c.fechaCompra >= '$fechaInicio' AND c.fechaCompra <= '$fechaFin'";
} else {
    // Consulta SQL para listar todas las compras sin aplicar un filtro de fechas
    $SQL = "SELECT f.nroFactura, f.fechaFactura, e.estadoCompra, p.nombreProveedor, d.total, c.fechaCompra, c.fechaEntregaPrevista, dc.idOrdenCompra, c.idCompra
            FROM factura f, estado_compra e, proveedor p, detalle_factura d, compra c, detalle_compra dc
            WHERE c.idEstadoCompra = e.idEstadoCompra AND d.idProveedor = p.idProveedor AND f.idFactura = dc.idFactura";
}

// Verificar si $SQL se definió correctamente antes de ejecutar la consulta
if (!empty($SQL)) {
    $Resultado = mysqli_query($MiConexion, $SQL);

    if ($Resultado) {
        $contador = 1;
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
} else {
    // Si $SQL está vacío, mostrar un mensaje de error o realizar otra acción necesaria
    echo "La consulta SQL está vacía. Verifica la lógica de tu código.";
}
?>