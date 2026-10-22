<?php
require_once __DIR__ . '/../Datos/Clases/ClassInventario.php';
require_once __DIR__ . '/../Datos/Clases/ClassSalones.php';
require_once __DIR__ . '/../Datos/Clases/ClassIncidencia.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuario.php';
require_once __DIR__ . '/../Datos/Clases/ClassUsuarioExtranjero.php';
require_once __DIR__ . '/../Datos/DataBase/ConexionMYSQL/conexion.php';

$equiposFallas = Inventario::mostrarMetrica($conexion);
$incidencias = Incidencia::mostrar($conexion);

$inventario = new Inventario($conexion, '', '', '', '', '');
$salon = new Salon($conexion, '', '', '0');
$hoy = new DateTime('today');
$vencidas = [];

foreach ($equiposFallas as $i => $equipoFalla) {
    $equiposFallas[$i]['nombre_salon'] = '-';

    if (!empty($equipoFalla['id_salon'])) {
        $datosSalon = $salon->buscaridficha($equipoFalla['id_salon']);

        if ($datosSalon) {
            $equiposFallas[$i]['nombre_salon'] = $datosSalon['nombre'];
        }
    }
}

foreach ($incidencias as $incidencia) {
    if ($incidencia['fecha_limite'] === null) {
        continue;
    }

    $limite = new DateTime($incidencia['fecha_limite']);

    if ($limite < $hoy && $incidencia['estado'] !== 'Resuelto') {
        $incidencia['dias_atraso'] = $limite->diff($hoy)->days;
        $incidencia['tecnico'] = '-';
        $incidencia['equipo'] = '-';
        $incidencia['salon'] = '-';

        if (!empty($incidencia['cedula_tecnico'])) {
            $datosTecnico = Usuario::buscarNombre($conexion, $incidencia['cedula_tecnico']);

            if (!$datosTecnico) {
                $datosTecnico = Usuarioextranjero::buscarNombre($conexion, $incidencia['cedula_tecnico']);
            }

            if ($datosTecnico) {
                $incidencia['tecnico'] = $datosTecnico['nombre'] . ' ' . $datosTecnico['apellido'];
            }
        }

        if (!empty($incidencia['numero_serie'])) {
            $equipo = $inventario->buscarpornumero($incidencia['numero_serie']);

            if ($equipo) {
                $incidencia['equipo'] = $equipo['nombre'];

                $datosSalon = $salon->buscaridficha($equipo['id_salon']);
                if ($datosSalon) {
                    $incidencia['salon'] = $datosSalon['nombre'];
                }
            }
        }

        $vencidas[] = $incidencia;
    }
}