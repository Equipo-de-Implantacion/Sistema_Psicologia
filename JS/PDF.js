function printPage() {
var elementsToPrint = document.querySelectorAll('.btn_Imprimir,.btn_Guardar, .barra-lateral, .Nombre_Usuario');

for(var i = 0; i < elementsToPrint.length; i++) {
    elementsToPrint[i].style.display = 'none';
}

window.print();

setTimeout(function(){
    // Después de un breve tiempo (100 ms), muestra nuevamente los elementos
    for(var i = 0; i < elementsToPrint.length; i++) {
        elementsToPrint[i].style.display = '';
    }
}, 100);

}

