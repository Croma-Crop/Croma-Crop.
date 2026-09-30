const dialogRechazo = document.querySelector("#dialogRechazo");
const idRechazo = document.querySelector("#idRechazo");
const nombreRechazado = document.querySelector("#nombreRechazado");
const motivoRechazo = document.querySelector("#motivo_rechazo");
const cancelarRechazo = document.querySelector("#cancelarRechazo");
const formRechazo = idRechazo.closest("form");
const actionRechazo = formRechazo.getAttribute("action");

document.querySelectorAll(".boton-rechazar").forEach(function (boton) {
    boton.addEventListener("click", function () {
        idRechazo.value = boton.dataset.id;
        nombreRechazado.textContent = "Solicitud de " + boton.dataset.nombre;
        motivoRechazo.value = "";

        if (boton.dataset.tipo === "extranjero") {
            formRechazo.action = actionRechazo + "?tipo=extranjero";
        } else {
            formRechazo.action = actionRechazo;
        }

        dialogRechazo.showModal();
    });
});

if (cancelarRechazo) {
    cancelarRechazo.addEventListener("click", function () {
        dialogRechazo.close();
    });
}