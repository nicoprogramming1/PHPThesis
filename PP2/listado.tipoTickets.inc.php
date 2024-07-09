<?php
$contador = 1;
foreach ($ListadoTipoTickets as $tipoTicket) {
                        echo '<tr>';
                        echo '<td>' . $contador . '</td>';
                        echo '<td>' . $tipoTicket['IDTIPOTICKET'] . '</td>';
                        echo '<td>' . $tipoTicket['PRECIOTICKET'] . '</td>';
                        echo '<td>' . $tipoTicket['BEBIDA1'] . '</td>';
                        echo '<td>' . $tipoTicket['BEBIDA2'] . '</td>';
                        echo '<td>' . $tipoTicket['TIPOTICKET'] . '</td>';
                        echo '<td><input type="checkbox" name="seleccionar[]" value="' . $tipoTicket['IDTIPOTICKET'] . '"></td>';
                        echo '</tr>';
                        $contador++;

    }
?>

