<?php
// Conectar a la base de datos
require '../controlador/conexion.php';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para obtener los eventos en orden inverso
$sql = "SELECT idEvento, nombreEvento, descripcion, idEncarEvento, fechaIni, fechaFin, lugar, idRegistro, imagen FROM evento ORDER BY idRegistro DESC";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Agregar un contenedor principal para alinear las tarjetas
    echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'>
          <link rel='stylesheet' href='estilos/eventos.css'>";
    echo "<div id='eventos-container'>";

    // Salida de cada fila
    while($row = $result->fetch_assoc()) {
        echo "<a class='tarjeta' href='asistenciaalumno.php?idEvento=" . $row['idEvento'] . "' style='text-decoration: none'>
        <img class='imge' src='data:image/jpeg;base64," . base64_encode($row["imagen"]) . "' alt=''>
        <h3>" . $row["nombreEvento"] . "</h3>
        <p><strong>Fecha:</strong> " . $row["fechaIni"] . "</p> 
      </a>";

    }

    echo "</div>"; // Cierra el contenedor de tarjetas
} else {
    echo "No hay eventos disponibles.";
}

// Cerrar la conexión
$conn->close();
?>