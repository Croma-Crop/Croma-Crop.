

if (!usuarioActivo || !usuarioActivo.nombre) {
    window.location.replace("js/index.php");
} else {
    iniciarPagina();
}

function iniciarPagina() {
 

    const fichaForm = document.getElementById("fichaForm");
    const selectSalon = document.getElementById("salon");
    const selectProfesor = document.getElementById("profesor");
    const avisoEquipos = document.getElementById("avisoEquipos");
    const tablaEquipos = document.getElementById("tablaEquipos");
    const cuerpoTabla = document.getElementById("cuerpoTablaEquipos");

    const dialogIncidencia = document.getElementById("dialogIncidencia");
    const formIncidenciaEquipo = document.getElementById("formIncidenciaEquipo");
    const equipoSeleccionado = document.getElementById("equipoSeleccionado");
    const tipoIncidencia = document.getElementById("tipoIncidencia");
    const descripcionIncidencia = document.getElementById("descripcionIncidencia");
    const cancelarIncidenciaEquipo = document.getElementById("cancelarIncidenciaEquipo");

    let filaEnEdicion = null;

    function mostrarEquiposDe(salon) {
        cuerpoTabla.querySelectorAll("tr").forEach(function (fila) {
            fila.classList.add("oculto");
        });

        if (!salon) {
            tablaEquipos.classList.add("oculto");
            avisoEquipos.classList.remove("oculto");
            avisoEquipos.textContent = "Seleccioná un salón para ver sus equipos.";
            return;
        }

        const filas = cuerpoTabla.querySelectorAll("tr[data-salon='" + salon + "']");

        if (filas.length === 0) {
            tablaEquipos.classList.add("oculto");
            avisoEquipos.classList.remove("oculto");
            avisoEquipos.textContent = "Este salón no tiene equipos registrados.";
            return;
        }

        filas.forEach(function (fila) {
            fila.classList.remove("oculto");
        });

        avisoEquipos.classList.add("oculto");
        tablaEquipos.classList.remove("oculto");
    }

    function abrirDialogIncidencia(fila) {
        filaEnEdicion = fila;
        equipoSeleccionado.textContent = "Equipo: " + fila.dataset.nombre + " (Serie: " + fila.dataset.serie + ")";
        tipoIncidencia.value = "";
        descripcionIncidencia.value = "";
        dialogIncidencia.showModal();
    }

    function agregarIncidenciaAlFormulario(fila, tipo, descripcion) {
        quitarIncidenciaDelFormulario(fila);

        const serie = fila.dataset.serie;
        [
            ["incidencias[" + serie + "][numero_serie]", serie],
            ["incidencias[" + serie + "][tipo]", tipo],
            ["incidencias[" + serie + "][descripcion]", descripcion]
        ].forEach(function ([nombre, valor]) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = nombre;
            input.value = valor;
            input.classList.add("incidencia-oculta");
            fichaForm.appendChild(input);
        });
    }

    function quitarIncidenciaDelFormulario(fila) {
        const serie = fila.dataset.serie;
        fichaForm.querySelectorAll('input[name^="incidencias[' + serie + ']"]').forEach(function (input) {
            input.remove();
        });
    }

    selectSalon.addEventListener("change", function () {
        mostrarEquiposDe(selectSalon.value);
    });

    cuerpoTabla.addEventListener("change", function (e) {
        if (!e.target.classList.contains("check-equipo")) return;

        const fila = e.target.closest("tr");

        if (e.target.checked) {
            abrirDialogIncidencia(fila);
        } else {
            fila.classList.remove("fila-cargada");
            quitarIncidenciaDelFormulario(fila);
        }
    });

    formIncidenciaEquipo.addEventListener("submit", function (e) {
        e.preventDefault();

        if (!tipoIncidencia.value) {
            alert("Seleccione el tipo de incidencia.");
            return;
        }

        agregarIncidenciaAlFormulario(filaEnEdicion, tipoIncidencia.value, descripcionIncidencia.value);
        filaEnEdicion.classList.add("fila-cargada");
        dialogIncidencia.close();
        filaEnEdicion = null;
    });

    cancelarIncidenciaEquipo.addEventListener("click", function () {
        filaEnEdicion.querySelector(".check-equipo").checked = false;
        dialogIncidencia.close();
        filaEnEdicion = null;
    });

    fichaForm.addEventListener("submit", function (e) {
        if (!selectProfesor.value) {
            e.preventDefault();
            alert("Seleccione un profesor.");
            return;
        }
        if (!selectSalon.value) {
            e.preventDefault();
            alert("Seleccione un salón.");
            return;
        }
        if (!document.querySelector('input[name="turno"]:checked')) {
            e.preventDefault();
            alert("Seleccione un turno.");
            return;
        }
        
    });
};