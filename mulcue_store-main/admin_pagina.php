<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>panel de administración</title>

   <!-- enlace a font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace al archivo css personalizado del admin -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- sección del panel de administración comienza -->

<section class="dashboard">

   <h1 class="title">Panel</h1>

   <div class="caja-container">

      <div class="caja">
         <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('error en la consulta');
            if(mysqli_num_rows($select_pending) > 0){
               while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                  $total_price = $fetch_pendings['total_price'];
                  $total_pendings += $total_price;
               };
            };
         ?>
         <h3>$<?php echo $total_pendings; ?>Mil</h3>
         <p>total pendientes</p>
      </div>

      <div class="caja">
         <?php
            $total_completed = 0;
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('error en la consulta');
            if(mysqli_num_rows($select_completed) > 0){
               while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                  $total_price = $fetch_completed['total_price'];
                  $total_completed += $total_price;
               };
            };
         ?>
         <h3>$<?php echo $total_completed; ?>Mil</h3>
         <p>pagos completados</p>
      </div>

      <div class="caja">
         <?php 
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('error en la consulta');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3><?php echo $number_of_orders; ?></h3>
         <p>Pedidos realizados</p>
      </div>

      <div class="caja">
         <?php 
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('error en la consulta');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <h3><?php echo $number_of_products; ?></h3>
         <p>productos añadidos</p>
      </div>

      <div class="caja">
         <?php 
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('error en la consulta');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>usuarios normales</p>
      </div>

      <div class="caja">
         <?php 
            $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('error en la consulta');
            $number_of_admins = mysqli_num_rows($select_admins);
         ?>
         <h3><?php echo $number_of_admins; ?></h3>
         <p>Administradores</p>
      </div>

      <div class="caja">
         <?php 
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('error en la consulta');
            $number_of_account = mysqli_num_rows($select_account);
         ?>
         <h3><?php echo $number_of_account; ?></h3>
         <p>total cuentas</p>
      </div>

      <div class="caja">
         <?php 
            $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('error en la consulta');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>nuevos mensajes</p>
      </div>

   </div>

</section>

<!-- sección del panel de administración termina -->

<!-- enlace al archivo js personalizado del admin -->
<script src="js/admin_script.js"></script>

</body>
</html>
