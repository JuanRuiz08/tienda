<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){ /* Se usa para el botón ORDERNOW */

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   /* Consulta SQL */
   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Error en la consulta');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total; /* Calcula el costo total de los artículos en el carrito de un usuario */
      }
   }

   $total_products = implode(', ', $cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('Error en la consulta');

   if($cart_total == 0){
      $message[] = 'Tu carrito está vacío'; /* Notificación de carrito vacío */
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = '¡Pedido ya realizado!';
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('Error en la consulta');
         $message[] = '¡Pedido realizado con éxito!'; /* Pedido realizado con éxito */
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Error en la consulta');
      }
   }
   /* Esto va dirigido a phpMyAdmin en la sección ORDERS y a los datos que se ingresan en checkout.php */
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Verificación de compra</title>

   <link rel="icon" id="png" href="images/icon2.png">

   <!-- Enlace CDN de font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Enlace al archivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>
 
<div class="heading">  <!-- Imagen y título de inicio de la página -->
   <h3>Verificación</h3>
   <p> <a href="inico.php">Inicio</a> / Verificación </p> 
</div>

<section class="display-order"> <!-- CSS para mostrar la orden -->
 
   <?php
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Error en la consulta');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="vacio">Tu carrito está vacío</p>';
   }
   ?>
   <div class="gran-total"> Total general : <span>$<?php echo $grand_total; ?> mil</span> </div>

</section>

<!-- Información de la orden -->
<section class="pagar"> <!-- CSS para el formulario de verificación -->

<form action="" method="post">
      <h3>Haga su pedido</h3>
      <div class="flex">
         <div class="inputBox">
            <span>Tu nombre :</span>
            <input type="text" name="name" required placeholder="Ingresa tu nombre">
         </div>
         <div class="inputBox">
            <span>Tu número :</span>
            <input type="number" name="number" required placeholder="Ingresa tu número">
         </div>
         <div class="inputBox">
            <span>Tu correo :</span>
            <input type="email" name="email" required placeholder="Ingresa tu correo">
         </div>
         <div class="inputBox">
            <span>Método de pago :</span>
            <select name="method">
               <option value="cash on delivery">Efectivo contra entrega</option>
               <option value="credit card">Tarjeta de crédito</option>
               <option value="paypal">PayPal</option>
               <option value="debito">Débito</option>
               <option value="efectivo en tienda">Efectivo  en tienda</option> <!-- Selección del método de pago -->
            </select>
         </div>
         <div class="inputBox">
            <span>Línea de dirección 01 :</span>
            <input type="number" min="0" name="flat" required placeholder="Ej. Número de apartamento">
         </div>
         <div class="inputBox">
            <span>Línea de dirección 02 :</span>
            <input type="text" name="street" required placeholder="Ej. Nombre de la calle">
         </div>
         <div class="inputBox">
            <span>Ciudad :</span>
            <input type="text" name="city" required placeholder="Ej. Pereira">
         </div>
         <div class="inputBox">
            <span>Barrio :</span>
            <input type="text" name="state" required placeholder="Ej. San judas">
         </div>
         <div class="inputBox">
            <span>País :</span>
            <input type="text" name="country" required placeholder="Ej. Colombia">
         </div>
         <div class="inputBox">
            <span>Código postal :</span>
            <input type="number" min="0" name="pin_code" required placeholder="Ej. 660005">
         </div>
      </div>
      <input type="submit" value="Realizar pedido" class="boton" name="order_btn"> <!-- Botón para realizar el pedido -->
   </form>

</section>

<?php include 'footer.php'; ?>

<!-- Enlace al archivo JS personalizado -->
<script src="js/script.js"></script>

</body>
</html>
