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
