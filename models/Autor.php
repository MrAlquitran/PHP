<?php
class Autor {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function agregar($nombre) {
        $stmt = $this->pdo->prepare("INSERT INTO Autores (Nombre) VALUES (?)");
        return $stmt->execute([$nombre]);
    }

    public function eliminar($autorID) {
        $stmt = $this->pdo->prepare("DELETE FROM Autores WHERE AutorID = ?");
        return $stmt->execute([$autorID]);
    }

    public function modificar($autorID, $nombre) {
        $stmt = $this->pdo->prepare("UPDATE Autores SET Nombre = ? WHERE AutorID = ?");
        return $stmt->execute([$nombre, $autorID]);
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM Autores");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>