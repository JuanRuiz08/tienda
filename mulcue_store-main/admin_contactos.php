<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('fallo en la consulta');
   header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>mensajes</title>

   <!-- enlace cdn de font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace al archivo css personalizado de admin -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="mensaje">

   <h1 class="title"> mensajes </h1>

   <div class="caja-container">
   <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('fallo en la consulta');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){
      
   ?>
   <div class="caja">
      <p> id del usuario : <span><?php echo $fetch_message['user_id']; ?></span> </p>
      <p> nombre : <span><?php echo $fetch_message['name']; ?></span> </p>
      <p> número : <span><?php echo $fetch_message['number']; ?></span> </p>
      <p> correo electrónico : <span><?php echo $fetch_message['email']; ?></span> </p>
      <p> mensaje : <span><?php echo $fetch_message['message']; ?></span> </p>
      <a href="admin_contactos.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('¿eliminar este mensaje?');" class="delete-btn">eliminar mensaje</a>
   </div>
   <?php
      };
   }else{
      echo '<p class="vacio">¡no tienes mensajes!</p>';
   }
   ?>
   </div>

</section>

<!-- enlace al archivo js personalizado de admin -->
<script src="js/admin_script.js"></script>

</body>
</html>

