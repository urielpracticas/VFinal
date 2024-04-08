<?php
require_once("../includes/_db.php"); // Incluir el archivo que contiene la conexión

session_start();
error_reporting(0);
$varsesion = $_SESSION['nombre'];

if ($varsesion == null || $varsesion == '') {
    header("Location: ../includes/login.php");
    die();
}

// Obtener el ID de usuario de manera segura
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Preparar la consulta SQL utilizando una consulta preparada
$consulta = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($conexion, $consulta);

// Vincular el parámetro de ID a la consulta preparada
mysqli_stmt_bind_param($stmt, "i", $id);

// Ejecutar la consulta preparada
mysqli_stmt_execute($stmt);

// Obtener el resultado de la consulta
$resultado = mysqli_stmt_get_result($stmt);

// Obtener los datos del usuario
$usuario = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <link rel="stylesheet" href="../css/style-edit.css">
</head>

<body id="page-top">

<form action="../includes/_functions.php" method="POST">
<div id="login">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <br>
                    <br>
                    <h3 class="text-center">Editar usuario</h3>
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre *</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Correo:</label><br>
                        <input type="email" name="correo" id="correo" class="form-control" placeholder="" value="<?php echo htmlspecialchars($usuario['correo']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="form-label">Telefono *</label>
                        <input type="tel" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label><br>
                        <input type="password" name="password" id="password" class="form-control" value="<?php echo htmlspecialchars($usuario['password']); ?>" required>
                        <input type="hidden" name="accion" value="editar_registro">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    </div>
                    <br>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Editar</button>
                        <a href="user.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</body>
</html>
