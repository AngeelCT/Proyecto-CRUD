<?php
session_start();
// Verificamos si el usuario está autenticado, si no lo se redorige a la página de login
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php"); // Redirige a login si no está autenticado
    exit();
}
?>
<?php
include("conexion.php"); // Incluimos el archivo de conexión a la base de datos

// Consulta para contar el total de registros en la tabla "alumnos"
$sql_count = "SELECT COUNT(*) as total FROM alumnos";
$result_count = mysqli_query($conexion, $sql_count);
$count_data = mysqli_fetch_assoc($result_count);
$total_alumnos = $count_data['total']; // Guardamos el total de alumnos

// Consulta para obtener todos los registros de la tabla 
$sql = "SELECT * FROM alumnos";
$resultado = mysqli_query($conexion, $sql);
?>

<html>
    <head>
        <title>LISTA DE ALUMNOS</title>
        <link rel="icon" href="images/tesco.jpg" type="image/png"> <!-- Icono de la página -->
        <script type="text/javascript">
            // Función para confirmar si el usuario está seguro antes de eliminar
            function confirmar (){
                return confirm ('SEGURO? SE ELIMINARAN LOS DATOS');
            }
        </script>
        <!-- Importando iconos y estilos externos -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>
    <body>
        <h1>LISTA DE ALUMNOS (<?php echo $total_alumnos; ?>)</h1> <!-- Muestra el total de alumnos -->
        
        <!-- Enlace para cerrar sesión -->
        <a href="logout.php" class="cerrar-sesion">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>

        <!-- Botón para agregar un nuevo alumno -->
        <div class="boton-nuevo">
            <a href="agregar.php" class="nuevo-alumno">
                <i class="fas fa-plus"></i> Nuevo Alumno
            </a>
        </div> 

        <!-- Formulario de búsqueda -->
        <form method="GET" action="buscar.php" style="margin-bottom: 20px;">
            <!-- Campo de texto para buscar -->
            <input type="text" name="buscar" placeholder="Buscar..." value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">
        
            <!-- Desplegable para elegir el campo por el cual buscar -->
            <select name="campo" style="padding: 12px 20px; margin: 8px 0;">
                <option value="nombre" <?php echo (isset($_GET['campo']) && $_GET['campo'] == 'nombre') ? 'selected' : ''; ?>>Nombre</option>
                <option value="apellidoP" <?php echo (isset($_GET['campo']) && $_GET['campo'] == 'apellidoP') ? 'selected' : ''; ?>>Apellido Paterno</option>
                <option value="apellidoM" <?php echo (isset($_GET['campo']) && $_GET['campo'] == 'apellidoM') ? 'selected' : ''; ?>>Apellido Materno</option>
                <option value="matricula" <?php echo (isset($_GET['campo']) && $_GET['campo'] == 'matricula') ? 'selected' : ''; ?>>Matrícula</option>
                <option value="carrera" <?php echo (isset($_GET['campo']) && $_GET['campo'] == 'carrera') ? 'selected' : ''; ?>>Carrera</option>
            </select>
        
            <!-- Botón para enviar la búsqueda -->
            <button type="submit">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>

        <!-- Tabla para mostrar los alumnos -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo de Contacto</th>
                    <th>Matricula</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostramos los datos de cada alumno
                while($filas=mysqli_fetch_assoc($resultado)){
                ?>
                <tr>
                    <td><?php echo $filas['id']?></td>
                    <td><?php echo $filas['nombre']?></td>
                    <td><?php echo $filas['apellidoP']?></td>
                    <td><?php echo $filas['apellidoM']?></td>
                    <td><?php echo $filas['correo']?></td>
                    <td><?php echo $filas['matricula']?></td>
                    <td><?php echo $filas['carrera']?></td>
                    <td> 
                        <!-- Enlace para editar los datos del alumno -->
                        <?php echo "<a href='editar.php?id=".$filas['id']."' class='editar-btn'><i class='fas fa-edit'></i> Editar</a>"; ?>
                        --
                        <!-- Enlace para eliminar al alumno -->
                        <?php echo "<a href='eliminar.php?id=".$filas['id']."' class='eliminar-btn' onclick='return confirmar()'><i class='fas fa-trash'></i> Eliminar</a>"; ?>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
            mysqli_close($conexion); // Cerramos la conexión a la base de datos
        ?>
    </body>
</html>