const seccionFormulario = document.querySelector("#seccion-formulario");
const tituloFormulario = document.querySelector("#seccion-formulario .titulo-seccion");
const inptNombreSalon = document.querySelector("#nombreSalon");
const selectTipoSalon = document.querySelector("#tipo");
const inputIdSalon = document.querySelector("#formulario-salon input[name='id_salon']");
const botonCancelarSalon = document.querySelector("#cancelarSalon");

function volverANuevoSalon() {
    tituloFormulario.textContent = "Ingresar Nuevo Salón";
    inptNombreSalon.value = "";
    selectTipoSalon.value = "";
    inputIdSalon.value = "";
    botonCancelarSalon.hidden = true;
}

function pasarAModificarSalon(id, nombre, tipo) {
    tituloFormulario.textContent = "Modificar Salón";
    inptNombreSalon.value = nombre;
    selectTipoSalon.value = tipo;
    inputIdSalon.value = id;
    botonCancelarSalon.hidden = false;
    seccionFormulario.scrollIntoView({ behavior: "smooth", block: "center" });
    inptNombreSalon.focus();
    inptNombreSalon.select();
}

document.querySelectorAll(".boton-modificar").forEach(function (boton) {
    boton.addEventListener("click", function () {
        pasarAModificarSalon(boton.dataset.id, boton.dataset.nombre, boton.dataset.tipo);
    });
});

botonCancelarSalon.addEventListener("click", volverANuevoSalon);
