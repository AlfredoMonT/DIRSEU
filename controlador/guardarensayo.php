<?php
// Configuración de conexión a la base de datos
require '../controlador/conexion.php';

try {
    // Crear una conexión con PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa"; // Mensaje de depuración

    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger los datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $encargado = $_POST['encargado'];
        $fecha = $_POST['fecha'];
        $lugar = $_POST['lugar'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_culminacion = $_POST['hora_culminacion'];

        // Depuración de los datos recibidos
        print_r($_POST);

        // Si se ha subido una imagen, procesarla
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            echo "Archivo subido correctamente.";  // Depuración

            $imagen = file_get_contents($_FILES['imagen']['tmp_name']); // Obtener los datos binarios de la imagen

            // Validar que el archivo sea una imagen
            $mimeType = mime_content_type($_FILES['imagen']['tmp_name']);
            if (strpos($mimeType, 'image') !== false) {
                // Preparar la consulta SQL para insertar el evento con la imagen
                $sql = "INSERT INTO ensayo (id, nombre, descripcion, encargado, fecha, lugar, hora_inicio, hora_culminacion)
                        VALUES (:nombre, :descripcion, :encargado, :fecha, :lugar, :hora_inicio, :hora_culminacion)";
                
                // Preparar la consulta
                $stmt = $conn->prepare($sql);

                // Enlazar los parámetros con los valores del formulario}
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':encargado', $encargado);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':lugar', $lugar);
                $stmt->bindParam(':hora_inicio', $hora_inicio);
                $stmt->bindParam(':hora_culminacion', $hora_culminacion);
                $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB); // Usamos PDO::PARAM_LOB para datos binarios

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "Ensayo guardado exitosamente.";
                } else {
                    echo "Error al guardar el ensayo: " . implode(", ", $stmt->errorInfo());
                }
            } else {
                echo "El archivo no es una imagen válida.";
            }
        } else {
            // Si no se sube una imagen, insertar sin la imagen
            $sql = "INSERT INTO ensayo (nombre, descripcion, encargado, fecha, lugar, hora_inicio, hora_culminacion)
                    VALUES (:nombre, :descripcion, :encargado, :fecha, :lugar, :hora_inicio, :hora_culminacion)";
            
            // Preparar la consulta
            $stmt = $conn->prepare($sql);

            // Enlazar los parámetros con los valores del formulario
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':encargado', $encargado);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':lugar', $lugar);
            $stmt->bindParam(':hora_inicio', $hora_inicio);
            $stmt->bindParam(':hora_culminacion', $hora_culminacion);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                header('Location: ../principal_docente.html');
            } else {
                echo "Error al guardar el ensayo: " . implode(", ", $stmt->errorInfo());
            }
        }
    }
} catch (PDOException $e) {
    echo "Error al conectar a la base de datos: " . $e->getMessage();
}
?>
