const modulos = {
    inventario: { etiqueta: "Inventario", ruta: "/Croma/html/inventario.php" },
    salones: { etiqueta: "Salones", ruta: "/Croma/html/salones.php" },
    tickets: { etiqueta: "Tickets", ruta: "/Croma/html/tickets.php" },
    incidencias: { etiqueta: "Incidencias Creadas", ruta: "/Croma/html/incidenciascreadas.php" },
    ficha: { etiqueta: "Ficha", ruta: "/Croma/html/user/ficha.php" },
    administrador: { etiqueta: "Administrador", ruta: "/Croma/html/admin/administrador.php" }
};

const permisos = {
    admin: ["inicio-admin", "inventario", "salones", "tickets", "incidencias", "ficha", "administrador"],
    tecnico: ["inicio-admin", "inventario", "salones", "tickets", "incidencias"],
    solicitante: ["inicio-user", "tickets", "incidencias", "ficha"]
};

const acciones = {
    eliminarTickets: ["admin", "tecnico"],
    asignarPrioridad: ["tecnico"]
};

const inicioPorRol = {
    admin: "/Croma/html/admin/index_funcionarios.php",
    tecnico: "/Croma/html/admin/index_funcionarios.php",
    solicitante: "/Croma/html/user/index_user.php"
};

function tienePermiso(rol, modulo) {
    const permitidos = permisos[rol] || [];
    return permitidos.includes(modulo);
}

function puedeHacer(accion, rol) {
    const permitidos = acciones[accion] || [];
    return permitidos.includes(rol);
}
