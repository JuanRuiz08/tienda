<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){  /* conexión a phpMyAdmin */
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('Error en la consulta');
   $message[] = '¡Cantidad del carrito actualizada!'; /* eliminar artículos */
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('Error en la consulta');
   header('location:carrito.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('Error en la consulta');
   header('location:carrito.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Carrito</title>

   <link rel="icon" id="png" href="images/icon2.png">
   
   <!-- enlace a Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace al archivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Carrito de Compras</h3>
   <p> <a href="inicio.php">Inicio</a> / Carrito </p>
</div>

<section class="carrito-de-compras">

   <h1 class="title">Productos Añadidos</h1>

   <div class="caja-container">
      <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('Error en la consulta');
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
      ?>
      <div class="caja">
         <a href="carrito.php?delete=<?php echo $fetch_cart['id']; ?>" class="fas fa-times" onclick="return confirm('¿Eliminar esto del carrito?');"></a>
         <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_cart['name']; ?></div>
         <div class="price">$<?php echo $fetch_cart['price']; ?> Mil</div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
            <input type="submit" name="update_cart" value="actualizar" class="boton-opcion">
         </form>
         <div class="sub-total"> Subtotal : <span>$<?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?> Mil</span> </div>
      </div>
      <?php
      $grand_total += $sub_total;
         }
      }else{
         echo '<p class="vacio">Tu carrito está vacío</p>';
      }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="carrito.php?delete_all" class="boton-eliminar <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('¿Eliminar todo del carrito?');">Eliminar todo</a>
   </div>

   <div class="total-carrito">
      <p>Total general: <span>$<?php echo $grand_total; ?> Mil</span></p>
      <div class="flex">
         <a href="tienda.php" class="boton-opcion">Continuar comprando</a>
         <a href="pagar.php" class="boton <?php echo ($grand_total > 1)?'':'disabled'; ?>">Proceder al pago</a>
      </div>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- enlace al archivo JS personalizado -->
<script src="js/script.js"></script>

</body>
</html>
