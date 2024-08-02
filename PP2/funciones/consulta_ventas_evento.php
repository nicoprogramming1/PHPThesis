<?php
function countVentasEvento($MiConexion, $idEvento)
{
    $query = "SELECT COUNT(*) AS countVentas FROM detalle_venta WHERE idEvento = ?";
    $stmt = $MiConexion->prepare($query);
    $stmt->bind_param('i', $idEvento);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontraron registros
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $countVentas = $row['countVentas'];
        return $countVentas > 0 ? $countVentas : 0;
    } else {
        return 0;
    }
}

function totalVentasEvento($MiConexion, $idEvento)
{
    $sql = "SELECT SUM(dv.totalVenta) AS GANANCIA
            FROM evento e
            INNER JOIN detalle_venta dv ON e.idEvento = dv.idEvento
            WHERE e.idEvento = ?";

    $stmt = $MiConexion->prepare($sql);
    $stmt->bind_param('i', $idEvento);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        return $row['GANANCIA'];
    } else {
        return 0; // Si no se encontraron ventas, la ganancia es cero
    }
}

?>