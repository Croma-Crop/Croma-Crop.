var botonModulos = document.getElementById("btn-modulos");
var menuModulos = document.getElementById("menu-modulos");

botonModulos.addEventListener("click", function () {
    botonModulos.classList.toggle("abierto");
    menuModulos.classList.toggle("abierto");
});

document.addEventListener("click", function (evento) {
    if (evento.target !== botonModulos && !menuModulos.contains(evento.target)) {
        botonModulos.classList.remove("abierto");
        menuModulos.classList.remove("abierto");
    }
});
