

<?php
require_once './app/config/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['usuario']; // Obtén el id del usuario desde la sesión

// Consulta para obtener los datos actuales del usuario
$sql = "SELECT usuario FROM t_usuario WHERE id_usuario = :id_usuario";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':id_usuario', $id_usuario);
$stmt->execute();
$usuario_actual = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica si se ha enviado la solicitud de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevo_usuario = $_POST['usuario'];
    $nueva_password = $_POST['password'];

    // Actualiza el usuario en la base de datos
    $sql_update = "UPDATE t_usuario SET usuario = :nuevo_usuario, password = :nueva_password WHERE id_usuario = :id_usuario";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bindParam(':nuevo_usuario', $nuevo_usuario);
    $stmt_update->bindParam(':nueva_password', $nueva_password);
    $stmt_update->bindParam(':id_usuario', $id_usuario);

    if ($stmt_update->execute()) {
        // Devolver respuesta JSON
        echo json_encode(['status' => 'success', 'message' => 'Usuario actualizado correctamente.']);
        session_destroy(); // Destruye la sesión actual
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el usuario.']);
    }
    exit(); // Asegúrate de detener la ejecución después de la respuesta JSON
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="editarUsuario.css">

</style>

</head>
<body>

    <div class="login-container d-flex justify-content-center align-items-center vh-100">
        <form id="frm_login" class="login-form p-4 shadow rounded bg-light">
            <div class="text-center mb-4">
                <i class="fa-solid fa-user-circle fa-3x text-primary"></i>
                <h3 class="mt-3">Editar Información de Usuario</h3>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="usuario" name="usuario" type="text" placeholder="e-mail">
                <label class="text-primary" for="usuario">
                    <i class="fa-solid fa-envelope me-2"></i>Editar Usuario
                </label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="pass" name="pass" type="password" placeholder="password">
                <label class="text-primary" for="pass">
                    <i class="fa-solid fa-lock me-2"></i>Editar Contraseña
                </label>
            </div>
            <div class="d-grid">
                <button type="button" id="editar" class="btn btn-primary btn-block">
                    <i class="fa-solid fa-sign-in-alt me-2"></i> Editar
                </button>
            </div>
        </form>
    </div>
    
    <script src="./public/js/info_usuario.js"></script>
</body>
</html>
