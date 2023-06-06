<?php

session_start();

// Verificar si el usuario no tiene el rol de "admin"
if ($_SESSION['user']['rol'] !== 'admin') {
    header("Location: cliente.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Dashboard del Administrador</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <!-- Agrega enlaces adicionales a tus archivos CSS personalizados si los tienes -->
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Dashboard del Administrador</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Gestión de usuarios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Gestión de productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pedidos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Configuración</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="salirSesion.php">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="jumbotron">
      <h1 class="display-4">¡Bienvenido, Administrador!</h1>
      <p class="lead">En esta sección puedes administrar el sitio, gestionar usuarios, productos, pedidos y realizar otras tareas relacionadas con tu rol de administrador.</p>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Resumen del Sitio</h5>
          </div>
          <div class="card-body">
            <!-- Aquí puedes agregar un resumen de estadísticas, gráficos, etc. -->
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Últimos Usuarios Registrados</h5>
          </div>
          <div class="card-body">
            <!-- Aquí puedes mostrar una tabla con los últimos usuarios registrados -->
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-4">
      <div class="card-header">
        <h5 class="card-title">Productos Destacados</h5>
      </div>
      <div class="card-body">
        <!-- Aquí puedes mostrar una lista de productos destacados -->
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <!-- Agrega enlaces adicionales a tus archivos JavaScript personalizados si los tienes -->
</body>
</html>
