<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('consulta fallida');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = '¡ya añadido al carrito!';
   }else{/*conexión con mysqli*/
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('consulta fallida');
      $message[] = '¡producto añadido al carrito!'; /*hace conexión con los valores y cantidad de productos en mysqli*/
   }

};

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>página de búsqueda</title>

   <!-- enlace de cdn de font awesome  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace del archivo css personalizado  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading"> <!--imagen y título de inicio de la página-->
   <h3>productos</h3>
   <p> <a href="inicio.php">inicio</a> / búsqueda </p>
</div>

<section class="formulario-busqueda">
   <form action="" method="post">
      <input type="text" name="search" placeholder="buscar productos..." class="caja"> <!--cuadro de búsqueda-->
      <input type="submit" name="submit" value="buscar" class="boton">
   </form>
</section>

<section class="productos" style="padding-top: 0;"> <!--SE usará para poder hacer las búsquedas de los artículos en phpMyAdmin-->

   <div class="caja-container">
   <?php
      if(isset($_POST['submit'])){  /*MUESTRA ARTÍCULO QUE BUSCA*/
         $search_item = $_POST['search'];
         $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('consulta fallida'); /*search muestra artículo*/
         if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
   ?>
   <form action="" method="post" class="box"> <!-- box- clase para cuadro de imagen para la película -->
      <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="" class="image"> <!-- imágenes de las películas -->
      <div class="name"><?php echo $fetch_product['name']; ?></div>
      <div class="price">$<?php echo $fetch_product['price']; ?>Mil</div><!-- símbolos de precios-->
      <input type="number"  class="qty" name="product_quantity" min="1" value="1"> <!-- cuadro # de productos a escoger-->
      <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>"><!-- valores debajo de los productos -->
      <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
      <input type="submit" class="boton" value="añadir al carrito" name="add_to_cart"> <!--btn de add_to_cart-->
   </form>
   <?php
            }
         }else{
            echo '<p class="empty">¡No se han encontrado resultados!</p>';
         }
      }else{
         echo '<p class="empty">¡Busca algo!</p>'; /*si una variable está vacía*/
      }
   ?>
   </div>
  
</section>

<?php include 'footer.php'; ?>

<!-- enlace del archivo js personalizado  -->
<script src="js/script.js"></script>

</body>
</html>
