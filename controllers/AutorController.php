<?php
include 'db.php'; 
include 'Autor.php'; 

class AutorController {
    private $autorModel;

    public function __construct($pdo) {
        $this->autorModel = new Autor($pdo);
    }

    public function agregarAutor($nombre) {
        return $this->autorModel->agregar($nombre);
    }

    public function eliminarAutor($autorID) {
        return $this->autorModel->eliminar($autorID);
    }

    public function modificarAutor($autorID, $nombre) {
        return $this->autorModel->modificar($autorID, $nombre);
    }

    public function mostrarAutores() {
        return $this->autorModel->obtenerTodos();
    }
}
?>