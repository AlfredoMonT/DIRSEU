<?php 
// Configuración de conexión a la base de datos
require '../controlador/conexion.php';

try {
    // Crear una conexión con PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger los datos del formulario
        $nombreEvento = $_POST['nombreEvento'];
        $descripcion = $_POST['descripcion']; // Nuevo campo de descripción
        $idEncarEvento = $_POST['idEncarEvento'];
        $fechaIni = $_POST['fechaIni'];
        $fechaFin = $_POST['fechaFin'];
        $lugar = $_POST['lugar'];

        // Si se ha subido una imagen, procesarla
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $imagen = file_get_contents($_FILES['imagen']['tmp_name']); 

            // Validar que el archivo sea una imagen
            $mimeType = mime_content_type($_FILES['imagen']['tmp_name']);
            if (strpos($mimeType, 'image') !== false) {
                // Preparar la consulta SQL para insertar el evento con la imagen y descripción
                $sql = "INSERT INTO evento (nombreEvento, descripcion, idEncarEvento, fechaIni, fechaFin, lugar, imagen)
                        VALUES (:nombreEvento, :descripcion, :idEncarEvento, :fechaIni, :fechaFin, :lugar, :imagen)";
                
                // Preparar la consulta
                $stmt = $conn->prepare($sql);

                // Enlazar los parámetros con los valores del formulario
                $stmt->bindParam(':nombreEvento', $nombreEvento);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':idEncarEvento', $idEncarEvento);
                $stmt->bindParam(':fechaIni', $fechaIni);
                $stmt->bindParam(':fechaFin', $fechaFin);
                $stmt->bindParam(':lugar', $lugar);
                $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Redirigir a la página principal_docete.html después de la inserción exitosa
                    header("Location: ../principal_docente.html");
                } else {
                    echo "Error al guardar el evento: " . implode(", ", $stmt->errorInfo());
                }
            } else {
                echo "El archivo no es una imagen válida.";
            }
        } else {
            // Insertar sin la imagen
            $sql = "INSERT INTO evento (nombreEvento, descripcion, idEncarEvento, fechaIni, fechaFin, lugar)
                    VALUES (:nombreEvento, :descripcion, :idEncarEvento, :fechaIni, :fechaFin, :lugar)";
            
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':nombreEvento', $nombreEvento);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':idEncarEvento', $idEncarEvento);
            $stmt->bindParam(':fechaIni', $fechaIni);
            $stmt->bindParam(':fechaFin', $fechaFin);
            $stmt->bindParam(':lugar', $lugar);

            if ($stmt->execute()) {
                // Redirigir a la página principal_docete.html después de la inserción exitosa
                header('Location: ../principal_docente.html');
            } else {
                echo "Error al guardar el evento: " . implode(", ", $stmt->errorInfo());
            }
        }
    }
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
