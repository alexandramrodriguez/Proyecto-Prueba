<?php
include "db.php";

$errores = [];
$datos = [
    'placa' => '',
    'marca' => '',
    'modelo' => '',
    'anio_fabricacion' => '',
    'nombre_cliente' => '',
    'apellidos_cliente' => '',
    'nro_documento' => '',
    'correo_cliente' => '',
    'telefono_cliente' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($datos as $campo => &$valor) {
        $valor = trim($_POST[$campo] ?? '');
    }

    // Validaciones
    if (empty($datos['placa'])) $errores['placa'] = "La placa es obligatoria.";
    if (empty($datos['marca'])) $errores['marca'] = "La marca es obligatoria.";
    if (empty($datos['modelo'])) $errores['modelo'] = "El modelo es obligatorio.";
    if (!preg_match('/^\d{4}$/', $datos['anio_fabricacion'])) $errores['anio_fabricacion'] = "Año inválido (formato: 4 dígitos).";
    if (empty($datos['nombre_cliente'])) $errores['nombre_cliente'] = "El nombre es obligatorio.";
    if (empty($datos['apellidos_cliente'])) $errores['apellidos_cliente'] = "Los apellidos son obligatorios.";
    if (!preg_match('/^\d{8}$/', $datos['nro_documento'])) $errores['nro_documento'] = "El número de documento debe tener 8 dígitos.";
    if (!filter_var($datos['correo_cliente'], FILTER_VALIDATE_EMAIL)) $errores['correo_cliente'] = "Correo electrónico inválido.";
    if (!preg_match('/^\d{9}$/', $datos['telefono_cliente'])) $errores['telefono_cliente'] = "El teléfono debe tener 9 dígitos.";

    // Si no hay errores, insertar en la base de datos
    if (empty($errores)) {
        $stmt = $conn->prepare("INSERT INTO vehiculos (placa, marca, modelo, anio_fabricacion, nombre_cliente, apellidos_cliente, nro_documento, correo_cliente, telefono_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", ...array_values($datos));
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $errores['general'] = "Error al registrar: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Vehículo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Registrar Vehículo</h2>

<form method="POST" class="formulario">
    <label>Placa:</label>
    <input name="placa" value="<?= htmlspecialchars($_POST["placa"] ?? "") ?>">
    <div class="error"><?= $errores["placa"] ?? "" ?></div>

    <label>Marca:</label>
    <input name="marca" value="<?= htmlspecialchars($_POST["marca"] ?? "") ?>">

    <label>Modelo:</label>
    <input name="modelo" value="<?= htmlspecialchars($_POST["modelo"] ?? "") ?>">

    <label>Año de Fabricación:</label>
    <input name="anio_fabricacion" value="<?= htmlspecialchars($_POST["anio_fabricacion"] ?? "") ?>">
    <div class="error"><?= $errores["anio_fabricacion"] ?? "" ?></div>

    <label>Nombre del Cliente:</label>
    <input name="nombre_cliente" value="<?= htmlspecialchars($_POST["nombre_cliente"] ?? "") ?>">

    <label>Apellidos del Cliente:</label>
    <input name="apellidos_cliente" value="<?= htmlspecialchars($_POST["apellidos_cliente"] ?? "") ?>">

    <label>Nro. Documento:</label>
    <input name="nro_documento" value="<?= htmlspecialchars($_POST["nro_documento"] ?? "") ?>">
    <div class="error"><?= $errores["nro_documento"] ?? "" ?></div>

    <label>Correo:</label>
    <input name="correo_cliente" value="<?= htmlspecialchars($_POST["correo_cliente"] ?? "") ?>">
    <div class="error"><?= $errores["correo_cliente"] ?? "" ?></div>

    <label>Teléfono:</label>
    <input name="telefono_cliente" value="<?= htmlspecialchars($_POST["telefono_cliente"] ?? "") ?>">
    <div class="error"><?= $errores["telefono_cliente"] ?? "" ?></div>

    <button type="submit" class="btn-amarillo">Registrar</button>
    <a href="index.php" class="btn volver">Volver</a>
</form>

</body>
</html>
