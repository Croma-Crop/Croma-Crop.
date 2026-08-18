<?php
require "../conexion.php";

class Usuario {
public int $documento;
public String $nombre
public String $apellido
private String $contraseña;
public String $rol;

 public function iniciarSesion(): bool {
        
        return true;
    }

    public function cerrarSesion() {
        
    }
    public function __construct(int $documento, string $nombre, string $apellido, string $contraseña) {
        msqli
        $this->documento = $documento;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->contraseña = $contraseña;
        $this->rol = $this->rolPorDefecto();
    }

    Public function rolPorDefecto(): string;
    public function getRol(): string {
        return $this->rol;
    }

}
class Solicitante extends Usuario {
    public function rolPorDefecto(): String {
        return "solicitante";
    }
    public function crearSolicitud(): void { /* ... */ }
    public function hacerRegistroDiario(): void { /* ... */ }
    public function registrarIncidencia(): void { /* ... */ }
}

class Tecnico extends Usuario {
    public function rolPorDefecto(): String {
        return "tecnico";
    }
    public function resolverIncidencia(): void { /* ... */ }
    public function gestionarInventario(): void { /* ... */ }
    public function asignarIncidencia(): void { /* ... */ }
    public function registrarIntervencion(): void { /* ... */ }
    public function procesarSolicitudSoftware(): void { /* ... */ }
}

class Administrador extends Usuario {
    public function rolPorDefecto(): string {
        return "administrador";
    }
    public function gestionarUsuarios(): void { /* ... */ }
    public function gestionarInventario(): void { /* ... */ }
    public function gestionarIncidencias(): void { /* ... */ }
    public function gestionarSolicitudes(): void { /* ... */ }
}

?>