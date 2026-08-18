const formulario = document.querySelector("#formulario-salon");
const inptNombre = document.querySelector("#nombreSalon");
const tituloFormulario = document.querySelector("#seccion-formulario h3");
const cuadroDeBusqueda = document.querySelector("#inptbusqueda");

let indiceModificando = null;



function renderizarSalones(lista) {
    let contenedor = document.getElementById("listado");
    let htmlGenerado = "";

    lista.forEach(function (salon) {
        htmlGenerado += "<li class='tarjeta-producto' data-indice='" + salon.indice + "'>";
        htmlGenerado += "<p class='tarjeta-nombre'>" + salon.nombre + "</p>";
        htmlGenerado += "<div class='tarjeta-acciones'>";
        htmlGenerado += "<button class='boton-modificar' data-indice='" + salon.indice + "'>Modificar</button>";
        htmlGenerado += "<button class='boton-eliminar' data-indice='" + salon.indice + "'>Eliminar</button>";
        htmlGenerado += "</div>";
        htmlGenerado += "</li>";
    });

    contenedor.innerHTML = htmlGenerado;

    document.querySelectorAll(".boton-modificar").forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            e.stopPropagation();

            const i = Number(boton.dataset.indice);
            const salon = lista.find(function (salon) {
                return salon.indice === i;
            });

            inptNombre.value = salon.nombre;
            indiceModificando = i;
            tituloFormulario.textContent = "Modificar Salón";
        });
    });

    document.querySelectorAll(".boton-eliminar").forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            e.stopPropagation();

            if (confirm("¿Seguro que quiere eliminar este salón?")) {
                // El controlador debe encargarse de eliminarlo.
            }
        });
    });
}


cuadroDeBusqueda.addEventListener("keyup", function () {
    // El controlador debe encargarse de filtrar los salones.
});
