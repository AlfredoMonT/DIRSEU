<?php
// Conectar a la base de datos
require '../controlador/conexion.php';

// Verificar si se ha recibido el id del ensayo
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Crear conexión
    $conn = new mysqli($host, $user, $password, $dbname);

    // Comprobar conexión
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Consulta SQL para eliminar el ensayo
    $sql = "DELETE FROM ensayo WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // El parámetro debe ser de tipo entero
    $stmt->execute();

    // Verificar si se ha eliminado correctamente
    if ($stmt->affected_rows > 0) {
        // Redirigir a la página donde se muestran los ensayos
        header("Location: ../principal_docente.php"); // O donde quieras redirigir después de eliminar
        exit();
    } else {
        echo "Error al eliminar el ensayo.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "No se ha especificado el id del ensayo.";
}
?>
