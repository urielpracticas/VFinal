<?php

$host = "localhost";
$user = "root"; 
$database = "r_user";
$password = getenv ( 'MYSQL_SECURE_PASSWORD' );

$conexion = mysqli_connect($host, $user, $password, $database);
if(!$conexion){
echo "No se realizo la conexion a la basa de datos, el error fue:".
mysqli_connect_error() ;


}else{echo "Es un exito la coneccion a la bd";}

?>