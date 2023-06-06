<!DOCTYPE html>
<html>
<head>
    <title>Error de inicio de sesión</title>
    <style>
        .error-container {
            width: 500px;
            margin: 100px auto;
            text-align: center;
        }

        h1 {
            color: #FF0000;
        }
    </style>
    <script>
        // Detectar cuando el usuario intenta salir de la página
        window.addEventListener('beforeunload', function (e) {
            // Mensaje de advertencia
            var mensaje = "Estás bloqueado en esta página. Debes esperar hasta que se cumpla el tiempo de bloqueo.";
            // Establecer el mensaje en la ventana emergente
            e.returnValue = mensaje;
            // Retorna el mensaje para navegadores antiguos
            return mensaje;
        });
    </script>
</head>
<body>
    <div class="error-container">
        <h1>Error de inicio de sesión</h1>
        <p>Has alcanzado el límite de intentos fallidos de inicio de sesión. Por favor, inténtalo más tarde.</p>
        
        <p><a href="index.php">Volver al inicio</a></p>
    </div>
</body>
</html>
