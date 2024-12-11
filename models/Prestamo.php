<?php
class Prestamo {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function prestar($socioID, $ejemplarID) {
        $fechaPrestamo = date('Y-m-d');
        $fechaDevolucion = date('Y-m-d', strtotime('+21 days'));
        $estadoPrestamo = 'En préstamo';

        $stmt = $this->pdo->prepare("INSERT INTO Prestamos (SocioID, EjemplarID, FechaPrestamo, FechaDevolucion, EstadoPrestamo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$socioID, $ejemplarID, $fechaPrestamo, $fechaDevolucion, $estadoPrestamo]);

        // Actualizar el estado del ejemplar
        $stmt = $this->pdo->prepare("UPDATE Ejemplares SET Estado = 'Prestado' WHERE EjemplarID = ?");
        return $stmt->execute([$ejemplarID]);
    }

    public function devolver($prestamoID) {
        $stmt = $this->pdo->prepare("UPDATE Prestamos SET EstadoPrestamo = 'Devuelto' WHERE PrestamoID = ?");
        $stmt->execute([$prestamoID]);

        // Actualizar el estado del ejemplar
        $stmt = $this->pdo->prepare("UPDATE Ejemplares SET Estado = 'Bueno' WHERE EjemplarID = (SELECT EjemplarID FROM Prestamos WHERE PrestamoID = ?)");
        return $stmt->execute([$prestamoID]);
    }

    public function obtenerPrestamosActivos($socioID) {
        $stmt = $this->pdo->prepare("SELECT * FROM Prestamos WHERE SocioID = ? AND EstadoPrestamo = 'En préstamo'");
        $stmt->execute([$socioID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM Prestamos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>