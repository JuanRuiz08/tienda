<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <link rel="icon" id="png" href="images/icon2.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>tus pedidos</h3>
   <p> <a href="inicio.php">inicio</a> / pedidos </p>
</div>

<section class="pedidos-realizados">

   <h1 class="title">pedidos realizados</h1>

   <div class="caja-container">

      <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
         if(mysqli_num_rows($order_query) > 0){
            while($fetch_orders = mysqli_fetch_assoc($order_query)){
      ?>
    <div class="caja">
   <p> Fecha de pedido: <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
   <p> Nombre: <span><?php echo $fetch_orders['name']; ?></span> </p>
   <p> Número: <span><?php echo $fetch_orders['number']; ?></span> </p>
   <p> Correo electrónico: <span><?php echo $fetch_orders['email']; ?></span> </p>
   <p> Dirección: <span><?php echo $fetch_orders['address']; ?></span> </p>
   <p> Método de pago: <span><?php echo $fetch_orders['method']; ?></span> </p>
   <p> Tus pedidos: <span><?php echo $fetch_orders['total_products']; ?></span> </p>
   <p> Precio total: <span>$<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
   <p> Estado del pago: <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
</div>

      <?php
       }
      }else{
         echo '<p class="vacio">Aún no se han realizado pedidos!</p>';
      }
      ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>