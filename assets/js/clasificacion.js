const gravedades = ["Sin clasificar", "Leve", "Moderada", "Grave", "Crítica"];

const estados = ["Pendiente", "En proceso", "Resuelto"];

const clasesGravedad = {
    "Sin clasificar": "gravedad-sin-clasificar",
    "Leve": "gravedad-leve",
    "Moderada": "gravedad-moderada",
    "Grave": "gravedad-grave",
    "Crítica": "gravedad-critica"
};

function claseDeGravedad(gravedad) {
    return clasesGravedad[gravedad] || "gravedad-sin-clasificar";
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
