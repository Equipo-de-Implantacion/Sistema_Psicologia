function establecerCookie(nombre, valor, dias) {
    var expira = "";

    // Para comprobar si se pasaron días para establecer la fecha de expiración
    if (dias) {
        // Objeto Date para obtener la fecha y hora actuales
        var fecha = new Date();
        // Para sumar los días multiplicados por milisegundos en un día para obtener la nueva fecha de expiración
        fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
        expira = "; expires=" + fecha.toUTCString();
    }
    // Para establecer la cookie con el nombre, valor y fecha de expiración 
    document.cookie = nombre + "=" + (valor || "") + expira + "; path=/";
}

function verificarConsentimientoCookie() {
    if (!document.cookie.split('; ').some(s => s.startsWith('consentimientoCookie='))) {
        alert("Este sitio web utiliza cookies para mejorar tu experiencia. Haz clic en 'Aceptar' para dar tu consentimiento.");
        if (confirm("¿Estás de acuerdo?")) {
            establecerCookie('consentimientoCookie', 'true', 365);
        } else {
            // El mensaje se mostrará nuevamente cuando se recargue la página
        }
    }
}

window.addEventListener('DOMContentLoaded', (event) => {
    verificarConsentimientoCookie();
});
