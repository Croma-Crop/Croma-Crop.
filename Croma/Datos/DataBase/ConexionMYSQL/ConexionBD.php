<?php

class Conexion {

    private static $instancia = null;

    private function __construct() {
    }

    private function __clone() {
    }

    public static function obtener(): mysqli {
        if (self::$instancia === null) {
            self::$instancia = self::crear();
        }

        return self::$instancia;
    }

    private static function crear(): mysqli {
        $db_host = "localhost";
        $db_usuario = "root";
        $db_clave = "";
        $db_nombre = "srgsi";

        $archivo_local = __DIR__ . "/conexion.local.php";

        if (file_exists($archivo_local)) {
            require $archivo_local;
        }

        $conexion = @mysqli_connect($db_host, $db_usuario, $db_clave, $db_nombre);

        if (!$conexion) {
            error_log("Croma - error de conexion a la base: " . mysqli_connect_error());
            self::mostrarPantallaSinBase();
        }

        return $conexion;
    }

    private static function mostrarPantallaSinBase() {
        if (!headers_sent()) {
            header("Content-Type: text/html; charset=utf-8");
            http_response_code(503);
        }

        $estilo = "margin:64px auto;max-width:520px;padding:32px;font-family:Arial,Helvetica,sans-serif;"
                . "background-color:#ffffff;border:1px solid #d6d6d6;border-radius:4px;color:#30364f";

        echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>SGRSI - Servicio no disponible | Croma Corp</title></head>";
        echo "<body style='background-color:#e8ecef;margin:0'><section style='" . $estilo . "'>";
        echo "<h1>El sistema no puede conectarse a la base de datos</h1>";
        echo "<p>No se perdio ninguna informacion. Espera unos minutos y volve a intentar; ";
        echo "si sigue igual, avisale al equipo de soporte del instituto.</p>";
        echo "</section></body></html>";

        exit;
    }
}
