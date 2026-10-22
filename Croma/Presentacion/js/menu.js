const botonModulos = document.getElementById("btn-modulos");
const menuModulos = document.getElementById("menu-modulos");

botonModulos.addEventListener("click", function () {
    botonModulos.classList.toggle("abierto");
    menuModulos.classList.toggle("abierto");
});

const dialogConfirmar = document.getElementById("dialogConfirmar");
const mensajeConfirmar = document.getElementById("mensajeConfirmar");
const aceptarConfirmar = document.getElementById("aceptarConfirmar");
const cancelarConfirmar = document.getElementById("cancelarConfirmar");
let accionPendiente = null;

function confirmarAccion(mensaje, alAceptar) {
    mensajeConfirmar.textContent = traducir(mensaje);
    accionPendiente = alAceptar;
    dialogConfirmar.showModal();
}

document.querySelectorAll("[data-confirmar]").forEach(function (boton) {
    boton.addEventListener("click", function (evento) {
        evento.preventDefault();
        confirmarAccion(boton.dataset.confirmar, function () {
            boton.form.submit();
        });
    });
});

const enlaceCerrarSesion = document.querySelector("a[href*='logout']");

if (enlaceCerrarSesion) {
    enlaceCerrarSesion.addEventListener("click", function (evento) {
        evento.preventDefault();
        confirmarAccion("¿Seguro que quiere cerrar sesión?", function () {
            window.location.href = enlaceCerrarSesion.href;
        });
    });
}

aceptarConfirmar.addEventListener("click", function () {
    dialogConfirmar.close();
    accionPendiente();
});

cancelarConfirmar.addEventListener("click", function () {
    dialogConfirmar.close();
});

const dialogAviso = document.getElementById("dialogAviso");
const mensajeAviso = document.getElementById("mensajeAviso");

function mostrarAviso(mensaje) {
    mensajeAviso.textContent = traducir(mensaje);
    dialogAviso.showModal();
}

document.getElementById("cerrarAviso").addEventListener("click", function () {
    dialogAviso.close();
});

document.addEventListener("click", function (evento) {
    if (evento.target !== botonModulos && !menuModulos.contains(evento.target)) {
        botonModulos.classList.remove("abierto");
        menuModulos.classList.remove("abierto");
    }
});
