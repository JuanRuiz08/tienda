<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('Error en la consulta');
   header('location:admin_usuarios.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Usuarios</title>

   <!-- enlace a Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace al archivo CSS personalizado para admin -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="usuarios">

   <h1 class="title"> Cuentas de usuarios </h1>

   <div class="caja-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('Error en la consulta');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="caja">
         <p> ID de usuario : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> Nombre de usuario : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> Correo electrónico : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> Tipo de usuario : <span style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></span> </p>
         <a href="admin_usuarios.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('¿Eliminar este usuario?');" class="boton-eliminar">Eliminar usuario</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>

<!-- enlace al archivo JS personalizado para admin -->
<script src="js/admin_script.js"></script>

</body>
</html>
