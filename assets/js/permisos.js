const modulos = {
    inventario: { etiqueta: "Inventario", ruta: "/pages/inventario.html" },
    salones: { etiqueta: "Salones", ruta: "/pages/salones.html" },
    tickets: { etiqueta: "Tickets", ruta: "/pages/tickets.html" },
    incidencias: { etiqueta: "Incidencias Creadas", ruta: "/pages/incidencias.html" },
    kanban: { etiqueta: "Tablero Kanban", ruta: "/pages/tecnico/kanban.html" },
    ficha: { etiqueta: "Ficha", ruta: "/pages/usuario/ficha.html" },
    administrador: { etiqueta: "Administrador", ruta: "/pages/admin/administrador.html" }
};

const permisos = {
    admin: ["inicio-admin", "inventario", "salones", "tickets", "incidencias", "ficha", "administrador"],
    tecnico: ["inicio-tecnico", "inventario", "tickets", "incidencias", "kanban"],
    solicitante: ["inicio-usuario", "tickets", "incidencias", "ficha"]
};

const acciones = {
    eliminarTickets: ["admin", "tecnico"],
    asignarGravedad: ["tecnico"]
};

const inicioPorRol = {
    admin: "/pages/admin/index_admin.html",
    tecnico: "/pages/tecnico/index_tecnico.html",
    solicitante: "/pages/usuario/index_usuario.html"
};

function tienePermiso(rol, modulo) {
    const permitidos = permisos[rol] || [];
    return permitidos.includes(modulo);
}

function puedeHacer(accion, rol) {
    const permitidos = acciones[accion] || [];
    return permitidos.includes(rol);
}
