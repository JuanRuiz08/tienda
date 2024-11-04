<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Acerca de</title>

   <link rel="icon" id="png" href="images/icon2.png">

   <!-- enlace a font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace a archivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading"> 
   <h3>Acerca de nosotros</h3>  <!-- conexión PHP con otras páginas y agrega título -->
   <p> <a href="inicio.php">Inicio</a> / Acerca de </p>
</div>

<section class="acerca">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="imagen sobre nosotros"> <!-- imagen y texto debajo de los productos -->
      </div>

      

   </div>

</section>

<!-- COMENTARIOS DE CLIENTES EN ACERCA DE -->

   
   </div>
</section>

<?php include 'footer.php'?> <!-- incluye footer.php -->
<!-- enlace a archivo JS personalizado -->
<script src="js/script.js"></script>
</body>
</html>
