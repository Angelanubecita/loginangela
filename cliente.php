<?php
session_start();

// Verificar si el usuario no tiene el rol de "cliente"
if ($_SESSION['user']['rol'] !== 'usuario') {
    header("Location: admin.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Dashboard del Cliente</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <!-- Agrega enlaces adicionales a tus archivos CSS personalizados si los tienes -->
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Dashboard del Cliente</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Perfil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Mis Pedidos</a>
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
      <h1 class="display-4">¡Bienvenido, Cliente!</h1>
      <p class="lead">En esta sección puedes ver y actualizar tu perfil, consultar tus pedidos y realizar otras acciones relacionadas con tu cuenta de cliente.</p>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Perfil</h5>
          </div>
          <div class="card-body">
            <!-- Aquí puedes mostrar y permitir la edición del perfil del cliente -->
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Mis Pedidos</h5>
          </div>
          <div class="card-body">
            <!-- Aquí puedes mostrar una lista de los pedidos del cliente -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <!-- Agrega enlaces adicionales a tus archivos JavaScript personalizados si los tienes -->
</body>
</html>
