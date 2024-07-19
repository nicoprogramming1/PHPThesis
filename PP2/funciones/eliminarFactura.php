<?php
function eliminarFactura($MiConexion, $idFacturaModificar)
{
    $consulta = "DELETE FROM factura WHERE idFactura = ?";
    $query = $MiConexion->prepare($consulta);
    $query->bind_param('i', $idFacturaModificar);
    
    if ($query->execute()) {
        return true; // Éxito al eliminar
    } else {
        return false; // Error al eliminar
    }
}
?>