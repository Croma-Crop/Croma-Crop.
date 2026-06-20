
const usuarioActivo = JSON.parse(sessionStorage.getItem("usuarioActivo"));

if (!usuarioActivo) {
    window.location.replace("/html/global/login.html");
} else {
    iniciarPagina();
}

function iniciarPagina() {
    const btnIncidencia = document.querySelector("#incidencia");
    const btnSolicitud = document.querySelector("#regSolicitud");
    const rectangulo = document.querySelector("#newsletter");
    const contenedor = document.querySelector(".contenedor");
    const contenedorSol = document.querySelector(".contenedorSol");

    const nombreCompleto = usuarioActivo.nombre + " " + usuarioActivo.apellido;

    contenedor.classList.add("mostrar");
    contenedorSol.classList.add("mostrar");

    const selectSalon = document.getElementById("salon");
    const selectSerie = document.getElementById("serie");
    const selectSalonSol = document.getElementById("salonSol");

    const salones = JSON.parse(localStorage.getItem("salones")) || [];

    let opcionesSalon = "<option value=''>--- Seleccionar salón ---</option>";
    salones.forEach(function (salon) {
        opcionesSalon += "<option value='" + salon.nombre + "'>" + salon.nombre + "</option>";
    });
    selectSalon.innerHTML = opcionesSalon;
    selectSalonSol.innerHTML = opcionesSalon;

    function cargarEquiposDelSalon(salon) {
        if (!salon) {
            selectSerie.innerHTML = "<option value=''>--- Seleccione un salón primero ---</option>";
            return;
        }

        const inventario = JSON.parse(localStorage.getItem("inventario")) || [];
        const equipos = inventario.filter(function (equipo) {
            return equipo.salon === salon;
        });

        if (equipos.length === 0) {
            selectSerie.innerHTML = "<option value=''>No hay equipos en este salón</option>";
            return;
        }

        let html = "<option value=''>--- Seleccionar equipo ---</option>";
        equipos.forEach(function (equipo) {
            html += "<option value='" + equipo.serie + "'>" + equipo.nombre + " (Serie: " + equipo.serie + ")</option>";
        });
        selectSerie.innerHTML = html;
    }

    selectSalon.addEventListener("change", function () {
        cargarEquiposDelSalon(selectSalon.value);
    });

    btnIncidencia.addEventListener("click", function (e) {
        e.preventDefault();
        rectangulo.classList.toggle("mostrar");
        contenedor.classList.toggle("mostrar");
    });

    btnSolicitud.addEventListener("click", function (e) {
        e.preventDefault();
        rectangulo.classList.toggle("mostrar");
        contenedorSol.classList.toggle("mostrar");
    });

    function guardarIncidencia(incidencia) {
        const incidencias = JSON.parse(localStorage.getItem("incidencias")) || [];
        incidencias.push(incidencia);
        localStorage.setItem("incidencias", JSON.stringify(incidencias));
    }

    function guardarSolicitud(solicitud) {
        const solicitudes = JSON.parse(localStorage.getItem("solicitudes")) || [];
        solicitudes.push(solicitud);
        localStorage.setItem("solicitudes", JSON.stringify(solicitudes));
    }

    const btnEnviar = document.querySelector("#enviarinc");

    btnEnviar.addEventListener("click", function (e) {
        e.preventDefault();
        const fechainicio = document.getElementById("fecha_inicio").value;
        const salon = document.getElementById("salon").value;
        const serie = document.getElementById("serie").value;
        const turno = document.querySelector('input[name="turno"]:checked')?.value;
        const tipo = document.getElementById("tipo").value;
        const tipoincidencia = document.getElementById("descripcioninc").value;

        if (!salon) {
            alert("Seleccione un salón.");
            return;
        }
        if (!serie) {
            alert("Seleccione un equipo del salón.");
            return;
        }

        guardarIncidencia({
            nombreProf: nombreCompleto,
            fechaInicio: fechainicio,
            salon: salon,
            serie: serie,
            turno: turno,
            tipo: tipo,
            descripcion: tipoincidencia
        });

        let fecha = fechainicio;
        if (!fecha) {
            fecha = new Date().toLocaleDateString();
        }
         const inventario = JSON.parse(localStorage.getItem("inventario")) || [];
        let avisoEquipo = "\nNo se encontro un equipo con esa serie en el inventario";

        inventario.forEach(function (equipo) {
            if (equipo.serie === Number(serie)) {
                if (!equipo.historial) {
                    equipo.historial = [];
                }
                equipo.historial.push({
                    fecha: fecha,
                    descripcion: tipoincidencia,
                    tecnico: nombreCompleto,
                    solucion: ""
                });
                localStorage.setItem("inventario", JSON.stringify(inventario));
                avisoEquipo = "\nIncidencia registrada en el equipo con serie " + serie + ".";
            }
        });

        alert("Nombre Profesor: " + nombreCompleto + "\nFecha Inicio: " + fechainicio + "\nSalon: " + salon + "\nSerie: " + serie + "\nTurno: " + turno + "\nTipo: " + tipo + "\nIncidencia: " + tipoincidencia + avisoEquipo);
        const form = document.querySelector("#incforms");
        form.reset();
    });

    const enviarSol = document.querySelector("#enviarSol");

    enviarSol.addEventListener("click", function (e) {
        e.preventDefault();

        const tipoSol = document.getElementById("tipoSol").value;
        const salonSol = document.getElementById("salonSol").value;
        const descripcionSol = document.getElementById("descripcionSol").value;

        if (!salonSol) {
            alert("Seleccione un salón.");
            return;
        }

        guardarSolicitud({
            nombreProf: nombreCompleto,
            tipo: tipoSol,
            salon: salonSol,
            descripcion: descripcionSol
        });

        const form = document.querySelector("#solforms");
        form.reset();
        alert("Nombre del profesor: " + nombreCompleto + "\nTipo de solicitud: " + tipoSol + "\nSalón: " + salonSol + "\nDescripcion de Solicitud: " + descripcionSol);
    });

    const btnVolverInc = document.querySelector("#volverInc");
    const btnVolverSol = document.querySelector("#volverSol");

    btnVolverInc.addEventListener("click", function (e) {
        e.preventDefault();
        contenedor.classList.add("mostrar");
        rectangulo.classList.remove("mostrar");
    });

    btnVolverSol.addEventListener("click", function (e) {
        e.preventDefault();
        contenedorSol.classList.add("mostrar");
        rectangulo.classList.remove("mostrar");
    });
}
