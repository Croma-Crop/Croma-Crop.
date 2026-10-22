document.addEventListener("DOMContentLoaded", function () {
const seccionFormulario = document.querySelector("#seccion-formulario");
const tituloFormulario  = document.querySelector("#seccion-formulario .titulo-seccion");
const form = document.querySelector("#formulario-salon");
const inNombre = document.querySelector("#nombreSalon");
const inTipo = document.querySelector("#tipo");
const inId = document.querySelector("#formulario-salon input[name='id_salon']");
const btnCancel = document.querySelector("#cancelarSalon");
const listado = document.querySelector("#listado");
const mensaje = document.querySelector("#mensaje");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const datos = { nombre: inNombre.value.trim(), tipo: inTipo.value };

    if (inId.value === "") {
      apiCrear(datos)
        .then(function (salon) {
          agregarTarjeta(salon);
          mostrarMensaje(traducir("Salón creado"), "exito");
          volverANuevoSalon();
        })
        .catch(function (err) {
          mostrarMensaje(err.message, "error");
        });
    } else {
      apiModificar(inId.value, datos)
        .then(function (salon) {
          actualizarTarjeta(salon);
          mostrarMensaje(traducir("Salón modificado"), "exito");
          volverANuevoSalon();
        })
        .catch(function (err) {
          mostrarMensaje(err.message, "error");
        });
    }
  });

  listado.addEventListener("click", function (e) {
    const btn = e.target;

    if (btn.classList.contains("boton-modificar")) {
      pasarAModificarSalon(btn.dataset.id, btn.dataset.nombre, btn.dataset.tipo);
    }

    if (btn.classList.contains("boton-eliminar")) {
      if (!confirm(traducir("¿Seguro que quieres eliminar el salón?"))) return;
      const id = btn.dataset.id;
      apiBorrar(id)
        .then(function () {
          quitarTarjeta(id);
          mostrarMensaje(traducir("Salón eliminado"), "exito");
        })
        .catch(function (err) {
          mostrarMensaje(err.message, "error");
        });
    }
  });

  btnCancel.addEventListener("click", volverANuevoSalon);

  function volverANuevoSalon() {
    tituloFormulario.textContent = traducir("Ingresar nuevo salón");
    inNombre.value = "";
    inTipo.value = "";
    inId.value = "";
    btnCancel.hidden = true;
  }

  function pasarAModificarSalon(id, nombre, tipo) {
    tituloFormulario.textContent = traducir("Modificar salón");
    inNombre.value = nombre;
    inTipo.value = tipo;
    inId.value = id;
    btnCancel.hidden = false;
    seccionFormulario.scrollIntoView({ behavior: "smooth", block: "center" });
    inNombre.focus();
    inNombre.select();
  }

  function agregarTarjeta(salon) {
    const li = document.createElement("li");
    li.className = "tarjeta-producto";
    li.dataset.id = salon.id_salon;
    li.innerHTML =
      '<p class="tarjeta-nombre"></p>' +
      '<div class="tarjeta-acciones">' +
        '<button type="button" class="boton-modificar">' + traducir("Modificar") + '</button>' +
        '<button type="button" class="boton-eliminar">' + traducir("Eliminar") + '</button>' +
      '</div>';
    li.querySelector(".tarjeta-nombre").textContent = salon.nombre;
    const bm = li.querySelector(".boton-modificar");
    bm.dataset.id = salon.id_salon;
    bm.dataset.nombre = salon.nombre;
    bm.dataset.tipo = salon.tipo;
    li.querySelector(".boton-eliminar").dataset.id = salon.id_salon;
    listado.appendChild(li);
  }

  function actualizarTarjeta(salon) {
    const li = listado.querySelector('li[data-id="' + salon.id_salon + '"]');
    if (!li) return;
    li.querySelector(".tarjeta-nombre").textContent = salon.nombre;
    const bm = li.querySelector(".boton-modificar");
    bm.dataset.nombre = salon.nombre;
    bm.dataset.tipo = salon.tipo;
  }

  function quitarTarjeta(id) {
    const li = listado.querySelector('li[data-id="' + id + '"]');
    if (li) li.remove();
  }

  function mostrarMensaje(texto, tipo) {
    mensaje.textContent = texto;
    mensaje.className = "mensaje mensaje-" + tipo;
    mensaje.hidden = false;
    setTimeout(function () {
      mensaje.hidden = true;
    }, 3000);
  }
});