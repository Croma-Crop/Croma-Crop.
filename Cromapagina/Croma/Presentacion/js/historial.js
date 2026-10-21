const selectorMes = document.querySelector("#mes");
const filas = document.querySelectorAll(".tabla-datos tbody tr");

function mostrarMes() {
    filas.forEach(function (fila) {
        if (fila.dataset.mes === selectorMes.value) {
            fila.classList.remove("oculto");
        } else {
            fila.classList.add("oculto");
        }
    });
}

if (selectorMes !== null) {
    selectorMes.addEventListener("change", mostrarMes);
    mostrarMes();
}
