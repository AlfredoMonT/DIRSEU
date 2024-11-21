<?php
// Conectar a la base de datos
require './controlador/conexion.php';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el id del evento de la URL
if (isset($_GET['idEvento'])) {
    $evento_id = $_GET['idEvento'];
} else {
    die("Evento no encontrado: idEvento no está presente en la URL.");
}

// Consulta para obtener los detalles del evento
$sql_evento = "SELECT * FROM evento WHERE idEvento = ?";
$stmt_evento = $conn->prepare($sql_evento);
$stmt_evento->bind_param("i", $evento_id);
$stmt_evento->execute();
$result_evento = $stmt_evento->get_result();

// Verificar si el evento existe
if ($result_evento->num_rows > 0) {
    $evento = $result_evento->fetch_assoc();
} else {
    die("Evento no encontrado.");
}

// Actualizar evento cuando se envíen los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombreEvento'];
    $descripcion = $_POST['descripcion'];
    $fechaIni = $_POST['fechaIni'];
    $lugar = $_POST['lugar'];

    // Actualizar el evento en la base de datos
    $sql_update = "UPDATE evento SET nombreEvento = ?, descripcion = ?, fechaIni = ?, lugar = ? WHERE idEvento = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $nombre, $descripcion, $fechaIni, $lugar, $evento_id);
    $stmt_update->execute();

    // Redirigir al detalle del evento después de la actualización
    header("Location: asistencia.php?idEvento=" . $evento_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="estilos/editar.css">
</head>
<body>
    <div class="container">
        <h1>Editar Evento</h1>
        <form method="POST" action="">
            <label for="nombreEvento">Nombre del Evento:</label>
            <input type="text" name="nombreEvento" id="nombreEvento" value="<?php echo htmlspecialchars($evento['nombreEvento']); ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required><?php echo htmlspecialchars($evento['descripcion']); ?></textarea>

            <label for="fechaIni">Fecha:</label>
            <input type="date" name="fechaIni" id="fechaIni" value="<?php echo date("Y-m-d", strtotime($evento['fechaIni'])); ?>" required>

            <label for="lugar">Lugar:</label>
            <input type="text" name="lugar" id="lugar" value="<?php echo htmlspecialchars($evento['lugar']); ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
