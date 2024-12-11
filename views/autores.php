<h1>Lista de Autores</h1>

<a href="agregar_autor.php">Agregar Autor</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($autores as $autor): ?>
            <tr>
                <td><?php echo $autor['id']; ?></td>
                <td><?php echo $autor['nombre']; ?></td>
                <td>
                    <a href="editar_autor.php?id=<?php echo $autor['id']; ?>">Editar</a>
                    <a href="eliminar_autor.php?id=<?php echo $autor['id']; ?>">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Agregar Nuevo Autor</h2>
<form action="agregar_autor.php" method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>
    <button type="submit">Agregar Autor</button>
</form>