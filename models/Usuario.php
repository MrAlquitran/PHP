<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function registrar($nombreUsuario, $contrasena) {
        $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO Usuarios (NombreUsuario, Contrasena) VALUES (?, ?)");
        return $stmt->execute([$nombreUsuario, $hashedPassword]);
    }

    public function autenticar($nombreUsuario, $contrasena) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE NombreUsuario = ?");
        $stmt->execute([$nombreUsuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario['Contrasena'])) {
            return $usuario;
        }
        return false;
    }

    public function obtenerTodos() {
        $stmt = $this->pdo->query("SELECT * FROM Usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>