<?php
// Conectar a la base de datos
require '../controlador/conexion.php';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta SQL para obtener los ensayos en orden inverso, incluyendo el campo 'id'
$sql = "SELECT id, nombre, fecha, descripcion FROM ensayo ORDER BY id DESC";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    // Agrega un contenedor principal para alinear las tarjetas
    echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'>
          <link rel='stylesheet' href='estilos/eventos.css'>";
    echo "<div id='ensayos-container'>";

    // Salida de cada fila  
    while($row = $result->fetch_assoc()) {
        echo " <div class='tarjeta' style='text-align: center'>
                <img style='width: 180px' src='../dirseu/imagenes/uac.png' alt='Imagen de ensayo'>
                <h3>" . $row["nombre"] . "</h3>
                <p><strong>Fecha:</strong> " . $row["fecha"] . "</p>
                <button onclick='window.location.href=\"asistenciaalumno.php\"'>Más información</button>

            </div>";
    }

    echo "</div>"; // Cierra el contenedor de tarjetas
} else {
    echo "No hay ensayos disponibles.";
}

// Cerrar la conexión
$conn->close();
?>
