const incidenciasRegistradas = JSON.parse(localStorage.getItem("incidencias")) || [];
const solicitudesRegistradas = JSON.parse(localStorage.getItem("solicitudes")) || [];

let nombreCompleto = "";
if (usuario) {
    nombreCompleto = usuario.nombre + " " + usuario.apellido;
}

let sinClasificar = 0;
let pendientes = 0;
let enProceso = 0;
let asignados = 0;

incidenciasRegistradas.forEach(function (incidencia) {
    const gravedad = incidencia.gravedad || "Sin clasificar";
    if (gravedad === "Sin clasificar") {
        sinClasificar++;
    }
});

const ticketsRegistrados = incidenciasRegistradas.concat(solicitudesRegistradas);

ticketsRegistrados.forEach(function (ticket) {
    const estado = ticket.estado || "Pendiente";

    if (estado === "Pendiente") {
        pendientes++;
    }
    if (estado === "En proceso") {
        enProceso++;
    }
    if (ticket.asignado === nombreCompleto) {
        asignados++;
    }
});

document.getElementById("numero-sin-clasificar").textContent = sinClasificar;
document.getElementById("numero-pendientes").textContent = pendientes;
document.getElementById("numero-en-proceso").textContent = enProceso;
document.getElementById("numero-asignados").textContent = asignados;
