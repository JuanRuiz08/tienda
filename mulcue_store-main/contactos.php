<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('Error en la consulta');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = '¡Mensaje ya enviado!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('Error en la consulta');
      $message[] = '¡Mensaje enviado con éxito!';
   }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contacto</title>

   <!-- Enlace a Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Enlace al archivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Contáctanos</h3>
   <p> <a href="inicio.php">Inicio</a> / Contacto </p>
</div>

<section class="contactos">

   <form action="" method="post">
      <h3>Escríbenos...</h3>
      <input type="text" name="name" required placeholder="ingresa tu nombre" class="caja">
      <input type="email" name="email" required placeholder="ingresa tu correo" class="caja">
      <input type="number" name="number" required placeholder="ingresa tu número" class="caja">
      <textarea name="message" class="caja" placeholder="ingresa tu mensaje" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="enviar mensaje" name="send" class="boton">
   </form>

</section>

<?php include 'footer.php'; ?>

<!-- Enlace al archivo JS personalizado -->
<script src="js/script.js"></script>

</body>
</html>
