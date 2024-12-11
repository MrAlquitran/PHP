<?php
include 'db.php';

class MiembroController {
    public function agregarSocio($usuarioID, $numeroSocio, $direccion, $telefono, $dniConfirmado) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO Socios (UsuarioID, NumeroSocio, Direccion, Telefono, DNIConfirmado) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$usuarioID, $numeroSocio, $direccion, $telefono, $dniConfirmado]);
    }

    public function eliminarSocio($socioID) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM Socios WHERE SocioID = ?");
        $stmt->execute([$socioID]);
    }

    public function modificarSocio($socioID, $numeroSocio, $direccion, $telefono, $dniConfirmado) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE Socios SET NumeroSocio = ?, Direccion = ?, Telefono = ?, DNIConfirmado = ? WHERE SocioID = ?");
        $stmt->execute([$numeroSocio, $direccion, $telefono, $dniConfirmado, $socioID]);
    }

    public function mostrarSocios() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM Socios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>