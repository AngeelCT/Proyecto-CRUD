<?php
// Inicia la sesión para manejar la autenticación del usuario
session_start();

// Verifica si no existe una sesión activa para el usuario
if (!isset($_SESSION["usuario"])) {
    // Redirige al usuario a la página de login si no está autenticado
    header("Location: login.php");
    exit(); // Finaliza la ejecución del script
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGREGAR</title>
    <!-- Icono de la página -->
    <link rel="icon" href="images/agregar.jpg" type="image/png">
    <!-- Enlace al archivo de estilos CSS -->
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <!-- Enlace al paquete de iconos Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php
    // Verifica si se ha enviado el formulario
    if (isset($_POST['enviar'])) {
        // Obtiene los datos del formulario
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM'];
        $correo = $_POST['correo'];
        $matricula = $_POST['matricula'];
        $carrera = $_POST['carrera'];

        // Incluye el archivo de conexión a la base de datos
        include("conexion.php");

        // Consulta SQL para insertar los datos
        $sql = "INSERT INTO alumnos (nombre, apellidoP, apellidoM, correo, matricula, carrera) 
                VALUES ('" . $nombre . "', '" . $apellidoP . "', '" . $apellidoM . "', '" . $correo . "', '" . $matricula . "', '" . $carrera . "')";
        
        // Ejecuta la consulta y guarda el resultado
        $resultado = mysqli_query($conexion, $sql);

        // Verifica si la consulta fue exitosa
        if ($resultado) {
            // Muestra un mensaje de éxito y redirige a la página principal
            echo "<script language='JavaScript'>alert('DATOS INGRESADOS CORRECTAMENTE');location.assign('index.php')</script>";
        } else {
            // Muestra un mensaje de error y redirige a la página principal
            echo "<script language='JavaScript'>alert('DATOS NO INGRESADOS');location.assign('index.php')</script>";
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
    } else {
    ?>
    <!-- Muestra el formulario si no se ha enviado -->
    <h1>AGREGAR ALUMNOS</h1>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <!-- Campo para ingresar el nombre -->
        <label>NOMBRE:</label>
        <input type="text" name="nombre"><br>
        <!-- Campo para ingresar el apellido paterno -->
        <label>APELLIDO PATERNO:</label>
        <input type="text" name="apellidoP"><br>
        <!-- Campo para ingresar el apellido materno -->
        <label>APELLIDO MATERNO:</label>
        <input type="text" name="apellidoM"><br>
        <!-- Campo para ingresar el correo -->
        <label>CORREO:</label>
        <input type="text" name="correo"><br>
        <!-- Campo para ingresar la matrícula -->
        <label>MATRICULA:</label>
        <input type="text" name="matricula"><br>
        <!-- Campo para ingresar la carrera -->
        <label>CARRERA:</label>
        <input type="text" name="carrera"><br>
        <!-- Botón para enviar el formulario -->
        <button type="submit" name="enviar" class="agregar-btn">
            <i class="fas fa-user-plus"></i> AGREGAR
        </button>
        <!-- Enlace para regresar a la página principal -->
        <a href="index.php" class="regresar-btn"><i class="fas fa-arrow-left"></i> REGRESAR</a>
    </form>
    <?php
    }
    ?>
</body>
</html>