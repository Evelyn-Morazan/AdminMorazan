<?php
include 'conexion.php';

// Manejar la eliminación de un registro
if (isset($_POST['eliminar'])) {
    $idCompra = $_POST['id_compra'];
    $deleteSql = "DELETE FROM compras WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $idCompra);
    $stmt->execute();
    echo "<script>alert('Compra eliminada exitosamente.');</script>";
}

// Manejar la modificación de un registro
if (isset($_POST['modificar'])) {
    $idCompra = $_POST['id_compra'];
    $cantidad = $_POST['cantidad'];
    $updateSql = "UPDATE compras SET cantidad = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $cantidad, $idCompra);
    $stmt->execute();
    echo "<script>alert('Compra modificada exitosamente.');</script>";
}

$sql = "SELECT c.id, p.nombre, p.descripcion, p.precio, c.cantidad, c.fecha_compra
        FROM compras c
        JOIN productos p ON c.producto_id = p.id
        ORDER BY c.fecha_compra DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos Comprados</title>
    <style type="text/css">
        /* Estilo general */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        /* Estilo para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead {
            background-color: #6af8bd;
            color: black;
        }

        thead th {
            padding: 10px;
            text-align: left;
            font-size: 16px;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #e0f7fa;
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        /* Estilo para enlaces */
        button {
            display: inline-block;
            text-decoration: none;
            background-color: #009688;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #6af8bd;
        }

        /* Ajuste para dispositivos móviles */
        @media (max-width: 768px) {
            table, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 15px;
                border-bottom: 2px solid #6af8bd;
            }

            td {
                text-align: right;
                padding-left: 50%;
            }
        }
    </style>
    <script>
        function updatePrice(price, input) {
            const quantity = input.value;
            const total = price * quantity;
            const totalCell = input.closest('tr').querySelector('.total-price');
            totalCell.textContent = '$' + total.toFixed(2);
        }
    </script>
</head>
<body>
    <h1>Productos Comprados</h1>
    <table>
        <thead>
            <tr>
                <th>ID Compra</th>
                <th>Producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Precio Total</th> <!-- Nueva columna para el precio total -->
                <th>Fecha de Compra</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td>$<?php echo $row['precio']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_compra" value="<?php echo $row['id']; ?>">
                            <input type="number" name="cantidad" value="<?php echo $row['cantidad']; ?>" min="1" required
                                   oninput="updatePrice(<?php echo $row['precio']; ?>, this)">
                            <button type="submit" name="modificar">Modificar</button>
                        </form>
                    </td>
                    <td class="total-price">$<?php echo $row['precio'] * $row['cantidad']; ?></td> <!-- Muestra el precio total -->
                    <td><?php echo $row['fecha_compra']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id_compra" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="productosss.php">Volver a la tienda</a>
</body>
</html>

