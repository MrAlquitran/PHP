<?php
class UsuarioController {
    private $conn;

    // Constructor para recibir la conexión a la base de datos
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Método para autenticar al usuario
    public function autenticarUsuario($email, $password) {
        // Cambiar 'id' por 'UsuarioID' y asegurarte de incluir 'password' en la consulta
        $stmt = $this->conn->prepare("SELECT UsuarioID, Nombre, EsBibliotecario, Contraseña FROM Usuarios WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si el usuario existe
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Verificar la contraseña (asegúrate de que la contraseña esté encriptada en la base de datos)
            if (password_verify($password, $usuario['Contraseña'])) {
                return [
                    'id' => $usuario['UsuarioID'],
                    'name' => $usuario['Nombre'],
                    'is_librarian' => $usuario['EsBibliotecario']
                ]; // Retorna la información del usuario
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // Usuario no encontrado
        }
    }

    // Método para agregar un usuario (opcional)
    public function agregarUsuario($name, $apellido1, $apellido2, $email, $password, $isLibrarian) {
        // Encriptar la contraseña antes de almacenarla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta para insertar el usuario
        $stmt = $this->conn->prepare("INSERT INTO usuarios (name, apellido1, apellido2, email, password, is_librarian) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $apellido1, $apellido2, $email, $hashedPassword, $isLibrarian);
        $stmt->execute();
    }
}