<?php
// Definir los parámetros de conexión a la base de datos
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "proyecto";

// Conectar a la base de datos
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("No hay conexión: " . mysqli_connect_error());
}

// Verifica si el formulario fue enviado por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si los campos de usuario o contraseña están vacíos
    if (empty($_POST["txtusuario"]) || empty($_POST["txtpassword"])) {
        // Muestra una alerta si algún campo está vacío y redirige al login
        echo "<script>
                alert('Por favor, completa todos los campos antes de continuar.');
                window.location.href = 'login.html';
              </script>";
        exit;
    }

    // Obtiene los valores del formulario
    $nombre = $_POST["txtusuario"];
    $pass = $_POST["txtpassword"];

    // Realiza la consulta para verificar si el usuario y la contraseña coinciden
    $query = mysqli_query($conn, "SELECT * FROM login WHERE usuario='$nombre' AND password='$pass'");
    $nr = mysqli_num_rows($query);

    // Si se encuentra un registro que coincide
    if ($nr == 1) {
        session_start(); // Inicia la sesión
        $_SESSION["usuario"] = $nombre; // Guarda el usuario en la sesión
        header("Location: index.php"); // Redirige a la página principal
        exit;
    } else {
        // Si las credenciales son incorrectas, muestra una alerta y redirige al login
        echo "<script>
                alert('Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo.');
                window.location.href = 'login.html';
              </script>";
        exit;
    }
} else {
    // Si no se envió el formulario, redirige al login
    header("Location: login.html");
    exit;
}
?>