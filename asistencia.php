<?php
// Conectar a la base de datos
require './controlador/conexion.php';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener el id del evento de la URL (asegúrate de que se pase correctamente)
if (isset($_GET['idEvento'])) {
    $evento_id = $_GET['idEvento'];
} else {
    die("Evento no encontrado: idEvento no está presente en la URL.");
}

// Consulta para obtener los detalles del evento
$sql_evento = "SELECT * FROM evento WHERE idEvento = ?";
$stmt_evento = $conn->prepare($sql_evento);

// Verificar si la preparación de la consulta fue exitosa
if (!$stmt_evento) {
    die("Error al preparar la consulta: " . $conn->error);
}

// Enlazar el parámetro y ejecutar la consulta
$stmt_evento->bind_param("i", $evento_id);
$stmt_evento->execute();
$result_evento = $stmt_evento->get_result();

// Verificar si el evento existe
if ($result_evento->num_rows > 0) {
    $evento = $result_evento->fetch_assoc();
} else {
    die("Evento no encontrado: No se encontró un evento con idEvento = " . htmlspecialchars($evento_id));
}

// Si se envió la solicitud de eliminar evento
if (isset($_GET['eliminar']) && $_GET['eliminar'] == '1') {
    // Eliminar el evento de la base de datos
    $sql_delete_evento = "DELETE FROM evento WHERE idEvento = ?";
    $stmt_delete_evento = $conn->prepare($sql_delete_evento);
    $stmt_delete_evento->bind_param("i", $evento_id);
    $stmt_delete_evento->execute();

    // Redirigir a la página principal del docente
    header("Location: principal_docente.html");
    exit();
}

// Consulta para obtener los alumnos asociados al evento
$sql_alumnos = "SELECT * FROM alumno WHERE idAlumno = ?";
$stmt_alumnos = $conn->prepare($sql_alumnos);

// Verificar si la preparación de la consulta para alumnos fue exitosa
if (!$stmt_alumnos) {
    die("Error al preparar la consulta de alumnos: " . $conn->error);
}

// Enlazar el parámetro y ejecutar la consulta de alumnos
$stmt_alumnos->bind_param("i", $evento_id);
$stmt_alumnos->execute();
$result_alumnos = $stmt_alumnos->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia - <?php echo htmlspecialchars($evento['nombreEvento']); ?></title>
    <link rel="stylesheet" href="estilos/asistencia.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="profile">
                <div class="icon"></div>
                <p>Docente</p>
            </div>
            <button class="save-button">Guardar</button>
            <button class="regresar" onclick="window.location.href='principal_docente.html'">Regresar a inicio</button>
        </div>

        <!-- Main content -->
        <main>
            <div class="event-details">
                <h1><?php echo htmlspecialchars($evento['nombreEvento']); ?></h1>
                <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                <p><strong>Día:</strong> <?php echo date("l, d F Y", strtotime($evento['fechaIni'])); ?></p>
                <p><strong>Lugar:</strong> <?php echo htmlspecialchars($evento['lugar']); ?></p>
                <button id="registrar_alumno">Inscribir Alumnos <br> al evento</button>
                <button id="editar_evento" onclick="window.location.href='editar.php?idEvento=<?php echo $evento['idEvento']; ?>'">Editar Evento</button>
                <button id="eliminar_evento" onclick="confirmarEliminar()">Eliminar Evento</button>
            </div>

            <!-- Attendance -->
            <div class="attendance">
                <h2>Asistencia</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Apellidos</th>
                            <th>Nombres</th>
                            <th>Código</th>
                            <th>Observación</th>
                            <th>Operación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mostrar los alumnos
                        $nro = 1;
                        while ($alumno = $result_alumnos->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $nro++ . "</td>";
                            echo "<td>" . htmlspecialchars($alumno['apellidos']) . "</td>";
                            echo "<td>" . htmlspecialchars($alumno['nombres']) . "</td>";
                            echo "<td>" . htmlspecialchars($alumno['codigo']) . "</td>";
                            echo "<td><input type='text'></td>";
                            echo "<td>";
                            echo "<button class='asistio' onclick='registrarAsistencia(" . $alumno['idAlumno'] . ", true)'>ASISTIO</button>";
                            echo "<button class='no-asistio' onclick='registrarAsistencia(" . $alumno['idAlumno'] . ", false)'>NO ASISTIO</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Función para confirmar la eliminación
        function confirmarEliminar() {
            if (confirm("¿Estás seguro de que deseas eliminar este evento? Esta acción no se puede deshacer.")) {
                // Si el usuario confirma, redirigimos a la página con el parámetro 'eliminar'
                window.location.href = "?idEvento=<?php echo $evento['idEvento']; ?>&eliminar=1";
            }
        }

        // Función para registrar asistencia (por ejemplo, mediante AJAX)
        function registrarAsistencia(idAlumno, asistio) {
            // Enviar solicitud AJAX para registrar la asistencia
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "registrar_asistencia.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Asistencia registrada.");
                }
            };

            // Enviar los datos de la asistencia
            xhr.send("idAlumno=" + idAlumno + "&asistio=" + asistio);
        }
    </script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
