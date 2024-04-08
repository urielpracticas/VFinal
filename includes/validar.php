<?php
require_once("_db.php"); // Incluir el archivo que contiene la conexión

if(isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'editar_registro':
            editar_registro();
            break;
        case 'eliminar_registro':
            eliminar_registro();
            break;
        case 'acceso_user':
            acceso_user();
            break;
    }
}

function editar_registro() {
    global $conexion; // Accede a la conexión definida en _db.php
    extract($_POST);

    // Preparar la consulta SQL con marcadores de posición (?)
    $consulta = "UPDATE user SET nombre = ?, correo = ?, telefono = ?, password = ? WHERE id = ?";
    
    // Preparar la sentencia SQL
    $stmt = mysqli_prepare($conexion, $consulta);
    
    // Vincular los parámetros a la consulta
    mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $correo, $telefono, $password, $id);
    
    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);
    
    // Cerrar la sentencia
    mysqli_stmt_close($stmt);
    
    // Redirigir a la página de usuarios
    header('Location: ../views/user.php');
}

function eliminar_registro() {
    global $conexion; // Accede a la conexión definida en _db.php
    extract($_POST);
    $id = $_POST['id'];

    // Preparar la consulta SQL con marcadores de posición (?)
    $consulta = "DELETE FROM user WHERE id = ?";
    
    // Preparar la sentencia SQL
    $stmt = mysqli_prepare($conexion, $consulta);
    
    // Vincular los parámetros a la consulta
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);
    
    // Cerrar la sentencia
    mysqli_stmt_close($stmt);
    
    // Redirigir a la página de usuarios
    header('Location: ../views/user.php');
}

function acceso_user() {
    global $conexion; // Accede a la conexión definida en _db.php
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    session_start();
    $_SESSION['nombre'] = $nombre;

    // Preparar la consulta SQL con marcadores de posición (?)
    $consulta = "SELECT * FROM user WHERE nombre=? AND password=?";
    
    // Preparar la sentencia SQL
    $stmt = mysqli_prepare($conexion, $consulta);
    
    // Vincular los parámetros a la consulta
    mysqli_stmt_bind_param($stmt, "ss", $nombre, $password);
    
    // Ejecutar la consulta
    mysqli_stmt_execute($stmt);
    
    // Obtener el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);
    
    // Obtener el número de filas
    $filas = mysqli_num_rows($resultado);
    
    if ($filas) {
        // Si hay filas, redirigir a la página de usuarios
        header('Location: ../views/user.php');
    } else {
        // Si no hay filas, redirigir a la página de inicio de sesión
        header('Location: login.php');
        session_destroy();
    }
}
?>
