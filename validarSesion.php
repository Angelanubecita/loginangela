<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('conexion/config.php');
    require_once "logs.php";
    date_default_timezone_set("America/Bogota");
    $sesionDesde = date("Y-m-d H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $ipV6 = isset($_SERVER['REMOTE_ADDR']) ? inet_pton($_SERVER['REMOTE_ADDR']) : null;
    $navegador = $_SERVER['HTTP_USER_AGENT'];
    $exitoso = 0;
    $so= php_uname('s');
    $logUser = $_REQUEST['emailUser'];
    $captcha = $_POST['g-recaptcha-response'];
    $time_limit = date('Y-m-d H:i:s', strtotime("-1 minute"));
    //variables para bloqueo
    $error='';
    $disable_login_button = false;
    $failed_attempts = get_failed_login_attempts($ip, 1);
    $stmt = $con->prepare("SELECT COUNT(*) FROM registro_de_inicio_de_sesion WHERE inicio_de_sesion_exitoso = 0 AND ipv4 = ? AND hora_de_inicio >= ?");
    $stmt->bind_param("ss", $ip, $time_limit);
    $stmt->execute();
    $stmt->bind_result($attempts_within_time_limit);
    $stmt->fetch();
    $stmt->close();
    $max_attempts = 2; // Número máximo de intentos fallidos permitidos
if ($attempts_within_time_limit === 0 && $failed_attempts >= $max_attempts) {
//if ($failed_attempts >= $max_attempts) 
    // Restablecer contador de intentos fallidos para la dirección IP actual
    $stmt = $con->prepare("DELETE FROM registro_de_inicio_de_sesion WHERE inicio_de_sesion_exitoso = 0 AND ipv4 = ?");
    $stmt->bind_param("s", $ip);
    $stmt->execute();
    $stmt->close();
    // Restablecer el contador a 0
    $failed_attempts = 0; 
}
if ($failed_attempts >= $max_attempts) {
    $remaining_time = time() - strtotime($time_limit);
    // $remaining_time = abs(time() - strtotime($time_limit)); // Opcional: obtener el valor absoluto a prueba de errores
    $error .= '<p class="error">Has alcanzado el límite de intentos fallidos de inicio de sesión. Por favor, inténtalo más tarde.</p>';
    header("Location: error.php");
    $disable_login_button = true; // Variable para deshabilitar el botón de "Iniciar Sesión"
}
        else{
    // Verifica si la respuesta del Recaptcha está vacía
    if (!$captcha) {
        echo "Por favor, verifica que no eres un robot";
    } else {
        $secretkey = "6LfBidMlAAAAAJwALJcFea2ONJfjGhDumcXAbroh";
        $respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");

        $atributos = json_decode($respuesta, TRUE);

        if (!isset($atributos['success']) || $atributos['success'] !== true) {
            // El captcha no se ha validado correctamente
            echo "Por favor, verifica que no eres un robot";
        } else {
            // El captcha se ha validado correctamente
            // Continuar con el código para validar la cuenta de usuario

            $email = filter_var($_REQUEST['emailUser'], FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailUser = ($_REQUEST['emailUser']);
            }
            $passwordUser = trim($_REQUEST['passwordUser']);

            $sqlVerificandoLogin = ("SELECT IdUser, nameUser, emailUser, passwordUser  FROM myusers WHERE emailUser COLLATE utf8_bin='$emailUser'");
            $resultLogin = mysqli_query($con, $sqlVerificandoLogin) or die(mysqli_error($con));
            $numLogin = mysqli_num_rows($resultLogin);

            if ($numLogin != 0) {

                while ($rowData  = mysqli_fetch_assoc($resultLogin)) {
                    $passwordBD = $rowData['passwordUser'];

                    if (password_verify($passwordUser, $passwordBD)) {
                        session_start();
                        $_SESSION['IdUser'] = $rowData['IdUser'];
                        $_SESSION['nameUser'] = $rowData['nameUser'];
                        $_SESSION['emailUser'] = $rowData['emailUser'];
                        $exitoso = 1;                      
                        $Update = ("UPDATE myusers SET sesionDesde='$sesionDesde' WHERE emailUser='$emailUser' ");
                        $resultado = mysqli_query($con, $Update);
                    }
                }
            }

            // Registrar el intento de inicio de sesión en la tabla 'log'
            $sqlRegistroLog = "INSERT INTO registro_de_inicio_de_sesion (hora_de_inicio, ipv4, ipV6, navegador, sistema_operativo, inicio_de_sesion_exitoso, usuario) VALUES ('$sesionDesde', '$ip', '$ipV6', '$navegador', '$so', $exitoso, '$logUser')";
            mysqli_query($con, $sqlRegistroLog) or die(mysqli_error($con));
            
            if ($exitoso) {
                header("location:casa.php?a=1");
            } else {
                header("location:index.php?b=1");
            }
        }
        
    }
}
}
?>






