<?php
class Miembro {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrar($nombre, $email, $telefono) {
        $stmt = $this->pdo->prepare("INSERT INTO Miembros (Nombre, Email, Telefono) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $email, $telefono]);
    }

    public function eliminar($miembroID) {
        $stmt = $this->pdo->prepare("DELETE FROM Miembros WHERE MiembroID = ?");
        return $stmt->execute([$miembroID]);
    }

    public function modificar($miembroID, $nombre, $email, $telefono) {
        $stmt = $this->pdo->prepare("UPDATE Miembros SET Nombre = ?, Email = ?, Telefono = ? WHERE MiembroID = ?");
        return $stmt->execute([$nombre, $email, $telefono, $miembroID]);
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM Miembros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>