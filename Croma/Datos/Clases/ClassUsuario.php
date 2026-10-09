<?php

require_once __DIR__ . "/../DataBase/ErroresBD.php";
require_once __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Usuario {
public mysqli $conexion;
public string $documento;
public String $nombre;
public String $apellido;
public string $contrasena;
public String $rol;

    public function __construct(mysqli $conexion, String $documento, string $nombre, string $apellido, string $contrasena, ?string $rol = null) {
        $this->documento = $documento;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->contrasena = $contrasena;
        $this->rol = $rol ?? $this->rolPorDefecto();
        $this->conexion = $conexion;
    }

    Public function rolPorDefecto(): string{
        return "tecnico";
    }

    public static function crear(mysqli $conexion, string $rol, string $documento, string $nombre, string $apellido, string $contrasena): ?Usuario {

        if ($rol === "administrador" || $rol === "tecnico" || $rol === "solicitante") {
            return new Usuario($conexion, $documento, $nombre, $apellido, $contrasena, $rol);
        }

        return null;
    }

    public function getRol(): string {
        return $this->rol;
    }
    public function crearusuario(): bool {
        try {
        $sql = "INSERT INTO usuario (documento, nombre, apellido, contrasena, rol) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);

         if (!$stmt) {
            return false;
        }



        $stmt->bind_param("sssss", $this->documento, $this->nombre, $this->apellido, $this->contrasena, $this->rol);
 if (!$stmt->execute()) {
            return false;
        }

        return true;
    

    } catch (mysqli_sql_exception $e) {
        return registrarErrorBD($e, "Usuario");

        }


    }
    public static function mostrarsolicitantes($conexion){
        $rolProfesor = "solicitante";
        $stmtProfesores = $conexion->prepare("SELECT documento, nombre, apellido FROM usuario WHERE rol = ?");
        $stmtProfesores->bind_param("s", $rolProfesor);
        $stmtProfesores->execute();
        return $stmtProfesores->get_result()->fetch_all(MYSQLI_ASSOC);

    }

    public static function mostrar($conexion){
    $sql = $conexion->query("SELECT documento, nombre, apellido, rol FROM usuario");
    $usuarios = [];
    while ($fila = $sql->fetch_assoc()) {
    $usuarios[] = $fila;
    
    

}
return $usuarios;
 }
 public function buscarpordocumento($documento){
    $sql = "SELECT nombre, documento FROM usuario WHERE documento = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $documento);
    return $stmt->execute();
 }

  public function borrar($documento){
     $sql = "DELETE FROM usuario WHERE documento = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $documento);
    return $stmt->execute();
 }
 public static function existe($conexion, $documento){
    $sql = "SELECT documento FROM usuario WHERE documento = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("s", $documento);
    $stmt->execute();

    if (!$stmt->get_result()->fetch_assoc()) {
        return false;
    }

    return true;
 }

 public static function esTecnico($conexion, $documento){
    $rolTecnico = "tecnico";
    $sql = "SELECT documento FROM usuario WHERE documento = ? AND rol = ?";
    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("ss", $documento, $rolTecnico);
    $stmt->execute();
    $fila = $stmt->get_result()->fetch_assoc();

    if (!$fila) {
        return false;
    }

    return true;
 }

 public function iniciarsesion($documento){
    $sql = "SELECT documento, nombre, apellido, contrasena, rol FROM usuario WHERE documento = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param( "s", $documento);
    $stmt->execute();
    $resultado = mysqli_stmt_get_result($stmt);
    $filaUsuario = mysqli_fetch_assoc($resultado);
    return $filaUsuario;
 }
 
}

?>