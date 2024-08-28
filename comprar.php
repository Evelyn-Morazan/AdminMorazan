<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    // Insertar los productos comprados en la tabla 'compras'
    if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
        $carrito = $_SESSION['carrito'];
        foreach ($carrito as $producto_id) {
            $sql = "INSERT INTO compras (producto_id, cantidad) VALUES (?, 1)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $producto_id);
            $stmt->execute();
        }
    }

    // Vaciar el carrito
    unset($_SESSION['carrito']);

    // Mensaje de éxito
    $mensaje = "¡Compra realizada con éxito!";
} else {
    // Si alguien accede directamente a comprar.php sin pasar por el formulario
    header("Location: productosss.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra Completada</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <style type="text/css">
        /* Estilo general */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    color: #333;
}

h1 {
    color: #4CAF50;
    font-size: 2em;
    margin-bottom: 20px;
    text-align: center;
}

/* Estilo para los enlaces */
a {
    display: inline-block;
    text-decoration: none;
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    margin: 10px 0;
    border-radius: 5px;
    font-size: 1em;
    text-align: center;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

a:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

/* Separación entre los enlaces */
a + br {
    margin-bottom: 15px;
}

/* Ajuste para dispositivos móviles */
@media (max-width: 768px) {
    body {
        padding: 10px;
    }

    h1 {
        font-size: 1.8em;
    }

    a {
        font-size: 0.9em;
        padding: 10px 18px;
    }
}

    </style>
    <h1><?php echo $mensaje; ?></h1>
    <a href="productosss.php">Volver a la tienda</a>
    <br>
  
    <a href="ver_compras.php">Ver Productos Comprados</a>
</body>
</html>
