const gravedades = ["Sin clasificar", "Leve", "Moderada", "Grave", "Crítica"];

const estados = ["Pendiente", "En proceso", "Resuelto"];

const clasesGravedad = {
    "Sin clasificar": "gravedad-sin-clasificar",
    "Leve": "gravedad-leve",
    "Moderada": "gravedad-moderada",
    "Grave": "gravedad-grave",
    "Crítica": "gravedad-critica"
};

const clasesEstado = {
    "Pendiente": "estado-pendiente",
    "En proceso": "estado-en-proceso",
    "Resuelto": "estado-resuelto"
};

function claseDeGravedad(gravedad) {
    return clasesGravedad[gravedad] || "gravedad-sin-clasificar";
}

function claseDeEstado(estado) {
    return clasesEstado[estado] || "estado-pendiente";
}

function construirOpciones(lista, valorActual) {
    let html = "";

    lista.forEach(function (opcion) {
        let seleccionada = "";
        if (opcion === valorActual) {
            seleccionada = " selected";
        }
        html += "<option value='" + opcion + "'" + seleccionada + ">" + opcion + "</option>";
    });

    return html;
}

function activarDetalles() {
    document.querySelectorAll(".boton-detalle").forEach(function (boton) {
        boton.addEventListener("click", function () {
            const detalle = boton.nextElementSibling;
            detalle.classList.toggle("mostrar");

            if (detalle.classList.contains("mostrar")) {
                boton.textContent = "Ver menos";
            } else {
                boton.textContent = "Ver más";
            }
        });
    });
}
