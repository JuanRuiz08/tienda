<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('consulta fallida');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = '¡El usuario ya existe!';
   }else{
      if($pass != $cpass){
         $message[] = '¡La confirmación de la contraseña no coincide!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('consulta fallida');
         $message[] = '¡Registrado exitosamente!';
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>registro</title>
   <link rel="icon" id="png" href="images/icon2.png">

   <!-- enlace de cdn de font awesome  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace del archivo css personalizado  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="mensaje">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>regístrate ahora en papeleria U.C.P</h3>
      <input type="text" name="name" placeholder="ingresa tu nombre" required class="caja">
      <input type="email" name="email" placeholder="ingresa tu correo electrónico" required class="caja">
      <input type="password" name="password" placeholder="ingresa tu contraseña" required class="caja">
      <input type="password" name="cpassword" placeholder="confirma tu contraseña" required class="caja">
      <select name="user_type" class="caja">
         <option value="user">usuario</option>
         <option value="admin">administrador</option>
      </select>
      <input type="submit" name="submit" value="regístrate ahora" class="boton">
      <p>¿ya tienes una cuenta? <a href="login.php">inicia sesión ahora</a></p>
   </form>

</div>

</body>
</html>
