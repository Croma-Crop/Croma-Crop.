const dialogRechazo = document.querySelector("#dialogRechazo");
const idRechazo = document.querySelector("#idRechazo");
const nombreRechazado = document.querySelector("#nombreRechazado");
const motivoRechazo = document.querySelector("#motivo_rechazo");
const cancelarRechazo = document.querySelector("#cancelarRechazo");

document.querySelectorAll(".boton-rechazar").forEach(function (boton) {
    boton.addEventListener("click", function () {
        idRechazo.value = boton.dataset.id;
        nombreRechazado.textContent = "Solicitud de " + boton.dataset.nombre;
        motivoRechazo.value = "";
        dialogRechazo.showModal();
    });
});

if (cancelarRechazo) {
    cancelarRechazo.addEventListener("click", function () {
        dialogRechazo.close();
    });
}
