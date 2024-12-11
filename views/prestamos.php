<h1>Préstamos</h1>
<a href="agregar_prestamo.php">Agregar Préstamo</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Socio ID</th>
            <th>Ejemplar ID</th>
            <th>Fecha de Préstamo</th>
            <th>Fecha de Devolución</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($prestamos as $prestamo): ?>
        <tr>
            <td><?php echo $prestamo['PrestamoID']; ?></td>
            <td><?php echo $prestamo['SocioID']; ?></td>
            <td><?php echo $prestamo['EjemplarID']; ?></td>
            <td><?php echo $prestamo['FechaPrestamo']; ?></td>
            <td><?php echo $prestamo['FechaDevolucion']; ?></td>
            <td><?php echo $prestamo['EstadoPrestamo']; ?></td>
            <td>
                <a href="devolver_prestamo.php?id=<?php echo $prestamo['PrestamoID']; ?>">Devolver</a>
                <a href="eliminar_prestamo.php?id=<?php echo $prestamo['PrestamoID']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>