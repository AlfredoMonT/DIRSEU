<?php
// Conectar a la base de datos
require '../controlador/conexion.php';

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombreAlumno = $_POST['nombreAlumno'];
$apellidoAlumno = $_POST['apellidoAlumno'];
$correoAlumno = $_POST['correoAlumno'];
$generoAlumno = $_POST['generoAlumno'];
$celularAlumno = $_POST['celularAlumno'];
$idTaller = $_POST['idTaller'];  // Obtenemos el ID del taller

// Depuración: Mostrar el idTaller recibido
echo "idTaller recibido: " . $idTaller;  // Esto debería imprimir el valor de idTaller

// Verificar que el campo idTaller no esté vacío
if (!empty($idTaller)) {
    // Verificar si el idTaller existe en la tabla taller
    $sql = "SELECT idTaller FROM taller WHERE idTaller = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idTaller); // Usar "i" para tipo entero
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Si existe el idTaller
    if ($result->num_rows > 0) {
        // Insertar los datos del alumno en la tabla alumno
        $query = "INSERT INTO alumno (nombreAlumno, apellidoAlumno, correoAlumno, generoAlumno, celularAlumno, idTaller) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        // Preparar la consulta para insertar el alumno
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $nombreAlumno, $apellidoAlumno, $correoAlumno, $generoAlumno, $celularAlumno, $idTaller);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            header('Location: ../controlador/listar_alumnos.php');
        } else {
            echo "Error al registrar el alumno: " . $stmt->error;
        }
    } else {
        echo "El idTaller especificado no existe en la base de datos.";
    }
} else {
    echo "El campo 'Taller' es obligatorio.";
}

// Cerrar la conexión
$conn->close();
?>
