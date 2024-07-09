<?php
$contador = 1;
$total = 0;

foreach ($ListadoTipoTickets as $ticket) {
    $idTipoTicket = $ticket['IDTIPOTICKET'];
    echo '<tr>';
    echo '<td>' . $contador . '</td>';
    echo '<td>' . $ticket['TIPOTICKET'] . '</td>';
    echo '<td>$ ' . $ticket['PRECIOTICKET'] . '</td>';
    echo '<td><input type="text" name="cantidad_' . $idTipoTicket . '" value="0"></td>';
    echo '</tr>';

    // Obtener la cantidad del formulario para cada ticket
    if (!empty($_POST['cantidad_' . $idTipoTicket])) {
        $cantidad = (int)$_POST['cantidad_' . $idTipoTicket];
    } else {
        $cantidad = 0;
    }

    // Calcular el total para cada ticket
    $total += $ticket['PRECIOTICKET'] * $cantidad;

    $contador++;
}

?>