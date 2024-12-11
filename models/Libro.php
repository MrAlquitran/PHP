<?php
class Libro {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function agregar($titulo, $editorial, $isbn, $fechaPublicacion) {
        $stmt = $this->pdo->prepare("INSERT INTO Libros (Titulo, Editorial, ISBN, FechaPublicacion) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$titulo, $editorial, $isbn, $fechaPublicacion]);
    }

    public function eliminar($libroID) {
        $stmt = $this->pdo->prepare("DELETE FROM Libros WHERE LibroID = ?");
        return $stmt->execute([$libroID]);
    }

    public function modificar($libroID, $titulo, $editorial, $isbn, $fechaPublicacion) {
        $stmt = $this->pdo->prepare("UPDATE Libros SET Titulo = ?, Editorial = ?, ISBN = ?, FechaPublicacion = ? WHERE LibroID = ?");
        return $stmt->execute([$titulo, $editorial, $isbn, $fechaPublicacion, $libroID]);
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM Libros");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar($busqueda) {
        $stmt = $this->pdo->prepare("SELECT * FROM Libros WHERE Titulo LIKE ? OR ISBN LIKE ?");
        $stmt->execute(["%$busqueda%", "%$busqueda%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>