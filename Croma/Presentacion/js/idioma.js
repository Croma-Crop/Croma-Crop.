var traducciones = {};

function idiomaActual() {
    if (localStorage.getItem("idioma") === "en") {
        return "en";
    }
    return "es";
}

function cambiarIdioma() {
    if (idiomaActual() === "en") {
        localStorage.setItem("idioma", "es");
    } else {
        localStorage.setItem("idioma", "en");
    }
    window.location.reload();
}

function traducir(texto) {
    if (traducciones[texto] !== undefined) {
        return traducciones[texto];
    }
    return texto;
}

function traducirPagina() {
    var elementos = document.querySelectorAll("body *");
    var i = 0;
    while (i < elementos.length) {
        var elemento = elementos[i];
        if (elemento.children.length === 0) {
            var texto = elemento.textContent.trim();
            if (traducciones[texto] !== undefined) {
                elemento.textContent = traducciones[texto];
            }
        }
        if (elemento.placeholder) {
            elemento.placeholder = traducir(elemento.placeholder);
        }
        if (elemento.title) {
            elemento.title = traducir(elemento.title);
        }
        i = i + 1;
    }
    document.title = traducir(document.title);
}

function pedirTraducciones() {
    var ruta = window.location.pathname;
    var base = ruta.substring(0, ruta.indexOf("/Presentacion/"));

    fetch(base + "/Procesos/api/traducciones.php")
        .then(function (respuesta) {
            return respuesta.json();
        })
        .then(function (datos) {
            traducciones = datos;
            traducirPagina();
        });
}

document.addEventListener("DOMContentLoaded", function () {
    var boton = document.getElementById("btn-idioma");
    if (boton === null) {
        return;
    }
    if (idiomaActual() === "en") {
        boton.textContent = "ES";
        boton.setAttribute("aria-label", "Ver la página en español");
        pedirTraducciones();
    } else {
        boton.textContent = "EN";
        boton.setAttribute("aria-label", "Ver la página en inglés");
    }
    boton.addEventListener("click", cambiarIdioma);
});
