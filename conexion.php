<?php
// Nombre de la base de datos
$dbname = "proyecto";
// Usuario de la base de datos
$dbuser = "root";
// Host de la base de datos
$dbhost = "localhost";
// Contraseña del usuario de la base de datos
$dbpass = "";

// Establece la conexión con la base de datos utilizando los datos proporcionados
$conexion = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

?>