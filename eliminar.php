<?php
// Inicia la sesión para la autenticación del usuario
session_start();

// Verifica si no existe una sesión activa para el usuario
if (!isset($_SESSION["usuario"])) {
    // Si el usuario no está autenticado redirige al login
    header("Location: login.php");
    exit(); // Finaliza la ejecución del script
}
?>

<?php
// Obtiene el ID del alumno a eliminar desde la URL (parámetro GET)
$id = $_GET['id'];

// Incluye el archivo de conexión a la base de datos
include("conexion.php");

// Consulta SQL para eliminar el alumno con el ID especificado
$sql = "DELETE FROM alumnos WHERE id='" . $id . "'";

// Ejecuta la consulta SQL
$resultado = mysqli_query($conexion, $sql);

// Verifica si la operación fue exitosa
if ($resultado) {
    // Si la eliminación fue exitosa, muestra un mensaje y redirige al listado de alumnos
    echo "<script languaje='JavaScript'>alert('DATOS BORRADOS EXITOSAMENTE'); location.assign('index.php');</script>";
} else {
    // Si hubo un error al eliminar, muestra un mensaje de error
    echo "<script languaje='JavaScript'>alert('DATOS NO BORRADOS EXITOSAMENTE'); location.assign('index.php');</script>";   
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>