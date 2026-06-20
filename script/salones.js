const salonesIniciales = [
    { nombre: "L3" },
    { nombre: "L4" },
    { nombre: "Lab1" }
];
let salones = JSON.parse(localStorage.getItem("salones")) || salonesIniciales;

function guardarSalones() {
    localStorage.setItem("salones", JSON.stringify(salones));
}
if (!localStorage.getItem("salones")) {
    guardarSalones();
}

const formulario = document.querySelector("#formulario-salon");
const inptNombre = document.querySelector("#nombreSalon");
const tituloFormulario = document.querySelector("#seccion-formulario h3");

let indiceModificando = null;

formulario.addEventListener("submit", function (e) {
    e.preventDefault();
    const nombre = inptNombre.value;

    let repetido = false;
    salones.forEach(function (salon, i) {
        if (salon.nombre.toLowerCase() === nombre.toLowerCase() && i !== indiceModificando) {
            repetido = true;
        }
    });
    if (repetido) {
        alert("Ya existe un salón con ese código.");
        return;
    }

    if (indiceModificando !== null) {
        salones[indiceModificando] = { nombre };
        indiceModificando = null;
        tituloFormulario.textContent = "Ingresar Nuevo Salón";
    } else {
        salones.push({ nombre });
    }

    guardarSalones();
    renderizarSalones(salones);
    formulario.reset();
});

function renderizarSalones(lista) {
    let contenedor = document.getElementById("listado");
    let htmlGenerado = "";

    lista.forEach(function (salon) {
        const indiceReal = salones.indexOf(salon);
        htmlGenerado += "<li class='tarjeta-producto' data-indice='" + indiceReal + "'>";
        htmlGenerado += "<p class='tarjeta-nombre'>" + salon.nombre + "</p>";
        htmlGenerado += "<div class='tarjeta-acciones'>";
        htmlGenerado += "<button class='boton-modificar' data-indice='" + indiceReal + "'>Modificar</button>";
        htmlGenerado += "<button class='boton-eliminar' data-indice='" + indiceReal + "'>Eliminar</button>";
        htmlGenerado += "</div>";
        htmlGenerado += "</li>";
    });
    contenedor.innerHTML = htmlGenerado;

    document.querySelectorAll(".boton-modificar").forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            e.stopPropagation();
            const i = Number(boton.dataset.indice);
            const salon = salones[i];
            inptNombre.value = salon.nombre;
            indiceModificando = i;
            tituloFormulario.textContent = "Modificar Salón";
        });
    });

    document.querySelectorAll(".boton-eliminar").forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            e.stopPropagation();
            const i = Number(boton.dataset.indice);

            if (confirm("¿Seguro que quiere eliminar este salón?")) {
                salones.splice(i, 1);
                guardarSalones();
                renderizarSalones(salones);
            }
        });
    });
}

renderizarSalones(salones);

const cuadroDeBusqueda = document.querySelector("#inptbusqueda");

cuadroDeBusqueda.addEventListener("keyup", function (e) {
    let texto = cuadroDeBusqueda.value.toLowerCase();
    if (texto === '') {
        renderizarSalones(salones);
        return;
    }
    let filtrados = salones.filter(function (salon) {
        return salon.nombre.toLowerCase().includes(texto);
    });
    renderizarSalones(filtrados);
});
