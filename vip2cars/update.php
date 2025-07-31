<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "db.php";

$errores = [];
$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID no válido");
}

// Obtener datos del vehículo
$vehiculo = $conn->query("SELECT * FROM vehiculos WHERE id = $id")->fetch_assoc();
if (!$vehiculo) {
    die("Vehículo no encontrado");
}

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $placa = trim($_POST["placa"]);
    $marca = trim($_POST["marca"]);
    $modelo = trim($_POST["modelo"]);
    $anio = trim($_POST["anio_fabricacion"]);
    $nombre = trim($_POST["nombre_cliente"]);
    $apellidos = trim($_POST["apellidos_cliente"]);
    $documento = trim($_POST["nro_documento"]);
    $correo = trim($_POST["correo_cliente"]);
    $telefono = trim($_POST["telefono_cliente"]);

    // Validaciones
    if (!preg_match('/^[A-Z0-9]{6}$/', $placa)) {
        $errores['placa'] = "La placa debe tener exactamente 6 caracteres alfanuméricos.";
    }
    if (!preg_match('/^\d{4}$/', $anio)) {
        $errores['anio_fabricacion'] = "El año debe ser un número de 4 dígitos.";
    }
    if (!preg_match('/^\d{8}$/', $documento)) {
        $errores['nro_documento'] = "El número de documento debe tener 8 dígitos.";
    }
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo_cliente'] = "El correo no tiene un formato válido.";
    }
    if (!preg_match('/^\d{9}$/', $telefono)) {
        $errores['telefono_cliente'] = "El teléfono debe tener 9 dígitos.";
    }

    if (empty($errores)) {
        $stmt = $conn->prepare("UPDATE vehiculos SET placa=?, marca=?, modelo=?, anio_fabricacion=?, nombre_cliente=?, apellidos_cliente=?, nro_documento=?, correo_cliente=?, telefono_cliente=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $placa, $marca, $modelo, $anio, $nombre, $apellidos, $documento, $correo, $telefono, $id);
        $stmt->execute();
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Vehículo</title>
    <link rel="stylesheet" href="style.css">
    <style>
        input { display: block; margin-bottom: 5px; padding: 5px; }
        .error { color: red; font-size: 13px; margin-bottom: 10px; }
    </style>
</head>
<body>
<h2>Editar Vehículo</h2>
<form method="POST">
    <label>Placa:</label>
    <input name="placa" value="<?= htmlspecialchars($_POST["placa"] ?? $vehiculo["placa"]) ?>">
    <div class="error"><?= $errores["placa"] ?? "" ?></div>

    <label>Marca:</label>
    <input name="marca" value="<?= htmlspecialchars($_POST["marca"] ?? $vehiculo["marca"]) ?>">

    <label>Modelo:</label>
    <input name="modelo" value="<?= htmlspecialchars($_POST["modelo"] ?? $vehiculo["modelo"]) ?>">

    <label>Año de Fabricación:</label>
    <input name="anio_fabricacion" value="<?= htmlspecialchars($_POST["anio_fabricacion"] ?? $vehiculo["anio_fabricacion"]) ?>">
    <div class="error"><?= $errores["anio_fabricacion"] ?? "" ?></div>

    <label>Nombre del Cliente:</label>
    <input name="nombre_cliente" value="<?= htmlspecialchars($_POST["nombre_cliente"] ?? $vehiculo["nombre_cliente"]) ?>">

    <label>Apellidos del Cliente:</label>
    <input name="apellidos_cliente" value="<?= htmlspecialchars($_POST["apellidos_cliente"] ?? $vehiculo["apellidos_cliente"]) ?>">

    <label>Nro. Documento:</label>
    <input name="nro_documento" value="<?= htmlspecialchars($_POST["nro_documento"] ?? $vehiculo["nro_documento"]) ?>">
    <div class="error"><?= $errores["nro_documento"] ?? "" ?></div>

    <label>Correo:</label>
    <input name="correo_cliente" value="<?= htmlspecialchars($_POST["correo_cliente"] ?? $vehiculo["correo_cliente"]) ?>">
    <div class="error"><?= $errores["correo_cliente"] ?? "" ?></div>

    <label>Teléfono:</label>
    <input name="telefono_cliente" value="<?= htmlspecialchars($_POST["telefono_cliente"] ?? $vehiculo["telefono_cliente"]) ?>">
    <div class="error"><?= $errores["telefono_cliente"] ?? "" ?></div>

    <button type="submit">Actualizar</button>
</form>

<a href="index.php">Volver a la lista</a>
</body>
</html>
