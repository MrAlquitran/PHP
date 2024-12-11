<?php
include 'db.php';

class PrestamoController {
    public function prestarEjemplar($socioID, $ejemplarID) {
        global $pdo;
        $fechaPrestamo = date('Y-m-d');
        $fechaDevolucion = date('Y-m-d', strtotime('+21 days')); 
        $estadoPrestamo = 'En préstamo';

        $stmt = $pdo->prepare("INSERT INTO Prestamos (SocioID, EjemplarID, FechaPrestamo, FechaDevolucion, EstadoPrestamo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$socioID, $ejemplarID, $fechaPrestamo, $fechaDevolucion, $estadoPrestamo]);

        // Actualizar el estado del ejemplar
        $stmt = $pdo->prepare("UPDATE Ejemplares SET Estado = 'Prestado' WHERE EjemplarID = ?");
        $stmt->execute([$ejemplarID]);
    }

    public function devolverEjemplar($prestamoID) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT EjemplarID FROM Prestamos WHERE PrestamoID = ?");
        $stmt->execute([$prestamoID]);
        $ejemplarID = $stmt->fetchColumn();

        $stmt = $pdo->prepare("UPDATE Prestamos SET EstadoPrestamo = 'Devuelto' WHERE PrestamoID = ?");
        $stmt->execute([$prestamoID]);

        // Actualizar el estado del ejemplar
        $stmt = $pdo->prepare("UPDATE Ejemplares SET Estado = 'Bueno' WHERE EjemplarID = ?");
        $stmt->execute([$ejemplarID]);
    }

    public function mostrarPrestamos() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM Prestamos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>