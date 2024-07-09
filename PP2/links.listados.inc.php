<?php 
                                if ($_SESSION['Usuario_Nivel'] == 'Administrador' || $_SESSION['Usuario_Nivel'] == 'Secretaria') {
                                    echo "Todas las Prestaciones cargadas";
                                }
                                if ($_SESSION['Usuario_Nivel'] == 'Paciente') {
                                    echo "Mis turnos asignados";
                                }
                                if ($_SESSION['Usuario_Nivel'] == 'Medico') {
                                    echo "Mis prestaciones cargadas";
                                }?>