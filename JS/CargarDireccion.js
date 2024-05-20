
document.addEventListener('DOMContentLoaded', function() {
    var seleccionarEstado = document.getElementById('Estado');  
    var seleccionarMunicipio = document.getElementById('Municipio');
    var seleccionarParroquia = document.getElementById('Parroquia');
    var seleccionarCiudad = document.getElementById('Ciudad');
    var Direccion_Vivienda = document.getElementById('Direccion_Vivienda');
    
    
    // Función para cargar los estados
    function cargarEstados() {
        fetch('../Configuracion/CargarDireccion.php?accion=estados')
            .then(response => response.json())
            .then(dato => {
                dato.forEach(estado => {
                    seleccionarEstado.innerHTML += `<option value="${estado.id_estado}">${estado.estado}</option>`;
                });
            });
    }

     // Función para cargar los municipios
     function cargarMunicipios(idEstado) {
        fetch(`../Configuracion/CargarDireccion.php?accion=municipios&id=${idEstado}`)
            .then(response => response.json())
            .then(dato => {
                seleccionarMunicipio.innerHTML = '<option value="" disabled selected>Seleccione Municipio</option>';
                dato.forEach(municipio => {
                    seleccionarMunicipio.innerHTML += `<option value="${municipio.id_municipio}">${municipio.municipio}</option>`;
                });
            });
    }

    
    // Función para cargar las parroquias
    function cargarParroquias(idMunicipio) {
        fetch(`../Configuracion/CargarDireccion.php?accion=parroquias&id=${idMunicipio}`)
            .then(response => response.json())
            .then(dato => {
                seleccionarParroquia.innerHTML = '<option value="" disabled selected>Seleccione Parroquia</option>';
                dato.forEach(parroquia => {
                    seleccionarParroquia.innerHTML += `<option value="${parroquia.id_parroquia}">${parroquia.parroquia}</option>`;
                });
            });
    }

    // Función para cargar las ciudades
    function cargarCiudades(idEstado) {
        fetch(`../Configuracion/CargarDireccion.php?accion=ciudades&id=${idEstado}`)
            .then(response => response.json())
            .then(dato => {
                seleccionarCiudad.innerHTML = '<option value="" disabled selected>Seleccione Ciudad</option>';
                dato.forEach(ciudad => {
                    seleccionarCiudad.innerHTML += `<option value="${ciudad.id_ciudad}">${ciudad.ciudad}</option>`;
                });
            });
    }

    function guardarDireccion() {
        var direccion = Direccion_Vivienda.value; 
    
        fetch('../Configuracion/CargarDireccion.php', {
            method: 'POST',
            body: JSON.stringify({ direccion: direccion }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                console.log('Dirección guardada exitosamente.');
            } else {
                console.error('Error al guardar la dirección.');
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
    }

    // Actualizar las ciudades, municipios y parroquias
    seleccionarEstado.addEventListener('change', function() {
        cargarCiudades(this.value);
        cargarMunicipios(this.value);
    });

    seleccionarMunicipio.addEventListener('change', function() {
        cargarParroquias(this.value);
    });

    // Cargar estados al inicio
    cargarEstados();
});

