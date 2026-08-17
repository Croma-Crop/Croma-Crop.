<?php
function obtenerEmpleados(){

}
function guardarEmpleados(empleados){

}
function agregarFila(empleado){
    $fila = "<tr></tr>";
    $documento = $empleado["cedula"];
    if ($empleado["pasaporte"]){

    $documento = $empleado["pasaporte"];
    }
    $fila += "<td>" . $documento . "</td>" .
        "<td>" . $empleado["nombre"] . "</td>" .
        "<td>" . $empleado["apellido"] . "</td>" .
        "<td>" . $empleado["rol"] . "</td>" .
        "<td>••••••</td>" .
        "<td><button class='btnEliminarEmpleado' type='button'>Eliminar</button></td>";
//Falta
function eliminarFilas(){
    $empleadosActuales = $obtenerEmpleados();
    $empleadosFiltrados = [];
    foreach ($empleadosActuales as $emp){
        $doc = $emp["cedula"];
        if ($emp["pasaporte"]){
            $doc = $emp["pasaporte"];
        }
        if ($doc != $documento) {
            $empleadosFiltrados[] = $emp;
        }
    }
    $guardarEmpleados($empleadosFiltrados);
    //realizar la eliminacion de filas en base a php y base de datos
    };
    //agregar la agregacion de filas
};



?>


    fila.querySelector(".btnEliminarEmpleado").addEventListener("click", function () {
        const empleadosActuales = obtenerEmpleados();
        const empleadosFiltrados = [];

        empleadosActuales.forEach(function (emp) {
            let doc = emp.cedula;
            if (emp.pasaporte) {
                doc = emp.pasaporte;
            }
            if (doc !== documento) {
                empleadosFiltrados.push(emp);
            }
        });

        guardarEmpleados(empleadosFiltrados);
        fila.remove();
    });

    tbody.appendChild(fila);
}
formulario.addEventListener("submit", function (e) {
    e.preventDefault();

    const cedulaInput = document.getElementById("cedula");
    const pasaporteInput = document.getElementById("pasaporte");

    const empleado = {
        nombre: document.getElementById("nombre").value.trim(),
        apellido: document.getElementById("apellido").value.trim(),
        rol: document.getElementById("rol").value,
        contrasena: document.getElementById("contrasena").value
    };

    if (pasaporteInput) {
        empleado.pasaporte = pasaporteInput.value.trim();
    } else {
        empleado.cedula = cedulaInput.value.trim();
    }

    const empleados = obtenerEmpleados();
    empleados.push(empleado);
    guardarEmpleados(empleados);

    agregarFila(empleado);
    dialog.close();
    formulario.reset();
});

const empleadosIniciales = obtenerEmpleados();
empleadosIniciales.forEach(function (empleado) {
    agregarFila(empleado);
});