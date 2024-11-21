<?php
// Conectar a la base de datos
require '../controlador/conexion.php';

// Verificar si el id del ensayo está presente
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Crear conexión
    $conn = new mysqli($host, $user, $password, $dbname);

    // Comprobar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Consulta SQL para obtener el ensayo a editar
    $sql = "SELECT * FROM ensayo WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el ensayo existe
    if ($result->num_rows > 0) {
        $ensayo = $result->fetch_assoc();
    } else {
        die("Ensayo no encontrado.");
    }

    // Cerrar la conexión
    $conn->close();
} else {
    die("ID de ensayo no especificado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ensayo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="estilos/nuevoest.css">
</head>
<body>
    <div class="container">
       <!-- Sidebar / Menu Lateral -->
       <div id="sidebar">
            <div class="menu-icon">
                <i class="fas fa-user"></i>
                <p>Docente</p>
            </div>
        </div>
        
        <!-- Contenido principal -->
        <div id="main-content">
            <header>
                <h1 class="title">Editar Ensayo</h1>
                <button id="cerrar-sesion">Cerrar Sesión</button>
            </header>

            <form action="controlador/actualizarensayo.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $ensayo['id']; ?>">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($ensayo['nombre']); ?>" required>

                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($ensayo['descripcion']); ?>" required>

                <label for="encargado">Encargado:</label>
                <input type="text" id="encargado" name="encargado" value="<?php echo htmlspecialchars($ensayo['encargado']); ?>" required>

                <div class="row">
                    <div>
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" value="<?php echo $ensayo['fecha']; ?>" required>
                    </div>
                    <div>
                        <label for="lugar">Lugar:</label>
                        <input type="text" id="lugar" name="lugar" value="<?php echo htmlspecialchars($ensayo['lugar']); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div>
                        <label for="hora_inicio">Hora de inicio:</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo $ensayo['hora_inicio']; ?>" required>
                    </div>
                    <div>
                        <label for="hora_culminacion">Hora de culminación:</label>
                        <input type="time" id="hora_culminacion" name="hora_culminacion" value="<?php echo $ensayo['hora_culminacion']; ?>" required>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" onclick="window.location.href='principal_docente.html'">REGRESAR</button>
                    <button type="submit" class="save-btn">GUARDAR</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
