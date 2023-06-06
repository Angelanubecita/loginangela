<?php
session_start();

// Verifica si se ha enviado el formulario y si es una solicitud POST
if (isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    include('conexion/config.php');
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);

    $PasswordHash = password_hash($password, PASSWORD_BCRYPT);

    // Utiliza consultas preparadas para evitar la inyección SQL
    $stmt = $con->prepare("SELECT email FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El email ya está registrado
        echo "El correo electrónico ya está registrado";
    } else {
        // Utiliza consultas preparadas para evitar la inyección SQL
        $stmt = $con->prepare("INSERT INTO users (email, password, name, rol) VALUES (?, ?, ?, 'usuario')");
        $stmt->bind_param("sss", $email, $PasswordHash, $name);
        $stmt->execute();
        $stmt->close();
        header("location: index.php");
        exit();
    }
}
?>

