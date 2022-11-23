<?php 

//Importar conexión
require 'includes/config/database.php';
$db = conectarDB();

//Crear un email y password
$nombre = "Gustavo Adolfo";
$apellidos = "Paz Maldonado";
$email = "correo@correo.com";
$telefono = "4792048262";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//Query para crear el usuario
$query = "INSERT INTO usuarios (nombre,apellidos,email,telefono,password) VALUES ('${nombre}','${apellidos}','${email}','${telefono}', '${passwordHash}');";

echo $query;
//Agregarlo a la base de datos
mysqli_query($db, $query);

?>