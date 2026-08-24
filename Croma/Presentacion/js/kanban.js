document.addEventListener("DOMContentLoaded", function () {
    const cuadroDeBusqueda = document.querySelector("#inptbusqueda");
    const botonesFiltro = document.querySelectorAll(".filtro-clase");
    const columnas = document.querySelectorAll(".columna-kanban");
    const formAccion = document.querySelector("#formAccionKanban");
    const inputId = document.querySelector("#accionId");
    const inputClase = document.querySelector("#accionClase");
    const inputCampo = document.querySelector("#accionCampo");
    const inputValor = document.querySelector("#accionValor");

    let claseActiva = "Todos";
    let tarjetaArrastrada = null;

    function enviarAccion(id, clase, campo, valor) {
        inputId.value = id;
        inputClase.value = clase;
        inputCampo.value = campo;
        inputValor.value = valor;
        formAccion.submit();
    }

    function normalizar(texto) {
        return (texto || "").toString().toLowerCase();
    }

    function aplicarFiltros() {
        const busqueda = normalizar(cuadroDeBusqueda.value.trim());

        document.querySelectorAll(".tarjeta-kanban").forEach(function (tarjeta) {
            const coincideClase = claseActiva === "Todos" || tarjeta.dataset.clase === claseActiva;
            const coincideBusqueda = busqueda === "" || normalizar(tarjeta.textContent).includes(busqueda);
            tarjeta.style.display = (coincideClase && coincideBusqueda) ? "" : "none";
        });
    }

    botonesFiltro.forEach(function (boton) {
        boton.addEventListener("click", function () {
            botonesFiltro.forEach(function (b) {
                b.classList.remove("activo");
            });
            boton.classList.add("activo");
            claseActiva = boton.dataset.clase;
            aplicarFiltros();
        });
    });

    cuadroDeBusqueda.addEventListener("keyup", aplicarFiltros);

    document.querySelectorAll(".boton-detalle").forEach(function (boton) {
        boton.addEventListener("click", function () {
            const detalle = boton.nextElementSibling;
            detalle.classList.toggle("mostrar");
            boton.textContent = detalle.classList.contains("mostrar") ? "Ver menos" : "Ver más";
        });
    });

    document.querySelectorAll(".boton-tomar").forEach(function (boton) {
        boton.addEventListener("click", function () {
            const tarjeta = boton.closest(".tarjeta-kanban");
            enviarAccion(tarjeta.dataset.id, tarjeta.dataset.clase, "asignado", tarjeta.dataset.miDocumento);
        });
    });

    document.querySelectorAll(".select-tecnico").forEach(function (select) {
        select.addEventListener("change", function () {
            const tarjeta = select.closest(".tarjeta-kanban");
            enviarAccion(tarjeta.dataset.id, tarjeta.dataset.clase, "asignado", select.value);
        });
    });

    const clasesGravedad = {
    "Sin asignar": "gravedad-sin-clasificar",
    "Baja": "gravedad-leve",
    "Media": "gravedad-moderada",
    "Alta": "gravedad-grave"
};

document.querySelectorAll(".select-gravedad").forEach(function (select) {
    select.addEventListener("change", function () {
        const tarjeta = select.closest(".tarjeta-kanban");
        const etiqueta = tarjeta.querySelector(".etiqueta-gravedad");
        etiqueta.textContent = select.value;
        etiqueta.className = "etiqueta-gravedad " + (clasesGravedad[select.value] || "gravedad-sin-clasificar");
        enviarAccion(tarjeta.dataset.id, tarjeta.dataset.clase, "prioridad", select.value);
    });
});

    document.querySelectorAll(".select-estado").forEach(function (select) {
        select.addEventListener("change", function () {
            const tarjeta = select.closest(".tarjeta-kanban");
            enviarAccion(tarjeta.dataset.id, tarjeta.dataset.clase, "estado", select.value);
        });
    });

    document.querySelectorAll(".tarjeta-kanban").forEach(function (tarjeta) {
        tarjeta.addEventListener("dragstart", function () {
            tarjetaArrastrada = tarjeta;
            tarjeta.classList.add("arrastrando");
        });
        tarjeta.addEventListener("dragend", function () {
            tarjeta.classList.remove("arrastrando");
        });
    });

    columnas.forEach(function (columna) {
        columna.addEventListener("dragover", function (e) {
            e.preventDefault();
            columna.classList.add("columna-activa");
        });
        columna.addEventListener("dragleave", function () {
            columna.classList.remove("columna-activa");
        });
        columna.addEventListener("drop", function (e) {
            e.preventDefault();
            columna.classList.remove("columna-activa");
            if (tarjetaArrastrada) {
                enviarAccion(tarjetaArrastrada.dataset.id, tarjetaArrastrada.dataset.clase, "estado", columna.dataset.estado);
            }
        });
    });

    aplicarFiltros();
});