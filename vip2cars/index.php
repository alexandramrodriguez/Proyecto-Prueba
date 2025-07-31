<?php include "db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Vehículos - VIP2CARS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Vehículos Registrados</h1>
    <a href="create.php" class="btn-amarillo">Registrar nuevo vehículo</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>Placa</th><th>Marca</th><th>Modelo</th><th>Año</th>
            <th>Cliente</th><th>Documento</th><th>Correo</th><th>Teléfono</th><th>Acciones</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM vehiculos");
        while($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['placa'] ?></td>
            <td><?= $row['marca'] ?></td>
            <td><?= $row['modelo'] ?></td>
            <td><?= $row['anio_fabricacion'] ?></td>
            <td><?= $row['nombre_cliente'] . ' ' . $row['apellidos_cliente'] ?></td>
            <td><?= $row['nro_documento'] ?></td>
            <td><?= $row['correo_cliente'] ?></td>
            <td><?= $row['telefono_cliente'] ?></td>
            <td class="acciones">
                <a class="btn editar" href="update.php?id=<?= $row['id'] ?>">Editar</a>
                <a class="btn eliminar" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este registro?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
