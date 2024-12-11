<?php
require_once '../config/db.php'; 
require_once '../controllers/LibroController.php';

$libroController = new LibroController($const);

$libros = $libroController->mostrarLibros();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros Disponibles</title>
</head>
<body>
    <h1>Libros Disponibles</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Editorial</th>
            <th>ISBN</th>
            <th>Fecha de Publicación</th>
        </tr>
        <?php foreach ($libros as $libro): ?>
        <tr>
            <td><?php echo $libro['LibroID']; ?></td>
            <td><?php echo $libro['Titulo']; ?></td>
            <td><?php echo $libro['Editorial']; ?></td>
            <td><?php echo $libro['ISBN']; ?></td>
            <td><?php echo $libro['FechaPublicacion']; ?></td>
            <td><?php echo $libro[''];?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>