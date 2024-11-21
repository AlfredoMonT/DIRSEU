<?php
// Conexión a la base de datos
include 'conexion.php'; // Asegúrate de que este archivo contiene la conexión a tu base de datos

// Consulta para obtener los alumnos
$sql = "SELECT idAlumno, nombreAlumno, apellidoAlumno, correoAlumno, generoAlumno, celularAlumno, idTaller FROM alumno";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos</title>
    <link rel="stylesheet" href="../estilos/listar_alumno.css">
</head>
<body>
    <h1>Lista de Alumnos Registrados</h1>
    <table border="1">
        <tr>
            <th>ID Alumno</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Género</th>
            <th>Celular</th>
            <th>ID Taller</th>
        </tr>
        
        <?php
        // Mostrar resultados de la consulta
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["idAlumno"] . "</td>";
                echo "<td>" . $row["nombreAlumno"] . "</td>";
                echo "<td>" . $row["apellidoAlumno"] . "</td>";
                echo "<td>" . $row["correoAlumno"] . "</td>";
                echo "<td>" . $row["generoAlumno"] . "</td>";
                echo "<td>" . $row["celularAlumno"] . "</td>";
                echo "<td>" . $row["idTaller"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay alumnos registrados</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
