<h1>Miembros</h1>
<a href="agregar_miembro.php">Agregar Miembro</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($miembros as $miembro): ?>
        <tr>
            <td><?php echo $miembro['MiembroID']; ?></td>
            <td><?php echo $miembro['Nombre']; ?></td>
            <td><?php echo $miembro['Email']; ?></td>
            <td><?php echo $miembro['Telefono']; ?></td>
            <td>
                <a href="editar_miembro.php?id=<?php echo $miembro['MiembroID']; ?>">Editar</a>
                <a href="eliminar_miembro.php?id=<?php echo $miembro['MiembroID']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>