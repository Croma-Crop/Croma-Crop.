const API_SALONES = "../../Procesos/api/apisalon.php";

function procesarRespuesta(resp) {
  return resp.json()
    .catch(function() {
      return { status: "error", message: "Respuesta inválida del servidor", data: null };
    })
    .then(function(cuerpo) {
      if (!resp.ok || cuerpo.status !== "success") {
        throw new Error(cuerpo.message || "Error inesperado");
      }
      return cuerpo.data;
    });
}

function apiCrear(datos) {
  return fetch(API_SALONES, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(datos)
  })
    .then(procesarRespuesta);
}

function apiModificar(id, datos) {
  return fetch(`${API_SALONES}?id=${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(datos)
  })
    .then(procesarRespuesta);
}

function apiBorrar(id) {
  return fetch(`${API_SALONES}?id=${id}`, {
    method: "DELETE"
  })
    .then(function(resp) {
      if (resp.status === 409) {
        throw new Error("El salón no se puede borrar porque hay dispositivos o solicitudes asociados a él");
      }
      return procesarRespuesta(resp);
    });
}