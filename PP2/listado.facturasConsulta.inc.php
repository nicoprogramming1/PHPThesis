<?php
// Verificar si se han enviado los datos del formulario
if (isset($_POST['fechaInicio']) && isset($_POST['fechaFin'])) {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];

    // Validación y saneamiento de fechas (puedes agregar validaciones adicionales si es necesario)
    $fechaInicio = mysqli_real_escape_string($MiConexion, $fechaInicio);
    $fechaFin = mysqli_real_escape_string($MiConexion, $fechaFin);

    // Consulta SQL para listar las facturas filtradas por rango de fechas
    $SQL = "SELECT f.nroFactura, f.idFactura, f.fechaFactura, e.estadoFactura, p.nombreProveedor, d.total
            FROM factura f, estado_factura e, proveedor p, detalle_factura d
            WHERE f.idEstadoFactura = e.idEstadoFactura AND d.idProveedor = p.idProveedor AND f.idFactura = d.idFactura";
} else {
    // Consulta SQL para listar todas las facturas sin aplicar un filtro de fechas
    $SQL = "SELECT f.nroFactura, f.idFactura, f.fechaFactura, e.estadoFactura, p.nombreProveedor, d.total
            FROM factura f, estado_factura e, proveedor p, detalle_factura d
            WHERE f.idEstadoFactura = e.idEstadoFactura AND d.idProveedor = p.idProveedor AND f.idFactura = d.idFactura";
}

$Resultado = mysqli_query($MiConexion, $SQL);

$idFactura = '';

if ($Resultado) {
    $contador = 1;
    while ($factura = mysqli_fetch_assoc($Resultado)) {
        echo '<tr>';
        echo '<td>' . $contador . '</td>';
        echo '<td>' . $factura['nroFactura'] . '</td>';
        echo '<td>' . $factura['nombreProveedor'] . '</td>';
        echo '<td>' . $factura['fechaFactura'] . '</td>';
        echo '<td>' . $factura['total'] . '</td>';
        echo '<td>' . $factura['estadoFactura'] . '</td>';
        echo '<td>' . '</td>';
        $contador++;
    }
} else {
    // Manejo de errores
    echo "Error al consultar las facturas: " . mysqli_error($MiConexion);
}


?>