
const usuarioActivo = JSON.parse(sessionStorage.getItem("usuarioActivo"));

if (!usuarioActivo) {
    window.location.replace("/html/global/login.html");
} else {
    iniciarPagina();
}

function iniciarPagina() {
    const nombreCompleto = usuarioActivo.nombre + " " + usuarioActivo.apellido;
    document.getElementById("nombreProf").value = nombreCompleto;

    const fichaForm = document.getElementById("fichaForm");
    const selectSalon = document.getElementById("salon");
    const avisoEquipos = document.getElementById("avisoEquipos");
    const tablaEquipos = document.getElementById("tablaEquipos");
    const cuerpoTabla = document.getElementById("cuerpoTablaEquipos");

    const dialogIncidencia = document.getElementById("dialogIncidencia");
    const formIncidenciaEquipo = document.getElementById("formIncidenciaEquipo");
    const equipoSeleccionado = document.getElementById("equipoSeleccionado");
    const tipoIncidencia = document.getElementById("tipoIncidencia");
    const descripcionIncidencia = document.getElementById("descripcionIncidencia");
    const cancelarIncidenciaEquipo = document.getElementById("cancelarIncidenciaEquipo");

    let incidenciasCargadas = [];
    let serieEnEdicion = null;

    const salones = JSON.parse(localStorage.getItem("salones")) || [];

    let opcionesSalon = "<option value=''>--- Seleccionar salón ---</option>";
    salones.forEach(function (salon) {
        opcionesSalon += "<option value='" + salon.nombre + "'>" + salon.nombre + "</option>";
    });
    selectSalon.innerHTML = opcionesSalon;

    function renderizarEquipos(salon) {
        incidenciasCargadas = [];

        if (!salon) {
            tablaEquipos.classList.add("oculto");
            avisoEquipos.classList.remove("oculto");
            avisoEquipos.textContent = "Seleccioná un salón para ver sus equipos.";
            cuerpoTabla.innerHTML = "";
            return;
        }

        const inventario = JSON.parse(localStorage.getItem("inventario")) || [];
        const equipos = inventario.filter(function (equipo) {
            return equipo.salon === salon;
        });

        if (equipos.length === 0) {
            tablaEquipos.classList.add("oculto");
            avisoEquipos.classList.remove("oculto");
            avisoEquipos.textContent = "Este salón no tiene equipos registrados.";
            cuerpoTabla.innerHTML = "";
            return;
        }

        avisoEquipos.classList.add("oculto");
        tablaEquipos.classList.remove("oculto");

        let html = "";
        equipos.forEach(function (equipo) {
            html += "<tr data-serie='" + equipo.serie + "'>";
            html += "<td><input type='checkbox' class='check-equipo' data-serie='" + equipo.serie + "'></td>";
            html += "<td>" + equipo.nombre + "</td>";
            html += "<td>" + equipo.serie + "</td>";
            html += "<td>" + equipo.estado + "</td>";
            html += "</tr>";
        });
        cuerpoTabla.innerHTML = html;

        document.querySelectorAll(".check-equipo").forEach(function (check) {
            check.addEventListener("change", function () {
                const serie = check.dataset.serie;
                const fila = cuerpoTabla.querySelector("tr[data-serie='" + serie + "']");
                if (check.checked) {
                    abrirDialogIncidencia(serie);
                } else {
                    incidenciasCargadas = incidenciasCargadas.filter(function (cargada) {
                        return cargada.serie !== serie;
                    });
                    fila.classList.remove("fila-cargada");
                }
            });
        });
    }

    function abrirDialogIncidencia(serie) {
        serieEnEdicion = serie;

        const inventario = JSON.parse(localStorage.getItem("inventario")) || [];
        let nombreEquipo = "";
        inventario.forEach(function (equipo) {
            if (equipo.serie === Number(serie)) {
                nombreEquipo = equipo.nombre;
            }
        });
        equipoSeleccionado.textContent = "Equipo: " + nombreEquipo + " (Serie: " + serie + ")";

        tipoIncidencia.value = "";
        descripcionIncidencia.value = "";

        dialogIncidencia.showModal();
    }

    selectSalon.addEventListener("change", function () {
        renderizarEquipos(selectSalon.value);
    });

    formIncidenciaEquipo.addEventListener("submit", function (e) {
        e.preventDefault();
        const tipo = tipoIncidencia.value;
        const descripcion = descripcionIncidencia.value;

        if (!tipo) {
            alert("Seleccione el tipo de incidencia.");
            return;
        }

        incidenciasCargadas.push({
            serie: serieEnEdicion,
            tipo: tipo,
            descripcion: descripcion
        });

        const fila = cuerpoTabla.querySelector("tr[data-serie='" + serieEnEdicion + "']");
        fila.classList.add("fila-cargada");

        dialogIncidencia.close();
        serieEnEdicion = null;
    });

    cancelarIncidenciaEquipo.addEventListener("click", function () {
        const check = cuerpoTabla.querySelector(".check-equipo[data-serie='" + serieEnEdicion + "']");
        check.checked = false;
        dialogIncidencia.close();
        serieEnEdicion = null;
    });

    function guardarFicha(ficha) {
        const fichas = JSON.parse(localStorage.getItem("fichas")) || [];
        fichas.push(ficha);
        localStorage.setItem("fichas", JSON.stringify(fichas));
    }

    fichaForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const fecha = document.getElementById("fecha_inicio").value;
        const horaEntrada = document.getElementById("hora_entrada").value;
        const horaSalida = document.getElementById("hora_salida").value;
        const salon = document.getElementById("salon").value;
        const turno = document.querySelector('input[name="turno"]:checked');

        if (!salon) {
            alert("Seleccione un salón.");
            return;
        }
        if (!turno) {
            alert("Seleccione un turno.");
            return;
        }

        guardarFicha({
            nombreProf: nombreCompleto,
            fecha: fecha,
            horaEntrada: horaEntrada,
            horaSalida: horaSalida,
            salon: salon,
            turno: turno.value,
            cantidadIncidencias: incidenciasCargadas.length
        });

        const incidencias = JSON.parse(localStorage.getItem("incidencias")) || [];
        const inventario = JSON.parse(localStorage.getItem("inventario")) || [];

        let fecha_historial = fecha;
        if (!fecha_historial) {
            fecha_historial = new Date().toLocaleDateString();
        }

        incidenciasCargadas.forEach(function (cargada) {
            incidencias.push({
                nombreProf: nombreCompleto,
                fechaInicio: fecha,
                salon: salon,
                serie: cargada.serie,
                turno: turno.value,
                horaEntrada: horaEntrada,
                horaSalida: horaSalida,
                tipo: cargada.tipo,
                descripcion: cargada.descripcion,
                prioridad: "Sin asignar"
            });

            inventario.forEach(function (equipo) {
                if (equipo.serie === Number(cargada.serie)) {
                    if (!equipo.historial) {
                        equipo.historial = [];
                    }
                    equipo.historial.push({
                        fecha: fecha_historial,
                        descripcion: cargada.descripcion,
                        tecnico: nombreCompleto,
                        solucion: ""
                    });
                }
            });
        });

        localStorage.setItem("incidencias", JSON.stringify(incidencias));
        localStorage.setItem("inventario", JSON.stringify(inventario));

        alert("Ficha registrada.\nProfesor: " + nombreCompleto + "\nSalón: " + salon + "\nTurno: " + turno.value + "\nIncidencias creadas: " + incidenciasCargadas.length);

        fichaForm.reset();
        document.getElementById("nombreProf").value = nombreCompleto;
        incidenciasCargadas = [];
        renderizarEquipos("");
    });
}
