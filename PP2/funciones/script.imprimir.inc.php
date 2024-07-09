<script>
    function imprimirTabla() {
        // Obtener el contenido HTML de la tabla
        var contenidoTabla = document.querySelector('.table').outerHTML;
        // Abrir una nueva ventana para imprimir el contenido
        var ventanaImpresion = window.open('', '_blank', 'width=800,height=600');
        // Escribir el contenido de la tabla en la nueva ventana
        ventanaImpresion.document.write('<html><head><title>Datos</title></head><body>');
        ventanaImpresion.document.write(contenidoTabla);
        ventanaImpresion.document.write('</body></html>');
        // Cerrar la nueva ventana después de imprimir
        ventanaImpresion.onload = function() {
            ventanaImpresion.print();
            ventanaImpresion.close();
        };
    }

    function imprimirFormulario() {
        // Obtener el contenido HTML del formulario
        var contenidoFormulario = document.querySelector('form').outerHTML;
        // Abrir una nueva ventana para imprimir el contenido
        var ventanaImpresionFormulario = window.open('', '_blank', 'width=800,height=600');
        // Escribir el contenido del formulario en la nueva ventana
        ventanaImpresionFormulario.document.write('<html><head><title>Formulario</title></head><body>');
        ventanaImpresionFormulario.document.write(contenidoFormulario);
        ventanaImpresionFormulario.document.write('</body></html>');
        // Cerrar la nueva ventana después de imprimir
        ventanaImpresionFormulario.onload = function() {
            ventanaImpresionFormulario.print();
            ventanaImpresionFormulario.close();
        };
    }


</script>