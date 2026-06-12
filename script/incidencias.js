const incidencias = JSON.parse(localStorage.getItem("incidencias")) || [];
const solicitudes = JSON.parse(localStorage.getItem("solicitudes")) || [];

let tickets = [];

incidencias.forEach(function (incidencia) {
    incidencia.clase = "Incidencia";
    tickets.push(incidencia);
});

solicitudes.forEach(function (solicitud) {
    solicitud.clase = "Solicitud";
    tickets.push(solicitud);
});

const contenedor = document.getElementById("listado-tickets");
const cuadroDeBusqueda = document.querySelector("#inptbusqueda");
const botonesFiltro = document.querySelectorAll(".filtro-clase");

let claseActiva = "Todos";

function renderizarTickets(lista) {
    let html = "";

    if (lista.length === 0) {
        contenedor.innerHTML = "<li class='sin-resultados'>No hay tickets registrados.</li>";
        return;
    }

    lista.forEach(function (ticket) {
        html += "<li class='tarjeta-ticket'>";
        html += "<p class='tarjeta-clase tarjeta-" + ticket.clase.toLowerCase() + "'>" + ticket.clase + "</p>";
        html += "<p class='tarjeta-nombre'>" + ticket.nombreProf + "</p>";
        html += "<p class='tarjeta-tipo'>Tipo: " + ticket.tipo + "</p>";

        if (ticket.clase === "Incidencia") {
            html += "<p>Fecha inicio: " + ticket.fechaInicio + "</p>";
            html += "<p>Fecha límite: " + ticket.fechaLimite + "</p>";
            html += "<p>Salón: " + ticket.salon + "</p>";
            html += "<p>Serie: " + ticket.serie + "</p>";
            html += "<p>Turno: " + ticket.turno + "</p>";
        }

        html += "<p class='tarjeta-descripcion'>" + ticket.descripcion + "</p>";
        html += "</li>";
    });

    contenedor.innerHTML = html;
}

function filtrarTickets() {
    let texto = cuadroDeBusqueda.value.toLowerCase();

    let filtrados = tickets.filter(function (ticket) {
        if (claseActiva !== "Todos" && ticket.clase !== claseActiva) {
            return false;
        }
        return ticket.nombreProf.toLowerCase().includes(texto) ||
            ticket.tipo.toLowerCase().includes(texto) ||
            ticket.descripcion.toLowerCase().includes(texto);
    });

    renderizarTickets(filtrados);
}

cuadroDeBusqueda.addEventListener("keyup", filtrarTickets);

botonesFiltro.forEach(function (boton) {
    boton.addEventListener("click", function () {
        claseActiva = boton.dataset.clase;

        botonesFiltro.forEach(function (b) {
            b.classList.remove("activo");
        });
        boton.classList.add("activo");

        filtrarTickets();
    });
});

renderizarTickets(tickets);
