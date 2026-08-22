<?php
require __DIR__ . '/../DataBase/ConexionMYSQL/conexion.php';

class Usuario {
public mysqli $conexion;
public string $documento;
public String $nombre;
public String $apellido;
public string $contrasena;
public String $rol;

    public function __construct(mysqli $conexion, String $documento, string $nombre, string $apellido, string $contrasena) {
        $this->documento = $documento;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->contrasena = $contrasena;
        $this->rol = $this->rolPorDefecto();
        $this->conexion = $conexion;
    }

    Public function rolPorDefecto(): string{
        return "tecnico";
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
        return false;

        }


    }

    public static function mostrar(){
    global $conexion;
    $sql = $conexion->query("SELECT documento, nombre, apellido, documento, rol, contrasena FROM usuario");
    $usuarios = [];
    while ($fila = $sql->fetch_assoc()) {
    $usuarios[] = $fila;
    

}
return $usuarios;
 }

  public function borrar($documento){
     $sql = "DELETE FROM usuario WHERE documento = ?";
    $stmt = $this->conexion->prepare($sql);
    $stmt->bind_param("s", $documento);
    return $stmt->execute();
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


class solicitante extends Usuario {
    public function rolPorDefecto(): String {
        return "solicitante";
    }

  
}

class tecnico extends Usuario {
    public function rolPorDefecto(): String {
        return "tecnico";
    }
   
}

class administrador extends Usuario {
    public function rolPorDefecto(): string {
        return "administrador";
    }
    

}

?>