# Convención de Git — Croma Corp

## Commits

Los commits se escriben en **español**, en una sola línea, con la primera palabra en mayúscula y sin punto final. El mensaje sigue la estructura:

```
<Acción> <de/en/a> <módulo o área> [estado] (aclaración opcional)
```

La **acción** indica el tipo de trabajo y se elige del siguiente repertorio:

- **Creacion / Creado** — algo nuevo (un módulo, una función).
- **Maquetacion / Boceto** — estructura HTML o primer armado de una vista.
- **Funcionalidad / Funcion** — lógica de JavaScript.
- **Estilos / Diseño** — trabajo de CSS.
- **Mejora / Mejorando / Puliendo** — refinamiento de algo que ya existía.
- **Cambio / Modificando** — alteración de un comportamiento previo.
- **Avanzando** — progreso parcial que todavía no cierra la tarea.

El **módulo o área** siempre se nombra (inventario, tickets, login, inicio, admin, salones, modulos, estilos, js), porque un commit tiene que entenderse sin abrir el diff. El **estado** (`hecho`, `creado`, `terminado`, `listo`, `inicial`) es opcional y se usa para marcar la fase del trabajo. La **aclaración entre paréntesis** es opcional y se reserva para el alcance o el motivo del cambio, por ejemplo `(frontend)`, `(eliminacion de redundancias)`, `(registro de incidencias y historial)`.

Ejemplos válidos:

- `Creacion del modulo incidenciascreadas`
- `Funcion filtrar en inventario añadida`
- `Mejoras en los estilos de la pagina (eliminacion de redundancias)`

Regla mínima: el mensaje debe poder completar la frase **"Este commit…"**. Mensajes vacíos como `idk` no se aceptan.

## Ramas

Las ramas se nombran en **minúsculas, en español y con guion bajo** (`snake_case`). El nombre es el **tema o la fase de trabajo que la rama contiene** —no la fecha, no el autor, no un número de tarea—, de modo que el denominador común de sus commits coincida con su nombre. Una rama sostiene un solo tema; cuando aparece trabajo de otra naturaleza, se abre una rama nueva en lugar de mezclar.

| Rama | Tema / fase que contiene | Coherencia con sus commits |
|---|---|---|
| `creacion_modulos` | Construcción de los módulos base | Commits de *Creacion de modulo X* y *Maquetacion inicial* |
| `creacion_login` | El módulo de login | *Maquetacion del login listo*; se mergea al cerrarse |
| `divison_modulos` | Separación de módulos por tipo de usuario | Commits sobre *distincion de usuarios en la separacion de modulos* |
| `antes_bootstrap` | Punto de referencia previo a Bootstrap | Nombra un momento del historial, no una feature |
| `media_query` | Diseño responsive / mobile-first | *comienzo de diseño mobile first*, *mobile first 1.1*, *Posible Diseño Final* |
| `validacion_requerimientos` | Resto de requerimientos funcionales | Se declara en su primer commit y sigue con *Creacion de salones...* |

La excepción contemplada es nombrar una rama por un **momento** en vez de por una feature, como `antes_bootstrap`, cuando su propósito es servir de punto de referencia del historial.

Reglas de prolijidad: ortografía consistente (los nombres pueden ir sin tildes, pero siempre del mismo modo) y nombres autoexplicativos, sin abreviar al punto de volverse ambiguos.

Justificación técnica del framework utilizado
Cuál usamos
En el proyecto usamos Bootstrap 5.3.3 como framework de front-end, y lo traemos por CDN (jsDelivr). Son básicamente dos archivos: la hoja de estilos (bootstrap.min.css) que va en el <head>, y el JavaScript (bootstrap.bundle.min.js) que cargamos al final del <body>. Usamos el "bundle" porque ya viene con Popper adentro, que es lo que Bootstrap necesita para posicionar bien los menús desplegables, así no tenemos que sumar otra librería aparte. Dejamos la versión fijada en 5.3.3 para que a todos en el equipo (y al servidor) nos cargue exactamente la misma, y no se nos rompa el diseño si el CDN actualiza.

Después, todo lo demás es web estándar: HTML5, nuestro propio CSS para el diseño y el responsive, y JavaScript vanilla. No usamos ningún framework de JS (ni React, ni Vue, ni Angular, ni jQuery), la persistencia la hacemos con localStorage/sessionStorage y los modales con la etiqueta nativa <dialog>.

Algo importante para ser sinceros con el alcance: Bootstrap lo aprovechamos de forma bastante puntual. Si miran el código, no usamos su grilla ni sus clases de utilidad (nada de container, row, col-, btn, d-flex, etc.). Donde sí lo usamos es en el menú de navegación (el desplegable de hamburguesa) y en el chip de usuario, que aparecen en todas las pantallas. El diseño visual lo pone nuestro CSS; Bootstrap nos resuelve el comportamiento de ese menú.

Por qué lo elegimos
La idea fue no reinventar la rueda en las partes donde un framework te ahorra trabajo y errores. El menú desplegable es un buen ejemplo: hacerlo a mano implica manejar la apertura y el cierre, el cierre al hacer click afuera, el posicionamiento y la accesibilidad (los atributos ARIA, el foco, el aria-expanded). Bootstrap nos da todo eso resuelto y probado, así que el mismo patrón de navegación queda igual de consistente y accesible en todos los módulos sin que tengamos que repetir código.

También pesó que Bootstrap se incorpora por CDN sin necesidad de instalar nada ni de armar un proceso de build (Node, Webpack, etc.). Para un equipo de estudiantes y entregas que van creciendo de a poco, eso es mucho menos fricción y menos cosas que se puedan romper. Además tiene muchísima documentación, soporta las últimas versiones de Chrome, Firefox y Edge, y al ser CSS y JS estándar no nos trae problemas de compatibilidad. Frente a opciones como Tailwind, que sí necesita un paso de build, Bootstrap por CDN nos resultaba más directo para lo que necesitábamos.

Lo de no usar un framework de JavaScript también fue una decisión pensada, no un olvido. Por ahora el sistema es un prototipo de front-end que guarda los datos en localStorage, sin una API ni un estado complicado que justifique meter React o Vue, con todo lo que eso suma en tamaño, build y curva de aprendizaje. Con JavaScript vanilla nos alcanza, queda más liviano, carga más rápido y nos deja manejar el DOM directamente (que era parte de lo que queríamos practicar). El día que haya backend se puede reevaluar, y como cada módulo está separado, migrar después no implicaría rehacer todo.

Cómo lo usamos
En cada página enlazamos el CSS arriba y el bundle de JS abajo. El menú lo armamos con la "API declarativa" de Bootstrap: al disparador le ponemos data-bs-toggle="dropdown" y aria-expanded, y la lista usa las clases del componente (dropdown-menu, dropdown-item, etc.). Con solo esos atributos, Bootstrap se encarga de abrirlo, cerrarlo y ubicarlo; nosotros no escribimos JS para eso.

La parte que más nos gustó es cómo se combina con nuestro propio código. En script.js, la función construirMenu() genera los ítems del menú según el rol del usuario y los inyecta dentro del .dropdown-menu, y construirChip() arma otro desplegable con el nombre del usuario y el "Cerrar sesión", reutilizando las mismas clases. O sea, Bootstrap pone el componente y nosotros lo llenamos dinámicamente desde el sistema de permisos.

Y para que quede claro qué cosas decidimos no delegarle: los modales los hicimos con <dialog> nativo (no con el modal de Bootstrap), la validación de formularios con HTML5 (required, pattern) más JS, y todo el layout, el responsive, la paleta y la tipografía con nuestro CSS.

Justificación técnica del versionado
Qué esquema elegimos
Usamos un número de versión con el formato MAYOR.MENOR. La regla que acordamos es simple: la versión 1.0 llega recién cuando tenemos todo lo necesario para la primera entrega, o sea, cuando el proyecto está completo y listo para mostrar. A partir de ahí, cada cambio estructural o "grande" sube el número menor (1.1, 1.2, etc.), y cuando lleguemos a la segunda entrega damos el salto al mayor: 2.0.

Por qué lo hacemos así
La idea no la inventamos de cero: se apoya en el Versionado Semántico (SemVer), que es un estándar bastante conocido y que usa el formato MAYOR.MENOR.PARCHE. Nosotros adaptamos esa lógica a la realidad de un proyecto académico, donde los hitos naturales son las entregas.

Que la 1.0 sea recién al completar la primera entrega tiene su razón: antes de eso el producto todavía está "en construcción", no es algo terminado que uno quiera presentar. En SemVer, justamente, todo lo anterior a la 1.0 se considera versión de desarrollo (las 0.x), y reservar el "1" para lo que ya está listo respeta esa idea.

El número mayor lo guardamos para los hitos importantes: pasar a 2.0 comunica de una que "esto es un nuevo estado entregable, con cambios fuertes respecto a la entrega anterior". El menor, en cambio, lo usamos para los avances grandes dentro de un mismo ciclo (un módulo nuevo, un refactor que cambia cómo está armado el proyecto) sin tener que inflar el mayor por cada paso.

Lo principal que nos da este esquema es trazabilidad y un lenguaje común: cualquiera del equipo, o el docente, entiende con solo ver el número en qué punto del proyecto está parado, y siempre podemos volver a "cómo estaba en la 1.0". Además se complementa con lo que ya tenemos: git y nuestras convenciones de commits y ramas. Los commits cuentan el detalle del día a día; las versiones quedan por encima, marcando los hitos grandes. No compiten entre sí, se complementan.

Qué consideramos un "cambio grande"
Para que no quede ambiguo, fijamos un criterio: sube el menor cuando hay un cambio de estructura o arquitectura, se agrega un módulo nuevo, o se hace un refactor que cambia cómo está organizado el proyecto. Las correcciones chicas o los ajustes de estilo no mueven la versión (y si en algún momento quisiéramos registrarlos, irían en un tercer número, el "parche": 1.0.1, 1.0.2).


Justificación del manejador de repositorios

Por qué Git
La razón más directa es que el proyecto pedía usar Git, con historial de commits y uso de ramas. Pero igual lo habríamos elegido, porque es el que se usa en casi todos lados, así que es lo que nos sirve aprender y el que tiene más material y ayuda dando vueltas si nos trabamos.

Lo que más nos sirvió en la práctica es que con Git cada uno tiene una copia completa del proyecto en su máquina, con todo el historial. Eso quiere decir que podemos trabajar aunque no haya internet, y después sincronizar; que armar una rama nueva para probar algo no cuesta nada; y que si algo sale mal siempre podemos volver a como estaba antes. Para un equipo donde varios tocamos el código al mismo tiempo, eso es justo lo que necesitábamos. Otras opciones como SVN funcionan de una forma más atada al servidor, y nos parecían menos cómodas para trabajar en paralelo.

Por qué GitHub
Git solo nos resolvía el tema en cada compu, pero nos faltaba un lugar central donde juntar el trabajo de todos, y para eso usamos GitHub. Es gratis para lo que necesitamos, nos dejó armar una organización (la de Croma-Crop) para tener el repo del equipo agrupado y decidir quién entra, y además se lleva muy bien con las herramientas que ya usábamos: lo manejamos tanto desde VS Code como desde la consola. Tiene un montón de documentación y, si más adelante queremos ordenar más el trabajo, ya trae cosas como los pull requests para revisar cambios antes de sumarlos. Hay otras páginas parecidas, como GitLab o Bitbucket, pero elegimos GitHub porque es la que más conocíamos y la más usada.

Cómo lo usamos
El repositorio está en la organización Croma-Crop y cada uno lo clona y lo mantiene actualizado. Tenemos la rama principal (main) y vamos abriendo ramas aparte para cada parte o cada etapa del trabajo —con nombres en español, como dejamos anotado en CONVENCIONES.md— y cuando esa parte queda terminada la juntamos con un merge. Los mensajes de los commits los escribimos siguiendo nuestra convención, así el historial se entiende sin tener que abrir el código, y las versiones las marcamos con tags como el v1.0.0.