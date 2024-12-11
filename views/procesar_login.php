<?php
session_start(); 

require_once '../config/db.php'; 
require_once '../controllers/UsuarioController.php'; 

// Crear conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$userController = new UsuarioController($conn); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar las credenciales del usuario
    try {
        $usuario = $userController->autenticarUsuario($email, $password);
        if ($usuario) {
            // Almacenar información del usuario en la sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_name'] = $usuario['name'];
            $_SESSION['is_librarian'] = $usuario['is_librarian'];
            header("Location: index.php"); 
            exit();
        } else {
            echo "Credenciales incorrectas.";
        }
    } catch (Exception $e) {
        echo "Error al autenticar: " . $e->getMessage();
    }
} else {
    // Si no es una solicitud POST, redirigir al formulario de inicio de sesión
    header("Location: login.php");
    exit();
}
?>