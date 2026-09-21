<?php

function limpiarTexto($valor){
    if (!isset($valor)) {
        return "";
    }
    $texto = (string) $valor;
    $texto = strip_tags($texto);
    $texto = trim($texto);
    return $texto;
}

function limpiarTextoCorto($valor, $largoMaximo){
    $texto = limpiarTexto($valor);
    if (strlen($texto) > $largoMaximo) {
        $texto = substr($texto, 0, $largoMaximo);
    }
    return $texto;
}

function limpiarNumero($valor){
    $texto = limpiarTexto($valor);
    $numero = "";
    $largo = strlen($texto);
    for ($i = 0; $i < $largo; $i++) {
        if (ctype_digit($texto[$i])) {
            $numero = $numero . $texto[$i];
        }
    }
    return $numero;
}

function limpiarEntero($valor){
    $numero = limpiarNumero($valor);
    if ($numero === "") {
        return "";
    }
    return (int) $numero;
}

function limpiarDocumento($valor){
    $texto = limpiarTexto($valor);
    $documento = "";
    $largo = strlen($texto);
    for ($i = 0; $i < $largo; $i++) {
        $caracter = $texto[$i];
        if (ctype_alnum($caracter)) {
            $documento = $documento . $caracter;
        }
    }
    return limpiarTextoCorto($documento, 12);
}

function limpiarSerie($valor){
    $texto = limpiarTexto($valor);
    $serie = "";
    $largo = strlen($texto);
    for ($i = 0; $i < $largo; $i++) {
        $caracter = $texto[$i];
        if (ctype_alnum($caracter) || $caracter === "-" || $caracter === "_") {
            $serie = $serie . $caracter;
        }
    }
    return limpiarTextoCorto($serie, 50);
}

function limpiarFecha($valor){
    $texto = limpiarTexto($valor);
    $partes = explode("-", $texto);
    if (count($partes) !== 3) {
        return "";
    }
    $anio = $partes[0];
    $mes = $partes[1];
    $dia = $partes[2];
    if ($anio !== limpiarNumero($anio) || $mes !== limpiarNumero($mes) || $dia !== limpiarNumero($dia)) {
        return "";
    }
    if (!checkdate((int) $mes, (int) $dia, (int) $anio)) {
        return "";
    }
    return $texto;
}

function limpiarHora($valor){
    $texto = limpiarTexto($valor);
    $partes = explode(":", $texto);
    if (count($partes) < 2) {
        return "";
    }
    $hora = $partes[0];
    $minutos = $partes[1];
    if ($hora !== limpiarNumero($hora) || $minutos !== limpiarNumero($minutos)) {
        return "";
    }
    if ((int) $hora > 23 || (int) $minutos > 59) {
        return "";
    }
    if (strlen($hora) === 1) {
        $hora = "0" . $hora;
    }
    if (strlen($minutos) === 1) {
        $minutos = "0" . $minutos;
    }
    return $hora . ":" . $minutos;
}

function limpiarOpcion($valor, $opciones){
    $texto = limpiarTexto($valor);
    foreach ($opciones as $opcion) {
        if ($texto === $opcion) {
            return $texto;
        }
    }
    return "";
}

