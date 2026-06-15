const usuario = JSON.parse(sessionStorage.getItem("usuarioActivo"));

if (usuario) {
    const header = document.querySelector("header");

    let rol = usuario.rol;
    if (usuario.rol === "admin") {
        rol = "Admin";
    }
    if (usuario.rol === "tecnico") {
        rol = "Técnico";
    }
    if (usuario.rol === "solicitante") {
        rol = "Solicitante";
    }

    let destinoInicio = "/html/admin/index_admin.html";
    if (usuario.rol === "solicitante") {
        destinoInicio = "/html/user/index_user.html";
    }
    const itemsMenu = document.querySelectorAll(".dropdown-menu .dropdown-item");
    itemsMenu.forEach(function (item) {
        if (item.textContent.trim() === "Inicio") {
            item.href = destinoInicio;
        }
    });

    const chip = document.createElement("div");
    chip.className = "dropdown usuario-chip";
    chip.innerHTML = `
        <button class="btn-usuario" data-bs-toggle="dropdown" aria-expanded="false">
            ${usuario.nombre} ${usuario.apellido}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><span class="dropdown-item-text">${rol}</span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" id="btnCerrarSesion">Cerrar sesión</a></li>
        </ul>
    `;

    header.appendChild(chip);

    document.getElementById("btnCerrarSesion").addEventListener("click", function (e) {
        e.preventDefault();
        sessionStorage.removeItem("usuarioActivo");
        window.location.href = "/html/global/login.html";
    });
}
