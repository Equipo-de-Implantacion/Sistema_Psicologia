document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('Contenido_Calendario');
  
  fetchEvents().then(function(events) {
    var calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'es',
      timeZone: 'local',
      firstDay: 1,
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev, next, today',
        center: 'title',
        right: 'dayGridMonth, timeGridWeek, listWeek'
      },
      events: events.map(event => ({
      ...event,
        allDay: true // Indicando que los eventos son de todo el día
      }))
    });
    calendar.render();
  });
});

function fetchEvents() {
  return fetch('../Configuracion/ObtenerCitas.php') // Asegúrate de que esta ruta sea correcta
   .then(response => response.json())
   .catch(error => console.error('Error:', error));
}