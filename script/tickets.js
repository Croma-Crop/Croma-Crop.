const btnIncidencia = document.querySelector("#incidencia")
const btnSolicitud = document.querySelector("#regSolicitud")
const rectangulo = document.querySelector("#newsletter");
const contenedor  = document.querySelector("#contenedor");
btnIncidencia.addEventListener("click", function (e) {
    e.preventDefault();
    rectangulo.classList.add("mostrar");
       

})

