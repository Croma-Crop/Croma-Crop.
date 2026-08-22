const dialogHistorial = document.querySelector("#dialogHistorial");
const cerrarHistorial = document.querySelector("#cerrarHistorial");

if (cerrarHistorial && dialogHistorial) {
    cerrarHistorial.addEventListener("click", function () {
        dialogHistorial.close();
    });
}

function buscarDialogo(boton) {
    return document.querySelector("#dialogo-equipo-" + boton.dataset.indice);
}

function mostrarDetalle(dialogo) {
    dialogo.querySelector(".dialogo-detalle").style.display = "block";
    dialogo.querySelector(".dialogo-edicion").style.display = "none";
}

function mostrarEdicion(dialogo) {
    dialogo.querySelector(".dialogo-detalle").style.display = "none";
    dialogo.querySelector(".dialogo-edicion").style.display = "flex";
}

document.querySelectorAll(".boton-desplegar").forEach(function (boton) {
    boton.addEventListener("click", function () {
        const dialogo = buscarDialogo(boton);
        mostrarDetalle(dialogo);
        dialogo.showModal();
    });
});

document.querySelectorAll(".boton-abrir-edicion").forEach(function (boton) {
    boton.addEventListener("click", function () {
        mostrarEdicion(buscarDialogo(boton));
    });
});

document.querySelectorAll(".boton-cancelar-edicion").forEach(function (boton) {
    boton.addEventListener("click", function () {
        mostrarDetalle(buscarDialogo(boton));
    });
});

document.querySelectorAll(".boton-cerrar-equipo").forEach(function (boton) {
    boton.addEventListener("click", function () {
        buscarDialogo(boton).close();
    });
});
