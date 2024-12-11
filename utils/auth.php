<?php
session_start(); 

// Función para autenticar al usuario
function autenticar($usuario, $contrasena) {
    include 'db.php'; 

    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE NombreUsuario = ?");
    $stmt->execute([$usuario]);
    $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuarioDB && password_verify($contrasena, $usuarioDB['Contrasena'])) {
        // Almacenar información del usuario en la sesión
        $_SESSION['usuario_id'] = $usuarioDB['UsuarioID'];
        $_SESSION['nombre_usuario'] = $usuarioDB['NombreUsuario'];
        return true; 
    } 
    return false; // Autenticación fallida
}

// Función para cerrar sesión
function cerrarSesion() {
    session_start();
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión
}

// Función para verificar si el usuario está autenticado
function estaAutenticado() {
    return isset($_SESSION['usuario_id']);
}

// Función para obtener el ID del usuario autenticado
function obtenerUsuarioId() {
    return $_SESSION['usuario_id'] ?? null;
}

// Función para obtener el nombre de usuario autenticado
function obtenerNombreUsuario() {
    return $_SESSION['nombre_usuario'] ?? null;
}

// Función para verificar si el usuario tiene un rol específico
function tieneRol($rol) {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === $rol;
}
?>