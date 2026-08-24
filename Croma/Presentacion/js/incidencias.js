document.addEventListener("DOMContentLoaded", function () {
    const input = document.querySelector("#inptbusqueda");
    const botonesFiltro = document.querySelectorAll(".filtro-clase");
    const listado = document.querySelector("#listado-tickets");
    const tarjetas = document.querySelectorAll("#listado-tickets .tarjeta-ticket");

    let claseActiva = "Todos";

    function normalizar(texto) {
        return (texto || "").toString().toLowerCase();
    }

    function mostrarMensajeVacio(mostrar) {
        let mensaje = document.querySelector("#sin-resultados-filtro");

        if (mostrar && !mensaje) {
            mensaje = document.createElement("li");
            mensaje.id = "sin-resultados-filtro";
            mensaje.className = "sin-resultados";
            mensaje.textContent = "No se encontraron tickets con ese criterio.";
            listado.appendChild(mensaje);
        }

        if (!mostrar && mensaje) {
            mensaje.remove();
        }
    }

    function aplicarFiltros() {
        const busqueda = normalizar(input ? input.value.trim() : "");
        let hayVisibles = false;

        tarjetas.forEach(function (tarjeta) {
            const clase = tarjeta.dataset.clase || "";
            const coincideClase = claseActiva === "Todos" || clase === claseActiva;
            const coincideBusqueda = busqueda === "" || normalizar(tarjeta.textContent).includes(busqueda);
            const visible = coincideClase && coincideBusqueda;

            tarjeta.style.display = visible ? "" : "none";

            if (visible) {
                hayVisibles = true;
            }
        });

        mostrarMensajeVacio(!hayVisibles);
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

    if (input) {
        input.addEventListener("input", aplicarFiltros);
    }
});
