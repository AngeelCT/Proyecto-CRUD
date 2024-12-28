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

<?php
// Incluye el archivo de conexión a la base de datos
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDITAR</title>
    <!-- Icono de la página -->
    <link rel="icon" href="images/editar.png" type="image/png">
    <!-- Estilos CSS -->
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <!-- Font Awesome para íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php 
        // Verifica si se ha enviado el formulario de actualización
        if(isset($_POST['enviar'])){
            // Si el formulario se ha enviado, obtenemos los datos
            $id = $_POST['id'];  // ID del alumno a actualizar
            $nombre = $_POST['nombre'];
            $apellidoP = $_POST['apellidoP'];
            $apellidoM = $_POST['apellidoM'];
            $correo = $_POST['correo'];
            $matricula = $_POST['matricula'];
            $carrera = $_POST['carrera'];

            // Consulta SQL para actualizar los datos del alumno
            $sql = "UPDATE alumnos SET nombre='".$nombre."', apellidoP='".$apellidoP."', apellidoM='".$apellidoM."', correo='".$correo."', matricula='".$matricula."', carrera='".$carrera."' WHERE id='".$id."'";
            // Ejecuta la consulta SQL
            $resultado = mysqli_query($conexion, $sql);

            // Verifica si la actualización fue exitosa
            if($resultado){
                // Si fue exitosa, muestra un mensaje y redirige al listado de alumnos
                echo "<script languaje='JavaScript'>alert('DATOS ACTUALIZADOS'); location.assign('index.php');</script>";
            } else {
                // Si hubo un error en la actualización, muestra un mensaje de error
                echo "<script languaje='JavaScript'>alert('DATOS NO ACTUALIZADOS'); location.assign('index.php');</script>";
            }
            // Cierra la conexión a la base de datos
            mysqli_close($conexion);  
        } else {
            // Si no se ha enviado el formulario, se obtiene el ID del alumno 
            $id = $_GET['id'];
            // Consulta SQL para obtener los datos del alumno que se quiere editar
            $sql = "SELECT * FROM alumnos WHERE id='".$id."'";
            // Ejecuta la consulta y obtiene el resultado
            $resultado = mysqli_query($conexion, $sql);

            // Obtiene los datos del alumno
            $fila = mysqli_fetch_assoc($resultado);
            // Valores obtenidos a las variables
            $nombre = $fila["nombre"];
            $apellidoP = $fila["apellidoP"];
            $apellidoM = $fila["apellidoM"];
            $correo = $fila["correo"];
            $matricula = $fila["matricula"];
            $carrera = $fila["carrera"];
            // Cierra la conexión a la base de datos
            mysqli_close($conexion);
        }
    ?>
    
    <!-- Formulario para editar los datos del alumno -->
    <h1>EDITAR ALUMNO</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <!-- Campo para el nombre del alumno -->
        <label>NOMBRE:</label>
        <input type="text" name="nombre" value="<?php echo $nombre;?>"> <br>

        <!-- Campo para el apellido paterno del alumno -->
        <label>APELLIDO PATERNO:</label>
        <input type="text" name="apellidoP" value="<?php echo $apellidoP;?>"> <br>

        <!-- Campo para el apellido materno del alumno -->
        <label>APELLIDO MATERNO:</label>
        <input type="text" name="apellidoM" value="<?php echo $apellidoM;?>"> <br>

        <!-- Campo para el correo del alumno -->
        <label>CORREO:</label>
        <input type="text" name="correo" value="<?php echo $correo;?>"> <br>

        <!-- Campo para la matrícula del alumno -->
        <label>MATRICULA:</label>
        <input type="text" name="matricula" value="<?php echo $matricula;?>"> <br>

        <!-- Campo para la carrera del alumno -->
        <label>CARRERA:</label>
        <input type="text" name="carrera" value="<?php echo $carrera;?>"> <br>

        <!-- Campo oculto para enviar el ID del alumno -->
        <input type="hidden" name="id" value="<?php echo $id;?>">

        <!-- Botón para enviar el formulario -->
        <button type="submit" name="enviar" class="actualizar-btn">
            <i class="fas fa-check-circle"></i> ACTUALIZAR
        </button>
        <!-- Enlace para regresar al listado de alumnos -->
        <a href="index.php" class="regresar-btn"><i class="fas fa-arrow-left"></i> REGRESAR</a>
    </form>
</body>
</html>