function googleTranslateElementInit() {
    new google.translate.TranslateElement({
        pageLanguage: 'es',
        includedLanguages: 'en,es',
        autoDisplay: false
    }, 'google_translate_element');
}

function idiomaActual() {
    var partes = document.cookie.split(";");
    var i = 0;
    while (i < partes.length) {
        var cookie = partes[i];
        while (cookie.charAt(0) === " ") {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf("googtrans=") === 0 && cookie.indexOf("/en") !== -1) {
            return "en";
        }
        i = i + 1;
    }
    return "es";
}

function guardarIdioma(idioma) {
    if (idioma === "en") {
        document.cookie = "googtrans=/es/en;path=/";
    } else {
        document.cookie = "googtrans=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}

function cambiarIdioma() {
    if (idiomaActual() === "en") {
        guardarIdioma("es");
    } else {
        guardarIdioma("en");
    }
    window.location.reload();
}

document.addEventListener("DOMContentLoaded", function () {
    var boton = document.getElementById("btn-idioma");
    if (boton === null) {
        return;
    }
    if (idiomaActual() === "en") {
        boton.textContent = "ES";
        boton.setAttribute("aria-label", "Ver la pagina en espanol");
    } else {
        boton.textContent = "EN";
        boton.setAttribute("aria-label", "Ver la pagina en ingles");
    }
    boton.addEventListener("click", cambiarIdioma);
});
