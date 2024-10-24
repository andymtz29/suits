<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location: login.php');
    exit; // Añadir exit después de header para detener la ejecución
}
require_once "./app/config/dependencias.php";
require_once "./app/controller/db.php";

// Consulta a la tabla t_producto
$sql = "SELECT * FROM t_producto";
$query = $conn->prepare($sql);
$query->execute();
$productos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <link rel="stylesheet" href="<?= CSS . 'tabla.css'; ?>"> 
    <link rel="stylesheet" href="css/dataTable.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://www.ukbglife.co.uk/wp-content/uploads/2023/03/grocery-store-or-supermarket-with-food-product-shelves-racks-dairy-fruits-and-drinks-for-shopping-in-flat-cartoon-hand-drawn-templates-illustration-vector.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            color: #151515;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            margin: auto;
        }

        .cerrar-sesion, .editar {
            position: absolute;
            top: 10px;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .cerrar-sesion {
            right: 10px;
            background-color: #ff4d4d;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cerrar-sesion:hover {
            background-color: #ff1a1a;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .editar {
            right: 160px;
            background-color: #4CAF50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .editar:hover {
            background-color: #45a049;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .cerrar-sesion i, .editar i {
            margin-right: 8px;
        }
    </style>
</head>
<body>

<h1><i class="fas fa-list"></i> Lista de Productos</h1>

<div class="table-container">
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i>ID</th>
                <th><i class="fas fa-box"></i>Producto</th>
                <th><i class="fas fa-dollar-sign"></i>Precio</th>
                <th><i class="fas fa-layer-group"></i>Cantidad</th>
                <th><i class="fas fa-cog"></i>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['producto']); ?></td>
                    <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                    <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                    <td class="actions">
                        <a href="./app/controller/editar.php?id=<?php echo $producto['id_producto']; ?>" class="edit">
                            <i class="fas fa-edit"></i>Editar
                        </a>
                        <a href="#" class="delete" onclick="eliminar_producto(<?php echo $producto['id_producto']; ?>);">
                            <i class="fas fa-trash-alt"></i>Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="container">
        <a href="./app/controller/agregar.php" class="add-product">
            <i class="fas fa-plus"></i>Agregar Producto
        </a>

        <button class="cerrar-sesion" id="cerrar">
            <i class="fas fa-sign-out-alt"></i>Cerrar Sesión
        </button>

        <a href="./info_usuario.php" class="editar" id="editar">
            <i class="fas fa-user-edit"></i>Editar Usuario
        </a>
    </div>
</div>

<!-- Scripts -->
<script src="./public/js/jquery.js"></script> <!-- jQuery local -->
<script src="./public/js/dataTable.js"></script> <!-- DataTables local -->
<script src="./public/js/cerrar_sesion.js"></script> <!-- Script para cerrar sesión -->
<script src="./public/js/crud.js"></script> <!-- Otros scripts necesarios -->
</body>
</html>
