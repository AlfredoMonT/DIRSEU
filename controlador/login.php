<?php
session_start();

// Activar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la conexión a la base de datos
require '../controlador/conexion.php';

// Procesar el formulario solo si se envió mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $contrasenia = $_POST['contrasenia'];

    // Consulta para verificar si el correo existe
    $sql = "SELECT * FROM usuario WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error en la preparación de la declaración: " . $conn->error);
    }

    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña sin encriptación
    if ($contrasenia == $row['contrasenia']) {
        $_SESSION['correo'] = $correo;
        $_SESSION['role'] = $row['role'];

        // Redireccionar según el rol
        if ($row['role'] === 'alumno') {
            header('Location: ../principal_alumno.html'); 
        } elseif ($row['role'] === 'docente') {
            header('Location: ../principal_docente.html'); 
        } else {
            header('Location: ../home.html'); // Página predeterminada
        }
        exit();
    } else {
        $error_message = 'Contraseña incorrecta. Por favor, intente nuevamente.';
    }

    } else {
        $error_message = 'Usuario no encontrado. Ingrese correctamente.';
    }
    $stmt->close();
}

// Mostrar el mensaje de error si existe
if (isset($error_message)) {
    echo "<p style='text-align: center; background-color: #FFCCCC; color: black; padding: 10px; border-radius: 5px;'>$error_message</p>";

}

// Cerrar la conexión
$conn->close();
?>
