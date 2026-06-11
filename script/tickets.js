const btnIncidencia = document.querySelector("#incidencia")
const btnSolicitud = document.querySelector("#regSolicitud")
const rectangulo = document.querySelector("#newsletter");
const contenedor  = document.querySelector(".contenedor");
const contenedorSol = document.querySelector(".contenedorSol")

contenedor.classList.add("mostrar");
contenedorSol.classList.add("mostrar");

btnIncidencia.addEventListener("click", function (e) {
    e.preventDefault();
    rectangulo.classList.toggle("mostrar");
    contenedor.classList.toggle("mostrar");
})

btnSolicitud.addEventListener("click", function (e) {
    e.preventDefault();
    rectangulo.classList.toggle("mostrar");
    contenedorSol.classList.toggle("mostrar");
})

   
const btnEnviar = document.querySelector("#enviarinc")

function registrarIntervencion(serie, intervencion) {
    const inventario = JSON.parse(localStorage.getItem("inventario")) || [];
    const equipo = inventario.find(function (e) {
        return e && e.serie === Number(serie);
    });

    if (!equipo) return false;

    if (!equipo.historial) equipo.historial = [];
    equipo.historial.push(intervencion);
    localStorage.setItem("inventario", JSON.stringify(inventario));
    return true;
}

btnEnviar.addEventListener("click", function(e){
     e.preventDefault();
    const nombreprof = document.getElementById("nombreProf").value;
    const fechainicio = document.getElementById("fecha_inicio").value;
    const fechalimite = document.getElementById("fecha_limite").value;
    const salon = document.getElementById("salon").value;
    const serie = document.getElementById("serie").value;
    const turno = document.querySelector('input[name="turno"]:checked')?.value;
    const tipo = document.getElementById("tipo").value;
    const tipoincidencia = document.getElementById("descripcioninc").value;

    const registrado = registrarIntervencion(serie, {
        fecha: fechainicio || new Date().toLocaleDateString(),
        descripcion: tipoincidencia,
        tecnico: nombreprof,
        solucion: "" 
    });

    const avisoEquipo = registrado
        ? "\nIntervención registrada en el equipo con serie " + serie + "."
        : "\nNo se encontró un equipo con esa serie en el inventario.";

    alert("Nombre Profesor: " + nombreprof + "\nFecha Inicio: " + fechainicio + "\nFecha Limite: " + fechalimite + "\nSalon: " + salon + "\nSerie: " + serie + "\nTurno: " + turno + "\nTipo: " + tipo + "\nIncidencia: " + tipoincidencia + avisoEquipo);
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
