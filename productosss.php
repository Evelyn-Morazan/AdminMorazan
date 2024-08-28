<?php
include 'conexion.php';

$mensaje = ''; // Variable para almacenar el mensaje de éxito o error

// Procesar la entrada del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['descripcion'], $_POST['precio'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $precio = $conn->real_escape_string($_POST['precio']);
    
    $sql_insert = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('$nombre', '$descripcion', '$precio')";
    
    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "<div class='mensaje exito'>Nuevo producto agregado exitosamente.</div>";
    } else {
        $mensaje = "<div class='mensaje error'>Error: " . $conn->error . "</div>";
    }
}

// Mostrar los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <style type="text/css">
        body {
            margin: 20px;
            font-family: Arial, sans-serif;
        }

        h1 {
            font-family: Poor Richard;
            color: #333;
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        .producto, .carrito {
            border: 4px solid #6af8bd;
            padding: 10px;
            margin: 10px 0;
        }

        .producto h2 {
            margin-top: 0;
        }

        button {
            background-color: #6af8bd;
            color: black;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .mensaje {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .mensaje.exito {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .mensaje.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <?php echo $mensaje; ?>

    <h1>Agregar Nuevo Producto</h1>
    <form style="text-align: center;" method="POST">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>
        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" required></textarea><br><br>
        <label for="precio">Precio:</label><br>
        <input type="number" id="precio" name="precio" step="0.01" required><br><br>
        <button type="submit">Agregar Producto</button>
    </form>

    <h1>Productos Disponibles</h1>
    <a href="carrito.php">Ver Carrito</a>
    <div class="productos">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="producto">
                <h2><?php echo $row['nombre']; ?></h2>
                <p><?php echo $row['descripcion']; ?></p>
                <p>Precio: $<?php echo $row['precio']; ?></p>
                <form action="carrito.php" method="POST">
                    <input type="hidden" name="producto_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="agregar">Agregar al Carrito</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>
