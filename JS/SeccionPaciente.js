document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('#resultadoTabla tbody tr');

    tableRows.forEach(function(tableRow) {
        tableRow.addEventListener('click', function(event) {
            // Evita el comportamiento predeterminado del clic
            event.preventDefault();

            // Obtiene la URL de la fila
            const href = this.getAttribute('data-href');

            // Navega a la URL obtenida en la misma ventana
            window.location.href = href;
        });
    });
});
