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

// Obtiene los valores enviados por el formulario de búsqueda (si existen)
$buscar = isset($_GET['buscar']) ? $_GET['buscar'] : ''; // Término de búsqueda
$criterio = isset($_GET['campo']) ? $_GET['campo'] : ''; // Criterio de búsqueda

// Construye la consulta SQL dependiendo de si se realizó o no una búsqueda
if ($buscar && $criterio) {
    // Consulta para buscar según el criterio seleccionado
    $sql = "SELECT * FROM alumnos WHERE $criterio LIKE '%$buscar%'";
} else {
    // Consulta para obtener todos los registros
    $sql = "SELECT * FROM alumnos";
}

// Ejecuta la consulta y guarda el resultado
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Búsqueda de Alumnos</title>
    <!-- Icono de la página -->
    <link rel="icon" href="images/buscar.png" type="image/png">
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
    <h1>Resultados de la Búsqueda</h1>
    <!-- Enlace para volver a la lista principal -->
    <a href="index.php" style="margin-bottom: 20px; display: inline-block;">Volver a la Lista</a>

    <!-- Formulario para realizar la búsqueda -->
    <form method="GET" action="buscar.php" style="margin-bottom: 20px;">
        <!-- Campo para buscar -->
        <select name="campo" style="padding: 12px 20px; margin-right: 8px;">
            <option value="nombre" <?php echo ($criterio == 'nombre' ? 'selected' : ''); ?>>Nombre</option>
            <option value="apellidoP" <?php echo ($criterio == 'apellidoP' ? 'selected' : ''); ?>>Apellido Paterno</option>
            <option value="apellidoM" <?php echo ($criterio == 'apellidoM' ? 'selected' : ''); ?>>Apellido Materno</option>
            <option value="matricula" <?php echo ($criterio == 'matricula' ? 'selected' : ''); ?>>Matrícula</option>
            <option value="carrera" <?php echo ($criterio == 'carrera' ? 'selected' : ''); ?>>Carrera</option>
        </select>
        <!-- Campo para ingresar el término de búsqueda -->
        <input type="text" name="buscar" placeholder="Buscar..." value="<?php echo htmlspecialchars($buscar); ?>" required>
        <!-- Botón para enviar el formulario -->
        <button type="submit">Buscar</button>
    </form>

    <!-- Verifica si hay resultados en la consulta -->
    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <!-- Muestra los resultados en una tabla -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo de Contacto</th>
                    <th>Matrícula</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Recorre los resultados de la consulta -->
                <?php while ($filas = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo $filas['id'] ?></td>
                    <td><?php echo $filas['nombre'] ?></td>
                    <td><?php echo $filas['apellidoP'] ?></td>
                    <td><?php echo $filas['apellidoM'] ?></td>
                    <td><?php echo $filas['correo'] ?></td>
                    <td><?php echo $filas['matricula'] ?></td>
                    <td><?php echo $filas['carrera'] ?></td>
                    <td> 
                        <!-- Enlace para editar el registro -->
                        <?php echo "<a href='editar.php?id=".$filas['id']."' class='editar-btn'><i class='fas fa-edit'></i> Editar</a>"; ?>
                        --
                        <!-- Enlace para eliminar el registro con confirmación -->
                        <?php echo "<a href='eliminar.php?id=".$filas['id']."' class='eliminar-btn' onclick='return confirmar()'><i class='fas fa-trash'></i> Eliminar</a>"; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <!-- Mensaje cuando no hay resultados -->
        <p>No se encontraron resultados para la búsqueda "<?php echo htmlspecialchars($buscar); ?>" en el campo "<?php echo htmlspecialchars($criterio); ?>".</p>
    <?php endif; ?>

    <!-- Cierra la conexión a la base de datos -->
    <?php mysqli_close($conexion); ?>
</body>
</html>