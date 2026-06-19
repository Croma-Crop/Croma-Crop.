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
    tecnico: ["inicio-admin", "inventario", "salones", "tickets", "incidencias", "ficha"],
    solicitante: ["inicio-user", "tickets", "ficha"]
};

const inicioPorRol = {
    admin: "/html/admin/index_admin.html",
    tecnico: "/html/admin/index_admin.html",
    solicitante: "/html/user/index_user.html"
};

const etiquetasRol = {
    admin: "Admin",
    tecnico: "Técnico",
    solicitante: "Solicitante"
};

function tienePermiso(rol, modulo) {
    const permitidos = permisos[rol] || [];
    return permitidos.includes(modulo);
}
