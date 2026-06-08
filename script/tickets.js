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

    const fecha = document.getElementById("fecha").value;
    const salon = document.getElementById("salon").value;
    const turno = document.querySelector('input[name="turno"]:checked')?.value;
    const tipo = document.getElementById("tipo").value;
    const tipoincidencia = document.getElementById("descripcioninc").value;

    alert("Fecha: " + fecha + "\nSalon: " + salon + "\nTurno: " + turno + "\nTipo: " + tipo + "\nIncidencia: " + tipoincidencia);

})
const enviarSol = document.querySelector("#enviarSol")

enviarSol.addEventListener("click", function(e){
     e.preventDefault();

    const tipoSol = document.getElementById("tipoSol").value;
    const descripcionSol = document.getElementById("descripcionSol").value;

    alert("Tipo de solicitud: " + tipoSol + "\nDescripcion: " + descripcionSol);

})
