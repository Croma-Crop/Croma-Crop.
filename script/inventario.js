let inventario = [
    { nombre: "Computadora", marca: "Lenovo", serie: 134934344, especif: "V45" },
    { nombre: "Laptop", marca: "Mac", serie: 1338344, especif: "W23" },
    { nombre: "Monitor", marca: "Acer", serie: 46743, especif: "W34" },
];

const formulario = document.querySelector("#formulario-producto");
const inptNombre = document.querySelector("#nombre");
const inptMarca = document.querySelector("#marca");
const inptSerie = document.querySelector("#numSerie");
const inptEspecif = document.querySelector("#especif");
const tituloFormulario = document.querySelector("#seccion-formulario h3");

let indiceModificando = null;

formulario.addEventListener("submit", function (e) {
    e.preventDefault();
    const nombre = inptNombre.value;
    const marca = inptMarca.value;
    const serie = Number(inptSerie.value);
    const especif = inptEspecif.value;

    const producto = { nombre, marca, serie, especif };

    if (indiceModificando !== null) {
        inventario[indiceModificando] = producto;
        indiceModificando = null;
        tituloFormulario.textContent = "Ingresar Nuevo Artículo";
    } else {
        inventario.push(producto);
    }

    renderizarInventario();
    formulario.reset();
});

function renderizarInventario() {
    let contenedor = document.getElementById("listado");
    let htmlGenerado = "";

    inventario.forEach(function (articulo, i) {
        htmlGenerado += "<li class='tarjeta-producto' data-indice='" + i + "'>";
        htmlGenerado += "<p class='tarjeta-nombre'>" + articulo.nombre + "</p>";
        htmlGenerado += "<p class='tarjeta-marca'>Marca: " + articulo.marca + "</p>";
        htmlGenerado += "<p class='tarjeta-serie'>Serie: " + articulo.serie + "</p>";
        htmlGenerado += "<p class='tarjeta-especif'>Especificaciones: " + articulo.especif + "</p>";
        htmlGenerado += "<button class='boton-modificar' data-indice='" + i + "'>Modificar</button>";
        htmlGenerado += "</li>";
    });
    contenedor.innerHTML = htmlGenerado;

    document.querySelectorAll(".boton-modificar").forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            e.stopPropagation();
            const i = Number(boton.dataset.indice);
            const articulo = inventario[i];
            inptNombre.value = articulo.nombre;
            inptMarca.value = articulo.marca;
            inptSerie.value = articulo.serie;
            inptEspecif.value = articulo.especif;
            indiceModificando = i;
            tituloFormulario.textContent = "Modificar Artículo";
        });
    });

}

renderizarInventario();
