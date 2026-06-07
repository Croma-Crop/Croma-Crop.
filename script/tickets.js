const btnIncidencia = document.querySelector("#incidencia")
const btnSolicitud = document.querySelector("#regSolicitud")
const rectangulo = document.querySelector("#newsletter");
const contenedor  = document.querySelector(".contenedor");

contenedor.classList.add("mostrar");

btnIncidencia.addEventListener("click", function (e) {
    e.preventDefault();
    rectangulo.classList.add("mostrar");
    contenedor.classList.remove("mostrar");
})

   
const btnEnviar = document.querySelector("#enviarinc")

btnEnviar.addEventListener("click", function(e){
    e.preventDefault();
    alert("Incidencia creada")
})