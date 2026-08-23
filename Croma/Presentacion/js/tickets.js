document.querySelector("#incidencia").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector("#newsletter").classList.toggle("mostrar");
    document.querySelector(".contenedor").classList.toggle("mostrar");
});

document.querySelector("#regSolicitud").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector("#newsletter").classList.toggle("mostrar");
    document.querySelector(".contenedorSol").classList.toggle("mostrar");
});

document.querySelector("#volverInc").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector(".contenedor").classList.add("mostrar");
    document.querySelector("#newsletter").classList.remove("mostrar");
});

document.querySelector("#volverSol").addEventListener("click", function (e) {
    e.preventDefault();
    document.querySelector(".contenedorSol").classList.add("mostrar");
    document.querySelector("#newsletter").classList.remove("mostrar");
});