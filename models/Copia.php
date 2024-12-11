<?php
class Copia {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function agregar($libroID, $codigo, $estado) {
        $stmt = $this->pdo->prepare("INSERT INTO Ejemplares (LibroID, Codigo, Estado) VALUES (?, ?, ?)");
        return $stmt->execute([$libroID, $codigo, $estado]);
    }

    public function eliminar($ejemplarID) {
        $stmt = $this->pdo->prepare("DELETE FROM Ejemplares WHERE EjemplarID = ?");
        return $stmt->execute([$ejemplarID]);
    }

    public function modificar($ejemplarID, $libroID, $codigo, $estado) {
        $stmt = $this->pdo->prepare("UPDATE Ejemplares SET LibroID = ?, Codigo = ?, Estado = ? WHERE EjemplarID = ?");
        return $stmt->execute([$libroID, $codigo, $estado, $ejemplarID]);
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM Ejemplares");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDisponibles() {
        $stmt = $this->pdo->query("SELECT * FROM Ejemplares WHERE Estado = 'Bueno' OR Estado = 'Excelente'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>