<?php
include 'db.php';

class CopiaController {
    public function agregarCopia($libroID, $codigo, $estado) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO Ejemplares (LibroID, Codigo, Estado) VALUES (?, ?, ?)");
        $stmt->execute([$libroID, $codigo, $estado]);
    }

    public function eliminarCopia($ejemplarID) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM Ejemplares WHERE EjemplarID = ?");
        $stmt->execute([$ejemplarID]);
    }

    public function modificarCopia($ejemplarID, $libroID, $codigo, $estado) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE Ejemplares SET LibroID = ?, Codigo = ?, Estado = ? WHERE EjemplarID = ?");
        $stmt->execute([$libroID, $codigo, $estado, $ejemplarID]);
    }

    public function mostrarCopias() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM Ejemplares");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function mostrarCopiasDisponibles() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM Ejemplares WHERE Estado = 'Bueno' OR Estado = 'Excelente'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>