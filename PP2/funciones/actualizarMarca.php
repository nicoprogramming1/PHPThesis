<?php 
function actualizarMarca($MiConexion, $idMarcaAModificar, $marca) {

    // Sanitiza y verifica los datos para evitar SQL injection
    $idMarcaAModificar = mysqli_real_escape_string($MiConexion, $idMarcaAModificar);
    $marca = mysqli_real_escape_string($MiConexion, $marca);

    // Consulta SQL para actualizar la bebida
    $SQL = "UPDATE marca SET 
            marca = '$marca'
            WHERE idMarca = '$idMarcaAModificar'";

    $resultado = mysqli_query($MiConexion, $SQL);

    return $resultado;
}
?>