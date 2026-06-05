const btnIncidencia = document.querySelector("#incidencia")
const btnSolicitud = document.querySelector("#regSolicitud")

const rectangulo = document.querySelector("#newsletter");

btnIncidencia.addEventListener("click", function (e) {
    e.preventDefault();
    rectangulo.classList.add("mostrar");
    const contenedor = document.querySelector("#newsletter")
})


