<!DOCTYPE html>
<html>
<head>
    <title>Ejemplo de formulario con botón bloqueado</title>
</head>
<body>
    <form>
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="checkbox" id="terms" name="terms">
        <label for="terms">Acepto los términos y condiciones</label><br>

        <button id="submitBtn" type="submit" disabled>Enviar</button>
    </form>

    <script>
        // Obtener referencias a los elementos del formulario
        var usernameInput = document.getElementById("username");
        var passwordInput = document.getElementById("password");
        var termsCheckbox = document.getElementById("terms");
        var submitBtn = document.getElementById("submitBtn");

        // Función para verificar la condición y habilitar/deshabilitar el botón de envío
        function checkCondition() {
            var username = usernameInput.value;
            var password = passwordInput.value;
            var termsChecked = termsCheckbox.checked;

            // Ejemplo de condición: habilitar el botón si el nombre de usuario y la contraseña tienen al menos 4 caracteres
            // y se ha marcado el checkbox de términos y condiciones
            if (username.length >= 4 && password.length >= 4 && termsChecked) {
                submitBtn.disabled = false; // Habilitar el botón
            } else {
                submitBtn.disabled = true; // Deshabilitar el botón
            }
        }

        // Agregar eventos de escucha a los elementos del formulario
        usernameInput.addEventListener("input", checkCondition);
        passwordInput.addEventListener("input", checkCondition);
        termsCheckbox.addEventListener("change", checkCondition);
    </script>
</body>
</html>
