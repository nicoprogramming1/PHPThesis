<?php

if (!empty($_POST['BotonConsultar'])) {
    $selectedFecha1 = $_POST['fechaInicio'];
    $selectedFecha2 = $_POST['fechaFin'];

    $selectedFecha1 = mysqli_real_escape_string($MiConexion, $selectedFecha1);
    $selectedFecha2 = mysqli_real_escape_string($MiConexion, $selectedFecha2);

    // Consulta SQL para obtener las ventas entre las fechas seleccionadas
    $sql = "SELECT f.nroFactura, f.idFactura, f.fechaFactura, e.estadoFactura, p.nombreProveedor, d.total
            FROM factura f
            INNER JOIN detalle_factura d ON f.idFactura = d.idFactura
            INNER JOIN proveedor p ON d.idProveedor = p.idProveedor
            INNER JOIN estado_factura e ON f.idEstadoFactura = e.idEstadoFactura
            WHERE f.fechaFactura BETWEEN '$selectedFecha1' AND '$selectedFecha2'
            ORDER BY f.fechaFactura DESC";
    
    $Resultado = mysqli_query($MiConexion, $sql);
}
else {

    $sql = "SELECT f.nroFactura, f.idFactura, f.fechaFactura, e.estadoFactura, p.nombreProveedor, d.total
    FROM factura f
    INNER JOIN detalle_factura d ON f.idFactura = d.idFactura
    INNER JOIN proveedor p ON d.idProveedor = p.idProveedor
    INNER JOIN estado_factura e ON f.idEstadoFactura = e.idEstadoFactura
    ORDER BY f.fechaFactura DESC";

$Resultado = mysqli_query($MiConexion, $sql);
}

$contador = 1;
$idFactura = '';

    if ($Resultado) {
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