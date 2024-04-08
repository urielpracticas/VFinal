<?php
require_once("_db.php");

if (isset($_POST['accion'])) {
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
    global $conexion;
    extract($_POST);
    $consulta = "UPDATE user SET nombre = ?, correo = ?, telefono = ?, password = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $correo, $telefono, $password, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Location: ../views/user.php');
}

function eliminar_registro() {
    global $conexion;
    extract($_POST);
    $consulta = "DELETE FROM user WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header('Location: ../views/user.php');
}

function acceso_user() {
    global $conexion;
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    session_start();
    $_SESSION['nombre'] = $nombre;
    $consulta = "SELECT * FROM user WHERE nombre=? AND password=?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "ss", $nombre, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $filas = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($filas) {
        header('Location: ../views/user.php');
    } else {
        header('Location: login.php');
        session_destroy();
    }
}
?>
