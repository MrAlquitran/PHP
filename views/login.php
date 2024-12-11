<?php
session_start();
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

require_once '../config/db.php';
require_once '../controllers/UsuarioController.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$userController = new UsuarioController($conn);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar las credenciales del usuario
    $usuario = $userController->autenticarUsuario($email, $password);
    if ($usuario) {
        // Almacenar información del usuario en la sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['name'];
        $_SESSION['is_librarian'] = $usuario['is_librarian']; 
        header("Location: ../public/index.php"); 
        exit();
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="login.php" method="post">
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>