<h1>Copias</h1>
<a href="agregar_copia.php">Agregar Copia</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Libro ID</th>
            <th>Código</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($copias as $copia): ?>
        <tr>
            <td><?php echo $copia['EjemplarID']; ?></td>
            <td><?php echo $copia['LibroID']; ?></td>
            <td><?php echo $copia['Codigo']; ?></td>
            <td><?php echo $copia['Estado']; ?></td>
            <td>
                <a href="editar_copia.php?id=<?php echo $copia['EjemplarID']; ?>">Editar</a>
                <a href="eliminar_copia.php?id=<?php echo $copia['EjemplarID']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>