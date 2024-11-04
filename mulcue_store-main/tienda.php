<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('consulta fallida');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = '¡ya añadido al carrito!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('consulta fallida');
      $message[] = '¡producto añadido al carrito!';
   }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>tienda</title>

   <link rel="icon" id="png" href="images/icon2.png">
   
   <!-- enlace de cdn de font awesome  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace del archivo css personalizado  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>nuestra tienda</h3>
   <p> <a href="inicio.php">inicio</a> / tienda </p>
</div>

<section class="productos">

   <h1 class="title">últimos productos</h1>

   <div class="caja-container">

      <?php  
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('consulta fallida');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
     <form action="" method="post" class="caja">
      <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
      <div class="name"><?php echo $fetch_products['name']; ?></div>
      <div class="price">$<?php echo $fetch_products['price']; ?>Mil</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
      <input type="submit" value="añadir al carrito" name="add_to_cart" class="boton">
     </form>
      <?php
         }
      }else{
         echo '<p class="vacio">¡no se han añadido productos aún!</p>';
      }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- enlace del archivo js personalizado  -->
<script src="js/script.js"></script>

</body>
</html>
