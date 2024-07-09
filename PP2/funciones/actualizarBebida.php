<?php 
function actualizarBebida($MiConexion, $idBebidaAModificar, $bebida, $marca, $volumen) {

    // Sanitiza y verifica los datos para evitar SQL injection
    $idBebidaAModificar = mysqli_real_escape_string($MiConexion, $idBebidaAModificar);
    $bebida = mysqli_real_escape_string($MiConexion, $bebida);
    $marca = mysqli_real_escape_string($MiConexion, $marca);
    $volumen = mysqli_real_escape_string($MiConexion, $volumen);

    // Consulta SQL para actualizar la bebida
    $SQL = "UPDATE bebida SET 
            bebida = '$bebida', 
            idMarca = '$marca',
            idVolumen = '$volumen'
            WHERE idBebida = '$idBebidaAModificar'";

    $resultado = mysqli_query($MiConexion, $SQL);

    return $resultado;
}
?>