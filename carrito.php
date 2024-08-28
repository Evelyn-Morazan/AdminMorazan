<?php
session_start();
include 'conexion.php';

if (isset($_POST['agregar'])) {
    $producto_id = $_POST['producto_id'];
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    $_SESSION['carrito'][] = $producto_id;
}

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

if (!empty($carrito)) {
    $ids = implode(',', $carrito);
    $sql = "SELECT * FROM productos WHERE id IN ($ids)";
    $result = $conn->query($sql);
} else {
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <style type="text/css">
         body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

h1 {
       font-family:poor richard;
    color: #333;
    text-align: center;
}

a {
    text-decoration: none;
    color: #007BFF;
}

.producto, .carrito {
       font-family: Arial, sans-serif;
    border: 4px solid #6af8bd;
    padding: 10px;
    margin: 10px 0;
}
.producto h2 {
    margin-top: 0;
}

button {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}
    </style>
    <h1>Carrito de Compras</h1>
    <a href="productosss.php">Volver a Productos</a>
    <div class="carrito">
        <?php if ($result && $result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="producto">
                    <h2><?php echo $row['nombre']; ?></h2>
                    <p><?php echo $row['descripcion']; ?></p>
                    <p>Precio: $<?php echo $row['precio']; ?></p>
                </div>
            <?php } ?>
            <form action="comprar.php" method="POST">
                <button type="submit" name="comprar">Comprar</button>
            </form>
        <?php } else { ?>
            <p>Tu carrito está vacío.</p>
        <?php } ?>
    </div>
</body>
</html>
