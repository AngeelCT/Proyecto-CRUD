<?php
// Inicia la sesión
session_start();

// Destruye la sesión actual, cerrando la sesión del usuario
session_destroy(); 

// Redirige al usuario a la página de login
header("Location: login.php"); 

// Asegura que el script se detenga después de la redirección
exit;
?>