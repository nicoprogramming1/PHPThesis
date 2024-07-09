<?php
function InsertarAsistenteEvento($MiConexion, $asistente, $idPromotorReferido, $idEvento)
{
    $asistente = mysqli_real_escape_string($MiConexion, $asistente);
    $idEvento = mysqli_real_escape_string($MiConexion, $idEvento);
    $idPromotorReferido = mysqli_real_escape_string($MiConexion, $idPromotorReferido);

    $sql = "INSERT INTO asistentes_evento (asistente, idEvento, idPromotorReferido) VALUES ('$asistente', '$idEvento', '$idPromotorReferido')";
    if (mysqli_query($MiConexion, $sql)) {
        return true; // Se insertó correctamente
    } else {
        return false; // Hubo un error
    }
}
?>