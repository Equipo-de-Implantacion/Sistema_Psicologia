function establecerCookie(nombre, valor, dias) {
    var expira = "";
    if (dias) {
        var fecha = new Date();
        fecha.setTime(fecha.getTime() + (dias * 24 * 60 * 60 * 1000));
        expira = "; expires=" + fecha.toUTCString();
    }
    document.cookie = nombre + "=" + (valor || "") + expira + "; path=/";
}

function confirmarConToastr(mensaje, callbackSi, callbackNo) {
    toastr.info(mensaje + "<br /><br /><button type='button' id='siBtn' class='btn btn-primary'>Sí</button> <button type='button' id='noBtn' class='btn btn-secondary'>No</button>", "Confirmación", {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-center",
        onclick: null,
        timeOut: "0",
        extendedTimeOut: "0",
        allowHtml: true,
        onShown: function (toast) {
            $("#siBtn").click(function(){
                callbackSi();
                toastr.clear(toast);
            });
            $("#noBtn").click(function(){
                callbackNo();
                toastr.clear(toast);
            });
        }
    });
}

function verificarConsentimientoCookie() {
    if (!document.cookie.split('; ').some(s => s.startsWith('consentimientoCookie='))) {
        toastr.info("Este sitio web utiliza cookies para mejorar tu experiencia. <br /><br /><button type='button' id='aceptarCookies' class='btn btn-primary mi-boton'>Aceptar</button>", "Aviso de Cookies", {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            onclick: null,
            timeOut: "0",
            extendedTimeOut: "0",
            allowHtml: true,
            onShown: function (toast) {
                $("#aceptarCookies").click(function(){
                    establecerCookie('consentimientoCookie', 'true', 365);
                    toastr.clear(toast);
                });
            }
        });
    }
}

window.addEventListener('DOMContentLoaded', (event) => {
    verificarConsentimientoCookie();
});
