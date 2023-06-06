//Script para hacer desaparecer la precarga de la pagina 
function tiempodeCarga() {
    $("#spinner").fadeOut("slow");
}
setTimeout(tiempodeCarga, 500);

    var remaining_time_elem = document.getElementById("remaining_time");
    var remaining_time = parseInt(remaining_time_elem.value);
    
    var countdown_elem = document.getElementById("countdown");
    var login_btn = document.getElementById("login_btn");
    
    var countdown_interval = setInterval(function() {
        remaining_time--;
        if (remaining_time <= 0) {
            clearInterval(countdown_interval);
            countdown_elem.innerHTML = "Inicio de sesión disponible";
            login_btn.disabled = true; // Habilitar el botón de inicio de sesión
        } else {
            countdown_elem.innerHTML = "Tiempo restante: " + remaining_time + " segundos";
        }
    }, 1000);
    
    login_btn.disabled = true; // Inhabilitar el botón de inicio de sesión
    
      

