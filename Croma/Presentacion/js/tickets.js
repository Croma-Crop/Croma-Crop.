document.querySelector("#incidencia").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector("#newsletter").classList.toggle("mostrar");
    document.querySelector(".contenedor").classList.toggle("mostrar");
});

document.querySelector("#regSolicitud").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector("#newsletter").classList.toggle("mostrar");
    document.querySelector(".contenedorSol").classList.toggle("mostrar");
});

document.querySelector("#volverInc").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector(".contenedor").classList.add("mostrar");
    document.querySelector("#newsletter").classList.remove("mostrar");
});

document.querySelector("#volverSol").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector(".contenedorSol").classList.add("mostrar");
    document.querySelector("#newsletter").classList.remove("mostrar");
});
const tipoSol = document.querySelector("#tipoSol");
const camposSoftware = document.querySelector("#camposSoftware");
const camposReserva = document.querySelector("#camposReserva");
const nombreSoftware = document.querySelector("#nombreSoftware");
const fechaSol = document.querySelector("#fechaSol");
const horaInicioSol = document.querySelector("#horaInicioSol");
const horaFinSol = document.querySelector("#horaFinSol");

function mostrarCamposDeSolicitud() {
    const esSoftware = tipoSol.value === "Instalacion de Software";
    const esReserva = tipoSol.value === "Reserva de Salon";

    camposSoftware.classList.toggle("oculto", !esSoftware);
    camposReserva.classList.toggle("oculto", !esReserva);

    nombreSoftware.required = esSoftware;
    fechaSol.required = esReserva;
    horaInicioSol.required = esReserva;
    horaFinSol.required = esReserva;

    if (!esSoftware) {
        nombreSoftware.value = "";
    }

    if (!esReserva) {
        fechaSol.value = "";
        horaInicioSol.value = "";
        horaFinSol.value = "";
    }
}

tipoSol.addEventListener("change", mostrarCamposDeSolicitud);
mostrarCamposDeSolicitud();

document.querySelector("#solforms").addEventListener("submit", function (e) {
    if (tipoSol.value === "Reserva de Salon" && horaFinSol.value <= horaInicioSol.value) {
        e.preventDefault();
        alert("La hora de finalización tiene que ser posterior a la de inicio.");
    }
});
