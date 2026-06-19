const inventarioInicial = [
    { nombre: "Computadora", marca: "Lenovo", serie: 134934344, estado: "Roto", salon: "L3", historial: [] },
    { nombre: "Laptop", marca: "Mac", serie: 1338344, estado: "Nuevo", salon: "L3", historial: [] },
    { nombre: "Monitor", marca: "Acer", serie: 46743, estado: "Roto", salon: "L4", historial: [
        { fecha: "10/06/2026", descripcion: "Pantalla rota", tecnico: "Ejemplo", solucion: "Se reemplazo el panel" }
    ] },
    { nombre: "Proyector", marca: "HP", serie: 778812, estado: "Nuevo", salon: "Lab1", historial: [] }
];
let inventario = JSON.parse(localStorage.getItem("inventario")) || inventarioInicial;

inventario.forEach(function (articulo) {
    if (!articulo.historial) {
        articulo.historial = [];
    }
});

function guardarInventario() {
    localStorage.setItem("inventario", JSON.stringify(inventario));
}
if (!localStorage.getItem("inventario")) {
    guardarInventario();
}
const formulario = document.querySelector("#formulario-producto");
const inptNombre = document.querySelector("#nombre");
const inptMarca = document.querySelector("#marca");
const inptSerie = document.querySelector("#numSerie");
const inptEstado = document.querySelector("#estado");
const inptSalon = document.querySelector("#salonInventario");
const tituloFormulario = document.querySelector("#seccion-formulario h3");

function cargarSalonesEnSelect() {
    const salones = JSON.parse(localStorage.getItem("salones")) || [];
    let html = "<option value=''>--- Asignar a un salón ---</option>";
    salones.forEach(function (salon) {
        html += "<option value='" + salon.nombre + "'>" + salon.nombre + "</option>";
    });
    inptSalon.innerHTML = html;
}
cargarSalonesEnSelect();
const dialogHistorial = document.querySelector("#dialogHistorial");
const tituloHistorial = document.querySelector("#tituloHistorial");
const listaHistorial = document.querySelector("#listaHistorial");
const cerrarHistorial = document.querySelector("#cerrarHistorial");

let indiceModificando = null;
formulario.addEventListener("submit", function (e) {
    e.preventDefault();
    const nombre = inptNombre.value;
    const marca = inptMarca.value;
    const serie = Number(inptSerie.value);
    const estado = inptEstado.value;
    const salon = inptSalon.value;

    if (indiceModificando !== null) {

        const historial = inventario[indiceModificando].historial;
        inventario[indiceModificando] = { nombre, marca, serie, estado, salon, historial };
        indiceModificando = null;
        tituloFormulario.textContent = "Ingresar Nuevo Artículo";
    } else {
        inventario.push({ nombre, marca, serie, estado, salon, historial: [] });
    }

    guardarInventario();
    renderizarInventario(inventario);
    formulario.reset();
});

function renderizarInventario(lista) {
    let contenedor = document.getElementById("listado");
    let htmlGenerado = "";

    lista.forEach(function (articulo) {
        const indiceReal = inventario.indexOf(articulo);
        const cantidad = articulo.historial.length;
        htmlGenerado += "<li class='tarjeta-producto' data-indice='" + indiceReal + "'>";
        htmlGenerado += "<p class='tarjeta-nombre'>" + articulo.nombre + "</p>";
        htmlGenerado += "<p class='tarjeta-marca'>Marca: " + articulo.marca + "</p>";
        htmlGenerado += "<p class='tarjeta-serie'>Serie: " + articulo.serie + "</p>";
        htmlGenerado += "<p class='tarjeta-estado'>Estado: " + articulo.estado + "</p>";
        htmlGenerado += "<p class='tarjeta-salon'>Salón: " + (articulo.salon || "Sin asignar") + "</p>";
        htmlGenerado += "<p class='tarjeta-intervenciones'>Intervenciones: " + cantidad + "</p>";
        htmlGenerado += "<div class='tarjeta-acciones'>";
        htmlGenerado += "<button class='boton-historial' data-indice='" + indiceReal + "'>Ver historial</button>";
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
            const articulo = inventario[i];
            inptNombre.value = articulo.nombre;
            inptMarca.value = articulo.marca;
            inptSerie.value = articulo.serie;
            inptEstado.value = articulo.estado;
            inptSalon.value = articulo.salon || "";
            indiceModificando = i;
            tituloFormulario.textContent = "Modificar Artículo";
        });
    });
    document.querySelectorAll(".boton-eliminar").forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            e.stopPropagation();
            const i = Number(boton.dataset.indice);

            if (confirm("¿Seguro que quiere eliminar este articulo?")) {
                inventario.splice(i, 1);
                guardarInventario();
                renderizarInventario(inventario);
            }
        });
    });

    document.querySelectorAll(".boton-historial").forEach(function (boton) {
        boton.addEventListener("click", function (e) {
            e.stopPropagation();
            const i = Number(boton.dataset.indice);
            abrirHistorial(inventario[i]);
        });
    });
}
function abrirHistorial(articulo) {
    tituloHistorial.textContent = "Historial de " + articulo.nombre + " (Serie: " + articulo.serie + ")";
    const historial = articulo.historial;

    if (historial.length === 0) {
        listaHistorial.innerHTML = "<li>Este equipo todavía no tuvo intervenciones.</li>";
    } else {
        let html = "";
        historial.forEach(function (h) {
            let tecnico = "-";
            if (h.tecnico) {
                tecnico = h.tecnico;
            }
            let solucion = "Pendiente";
            if (h.solucion) {
                solucion = h.solucion;
            }
            html += "<li class='item-historial'>";
            html += "<p><strong>" + h.fecha + "</strong> — " + h.descripcion + "</p>";
            html += "<p>Solicitante: " + tecnico + "</p>";
            html += "<p>Solución: " + solucion + "</p>";
            html += "</li>";
        });
        listaHistorial.innerHTML = html;
    }

    dialogHistorial.showModal();
}

cerrarHistorial.addEventListener("click", function () {
    dialogHistorial.close();
});

renderizarInventario(inventario);

const cuadroDeBusqueda = document.querySelector("#inptbusqueda");

cuadroDeBusqueda.addEventListener("keyup", function (e) {
    let texto = cuadroDeBusqueda.value.toLowerCase();
    if (texto === '') {
        renderizarInventario(inventario);
        return;
    }
    let filtrados = inventario.filter(function (articulo) {
        return articulo.nombre.toLowerCase().includes(texto) ||
            articulo.marca.toLowerCase().includes(texto) ||
            articulo.serie.toString().includes(texto) ||
            articulo.estado.toLowerCase().includes(texto) ||
            (articulo.salon || "").toLowerCase().includes(texto);
    });
    renderizarInventario(filtrados);
});
