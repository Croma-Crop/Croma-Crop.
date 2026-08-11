# Croma Corp — SGRSI

Sistema de Gestión de Recursos y Soporte de Informática del instituto (ITI - DGTEP).
Prototipo de front-end hecho con HTML5, CSS y JavaScript vanilla, con Bootstrap 5.3.3 por CDN
para el menú de navegación. Los datos se guardan en `localStorage` y la sesión en `sessionStorage`.

## Cómo levantarlo

El proyecto usa rutas absolutas desde la raíz (`/assets/...`, `/pages/...`), así que hay que servirlo
tomando **la carpeta del proyecto como raíz del servidor** (Live Server de VS Code abriendo esta
carpeta, o un virtual host de XAMPP apuntando acá). La entrada del sistema es `index.html`, que es el login.

## Estructura

```
.
├── index.html              Login (entrada del sistema)
├── assets/
│   ├── css/                Una hoja por módulo + global.css
│   ├── js/                 Un script por módulo + los compartidos
│   └── img/                Logo e íconos
├── pages/
│   ├── admin/              Páginas exclusivas del administrador
│   ├── tecnico/            Páginas exclusivas del técnico
│   ├── usuario/            Páginas exclusivas del solicitante
│   └── *.html              Módulos que usan varios roles
├── CONVENCIONES.md         Convenciones de commits, ramas, versionado y framework
└── README.md
```

Scripts compartidos por todas las páginas:

- `assets/js/permisos.js` — módulos del sistema, permisos por rol, acciones e inicio de cada rol.
- `assets/js/script.js` — valida la sesión, arma el menú hamburguesa y el chip de usuario.
- `assets/js/clasificacion.js` — lo compartido por las tarjetas de tickets: gravedades, estados, sus colores, el armado de `<option>` y el botón "Ver más".

## Circuito de un ticket

El docente registra la incidencia o la solicitud en **Tickets**; nace en estado `Pendiente` y sin asignar.
El técnico entra al **Tablero Kanban**, toma la tarea, le determina la **gravedad** y la mueve entre
`Pendiente`, `En proceso` y `Resuelto`. En **Incidencias** cualquiera consulta ese avance: gravedad,
estado y técnico asignado quedan a la vista, pero solo se editan desde el tablero.

## Roles

| Rol | Inicio | Puede |
|---|---|---|
| `admin` | `/pages/admin/index_admin.html` | Inventario, salones, tickets, incidencias, ficha y la gestión de empleados |
| `tecnico` | `/pages/tecnico/index_tecnico.html` | Inventario, tickets, incidencias y el tablero kanban, donde toma las tareas y les determina la gravedad |
| `solicitante` | `/pages/usuario/index_usuario.html` | Registrar tickets, ver incidencias y su ficha |
