const modulos = {
    inventario: { etiqueta: "Inventario", ruta: "/html/inventario.html" },
    salones: { etiqueta: "Salones", ruta: "/html/salones.html" },
    tickets: { etiqueta: "Tickets", ruta: "/html/tickets.html" },
    incidencias: { etiqueta: "Incidencias Creadas", ruta: "/html/incidenciascreadas.html" },
    ficha: { etiqueta: "Ficha", ruta: "/html/user/ficha.html" },
    administrador: { etiqueta: "Administrador", ruta: "/html/admin/administrador.html" }
};

const permisos = {
    admin: ["inicio-admin", "inventario", "salones", "tickets", "incidencias", "ficha", "administrador"],
    tecnico: ["inicio-admin", "inventario", "salones", "tickets", "incidencias"],
    solicitante: ["inicio-user", "tickets", "incidencias", "ficha"]
};

const acciones = {
    eliminarTickets: ["admin", "tecnico"]
};

const inicioPorRol = {
    admin: "/html/admin/index_admin.html",
    tecnico: "/html/admin/index_admin.html",
    solicitante: "/html/user/index_user.html"
};

function tienePermiso(rol, modulo) {
    const permitidos = permisos[rol] || [];
    return permitidos.includes(modulo);
}

function puedeHacer(accion, rol) {
    const permitidos = acciones[accion] || [];
    return permitidos.includes(rol);
}
