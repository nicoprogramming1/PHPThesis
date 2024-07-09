<?php
function ObtenerListaCompras($conexion) {
    $ListadoCompras = array();

    $SQL = "SELECT fechaCompra, idCompra FROM compra WHERE idEstadoCompra != 1";

    $resultado = mysqli_query($conexion, $SQL);

    $i = 0;
    while ($data = mysqli_fetch_array($resultado)) {
        $ListadoCompras[$i]['IDCOMPRA'] = $data['idCompra'];
        $ListadoCompras[$i]['FECHACOMPRA'] = $data['fechaCompra'];
        $i++;
    }

    return $ListadoCompras;
}
?>

<!-- lo uso al menos en cargar_recepcionCompra (para elegir de la lista de compras) -->