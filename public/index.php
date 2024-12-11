<?php
require_once '../config/db.php';
require_once '../controllers/UsuarioController.php'; 
require_once '../controllers/LibroController.php';

// Crear conexión a la base de datos
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$userController = new UsuarioController($conn); 
$libroController = new LibroController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Registro de usuario
        $name = $_POST['name'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $isLibrarian = isset($_POST['isLibrarian']) ? 1 : 0;

        try {
            $userController->agregarUsuario($name, $apellido1, $apellido2, $email, $password, $isLibrarian);
            echo "Registro exitoso";
        } catch (Exception $e) {
            echo "Error al registrar: " . $e->getMessage();
        }
    } elseif (isset($_POST['addBook'])) {
        // Agregar libro
        $titulo = $_POST['titulo'];
        $editorial = $_POST['editorial'];
        $isbn = $_POST['isbn'];
        $fechaPublicacion = $_POST['fechaPublicacion'];
        $nombreAutor = $_POST['nombre']; 

        // Llamar al método agregarLibro
        try {
            $autorID = $libroController->agregarAutor($nombreAutor); 
            
            $libroID = $libroController->agregarLibro($titulo, $editorial, $isbn, $fechaPublicacion);
            
            $libroController->agregarAutorALibro($libroID, $autorID);
            
            echo "Libro agregado exitosamente";
        } catch (Exception $e) {
            echo "Error al agregar libro: " . $e->getMessage();
        }
    }
}

// Obtener libros disponibles
$libros = $libroController->mostrarLibros();
?>

<!-- Formulario de registro de usuario -->
<form action="" method="post">
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" required><br><br>
    
    <label for="apellido1">Primer apellido:</label>
    <input type="text" id="apellido1" name="apellido1" required><br><br>
    
    <label for="apellido2">Segundo apellido:</label>
    <input type="text" id="apellido2" name="apellido2"><br><br>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br><br>
    
    <label for="isLibrarian">Es bibliotecario:</label>
    <input type="checkbox" id="isLibrarian" name="isLibrarian" value="true"><br><br>
    
    <button type="submit" name="register">Registrar</button>
</form>

<!-- Formulario para añadir libros (solo si es bibliotecario) -->
<?php if (isset($_POST['isLibrarian'])): ?> <form action="" method="post"> <h2>Añadir Libro</h2>
<label for="titulo">Título:</label>
<input type="text" id="titulo" name="titulo" required><br><br>

<label for="editorial">Editorial:</label>
<input type="text" id="editorial" name="editorial" required><br><br>

<label for="isbn">ISBN:</label>
<input type="text" id="isbn" name="isbn" required><br><br>
<label for="fechaPublicacion">Fecha de Publicación:</label>
<input type="date" id="fechaPublicacion" name="fechaPublicacion" required><br><br>

<label for="nombreAutor">Nombre del Autor:</label>
<input type="text" id="nombreAutor" name="nombreAutor" required><br><br>

<button type="submit" name="addBook">Añadir Libro</button>
</form> <?php endif; ?>
<?php
session_start();

// Verifica si el usuario ha iniciado sesión y si es bibliotecario
if (isset($_SESSION['EsBibliotecario']) && $_SESSION['EsBibliotecario'] === true): ?>
    <form action="" method="post">
        <h2>Añadir Libro</h2>
        
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>
        
        <label for="editorial">Editorial:</label>
        <input type="text" id="editorial" name="editorial" required><br><br>
        
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required><br><br>
        
        <label for="fechaPublicacion">Fecha de Publicación:</label>
        <input type="date" id="fechaPublicacion" name="fechaPublicacion" required><br><br>

        <label for="nombreAutor">Nombre del Autor:</label>
        <input type="text" id="nombreAutor" name="nombreAutor" required><br><br>
        
        <button type="submit" name="addBook">Añadir Libro</button>
    </form>
<?php else: ?>
    <p>No tienes permiso para añadir libros. Solo los bibliotecarios pueden acceder a esta sección.</p>
<?php endif; ?>
<a href="#" id="mostrar-libros">Mostrar libros disponibles</a>

<div id="libros" style="display: none;">
    <h2>Libros Disponibles</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Editorial</th>
            <th>ISBN</th>
            <th>Fecha de Publicación</th>
            <th>Autores</th> 
        </tr>
        <?php foreach ($libros as $libro): ?>
        <tr>
            <td><?php echo $libro['LibroID']; ?></td>
            <td><?php echo $libro['Titulo']; ?></td>
            <td><?php echo $libro['Editorial']; ?></td>
            <td><?php echo $libro['ISBN']; ?></td>
            <td><?php echo $libro['FechaPublicacion']; ?></td>
            <td><?php echo $libro['Autores']; ?></td> 
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
    document.getElementById("mostrar-libros").addEventListener("click", function(event) {
        event.preventDefault();
        var libros = document.getElementById("libros");
        if (libros.style.display === "none") {
            libros.style.display = "block";
        } else {
            libros.style.display = "none";
        }
    });
</script>
<a href="../views/logout.php">Iniciar Sesión</a>