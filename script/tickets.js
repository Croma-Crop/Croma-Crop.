const btnIncidencia = document.querySelector("#incidencia")
const btnSolicitud = document.querySelector("#regSolicitud")
const rectangulo = document.querySelector("#newsletter");
const contenedor  = document.querySelector(".contenedor");
const contenedorSol = document.querySelector(".contenedorSol")

contenedor.classList.add("mostrar");
contenedorSol.classList.add("mostrar");

btnIncidencia.addEventListener("click", function (e) {
    e.preventDefault();
    rectangulo.classList.add("mostrar");
    contenedor.classList.remove("mostrar");
})

btnSolicitud.addEventListener("click", function (e) {
    e.preventDefault();
    rectangulo.classList.add("mostrar");
    contenedorSol.classList.remove("mostrar");
})

   
const btnEnviar = document.querySelector("#enviarinc")

btnEnviar.addEventListener("click", function(e){
     e.preventDefault();
    const nombreprof = document.getElementById("nombreProf").value;
    const fechainicio = document.getElementById("fecha_inicio").value;
    const fechalimite = document.getElementById("fecha_limite").value;    
    const salon = document.getElementById("salon").value;
    const turno = document.querySelector('input[name="turno"]:checked')?.value;
    const tipo = document.getElementById("tipo").value;
    const tipoincidencia = document.getElementById("descripcioninc").value;

    alert("Nombre Profesor: " + nombreprof + "\nFecha Inicio: " + fechainicio + "\nFecha Limite: " + fechalimite + "\nSalon: " + salon + "\nTurno: " + turno + "\nTipo: " + tipo + "\nIncidencia: " + tipoincidencia);
    const form = document.querySelector("#incforms");
    form.reset();
})
const enviarSol = document.querySelector("#enviarSol")

enviarSol.addEventListener("click", function(e){
     e.preventDefault();

    const nombreprof = document.getElementById("nombreProfSol").value;
    const tipoSol = document.getElementById("tipoSol").value;
    const descripcionSol = document.getElementById("descripcionSol").value;

    const form = document.querySelector("#solforms");
    form.reset();
    alert("Nombre del profesor: " + nombreprof + "\nTipo de solicitud: " + tipoSol + "\nDescripcion de Solicitud: ");
})

const btnVolverInc = document.querySelector("#volverInc");
const btnVolverSol = document.querySelector("#volverSol");

btnVolverInc.addEventListener("click", function (e) {
    e.preventDefault();
    contenedor.classList.add("mostrar");
    rectangulo.classList.remove("mostrar");
})

btnVolverSol.addEventListener("click", function (e) {
    e.preventDefault();
    contenedorSol.classList.add("mostrar");
    rectangulo.classList.remove("mostrar");
})
