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



                <p>Tipo de incidencia</p>
                <select id="tipo" name="tipo" required>
                    <option value="">---Seleccionar---</option>
                    <option value="Computadora">Computadora</option>
                    <option value="Televisor">Televisor</option>
                    <option value="Periferico">Periferico</option>
                    <option value="Otro">Otro</option>
                </select>
                <p>¿Cual es la incidencia?</p>
                <input id="descripcioninc" name="incInput">
                <button id="enviarinc">Enviar Incidencia</button>
                <button type="button" id="volverInc">Volver</button>