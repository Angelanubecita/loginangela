<?php
// Generar un token CSRF y guardarlo en la sesión
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require_once "conexion/config.php";
require_once "logs.php";
require_once "session.php"; 
$error = '';
$disable_login_button = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Agrega esta verificación al comienzo del bloque 'if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {'
if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    // El token CSRF no coincide, por lo tanto, se detiene el proceso
    die("Error de seguridad. Por favor, inténtalo de nuevo.");
}

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $ip = $_SERVER['REMOTE_ADDR'];
    $failed_attempts = get_failed_login_attempts($ip, 1); // Verificar los intentos fallidos en las últimas 1 hora

    // Verificar si ha pasado el tiempo necesario desde el último intento fallido
    $time_limit = date('Y-m-d H:i:s', strtotime("-1 minute")); // Intervalo de 1 hora
    $stmt = $con->prepare("SELECT COUNT(*) FROM login_logs WHERE estado = 0 AND ip = ? AND fecha_hora >= ?");
    $stmt->bind_param("ss", $ip, $time_limit);
    $stmt->execute();
    $stmt->bind_result($attempts_within_time_limit);
    $stmt->fetch();
    $stmt->close();
    $max_attempts = 2; // Número máximo de intentos fallidos permitidos

    if ($attempts_within_time_limit === 0 && $failed_attempts >= $max_attempts) {
        // Restablecer contador de intentos fallidos para la dirección IP actual
        $stmt = $con->prepare("DELETE FROM login_logs WHERE estado = 0 AND ip = ?");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $stmt->close();
        // Restablecer el contador a 0
        $failed_attempts = 0;
    }

    if ($failed_attempts >= $max_attempts) {
        $remaining_time = time() - strtotime($time_limit); // Opcional: $remaining_time = abs(time() - strtotime($time_limit)); para obtener el valor absoluto a prueba de errores
        $error .= '<p class="error">Has alcanzado el límite de intentos fallidos de inicio de sesión. Por favor, inténtalo más tarde.</p>';
        $disable_login_button = true; // Variable para deshabilitar el botón de "Iniciar Sesión"
    } else {
        if (empty($email)) {
            $error .= '<p class="error">Por favor ingrese su Correo!</p>';
        }
        if (empty($password)) {
            $error .= '<p class="error">Por favor ingrese su contraseña!</p>';
        }
        if (empty($error)) {
            // Verificar el reCAPTCHA
            $captcha_response = $_POST['g-recaptcha-response'];
            $secret_key = '6LfPnBUmAAAAALuoBJlghT0K3Rk1vtk2Qiq704zk'; // Reemplazar con su clave secreta de reCAPTCHA
            $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $captcha_response);
            $response_data = json_decode($verify_response);

            if ($response_data->success) {
                $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();

                if ($row) {
                    if (password_verify($password, $row['password'])) {
                        

                        // Guardar información del usuario en la sesión
                        $_SESSION['userid'] = $row['id'];
                        $_SESSION['user'] = $row;

                        write_login_log($email, true, "Login Exitoso");

                        // Redireccionar según el rol
                        if ($row['rol'] === 'admin') {
                            header("Location: admin.php");
                            exit;
                        } elseif ($row['rol'] === 'usuario') {
                            header("Location: cliente.php");
                            exit;
                        } else {
                            header("Location: cliente.php");
                            exit;
                        }
                    } else {
                        $error .= '<p class="error">La contraseña no es válida!</p>';
                        write_login_log($email, false, "Contraseña inválida");
                    }
                } else {
                    $error .= '<p class="error">No se encontró usuario asociado al correo!</p>';
                    write_login_log($email, false, "Usuario no encontrado");
                }
            } else {
                $error .= '<p class="error">Por favor intente de nuevo el Captcha!</p>';
                write_login_log($email, false, "Captcha inválido");
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">  
	<link rel="stylesheet" href="assets/css/estilos.css">
	<link rel="shortcut icon" type="image/x-icon" href="assets/perfil.png">
	<title>Login sesión con PHP y MySQL</title>

	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="assets/js/script.js"></script>

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<div id='spinner'></div>

	<div class="contenedor">
		<div class="columna-izquierda">
			<div class="registro activo" id="registro">
				<div class="header">
					<h1>¡Iniciar sesión!</h1>
					<p> - - - - - - - - - - - - - - - -</p>
				</div>
		
				<form class="formulario" name="formulario" action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
					<label for="nombre">Correo Electrónico</label>
					<div class="contenedor-input">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
							<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
						</svg>
						<input type="email" name="email" id="emailUser" required="true" autofocus="autofocus">
					</div>
		
					<label for="correo">Clave</label>
					<div class="contenedor-input">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
							<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
							<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
						</svg>
						<input type="password" name="password" id="passwordUser" required>
					</div>

					<label for="correo">Seguridad</label>
					<div>
					<div class="g-recaptcha" data-sitekey="6LfPnBUmAAAAAMVb-pBwmm7CvbPER0nHP1cAGsKC"></div>
					
				</div>
					</div>
					<button id="login_btn" type="submit" name="submit" <?php if($disable_login_button) echo 'disabled'; ?>>Iniciar Sesión </button>
                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <div id="countdown" class="text-danger"> </div>
                    </div>
					<div class="contenedor-boton">
						<a href="formLogin.php">Crear mi cuenta!</a>
					</div>
					
				</form>
			</div>
		</div>
		<div class="columna-derecha">
            
		</div> 
	</div>
	<script>
  var remaining_time = <?php echo json_encode($remaining_time); ?>;
  var countdown_elem = document.getElementById("countdown");
  var countdown_interval = setInterval(function() {
    remaining_time--;
    if (remaining_time <= 0) {
      clearInterval(countdown_interval);
      countdown_elem.innerHTML = "Inicio de sesión disponible";
      var login_btn = document.getElementById("login_btn");
      if (login_btn) {
        login_btn.disabled = false; // Habilitar el botón de inicio de sesión si existe
      }
    } else {
      countdown_elem.innerHTML = "Tiempo restante: " + remaining_time + " segundos";
    }
  }, 1000);

  window.addEventListener('DOMContentLoaded', function() {
    var login_btn = document.getElementById("login_btn");
    if (login_btn) {
      login_btn.disabled = true; // Inhabilitar el botón de inicio de sesión si existe
    }
  });
</script>
<script src="script.js"></script>

</body>
</html>