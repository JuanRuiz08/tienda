<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_POST['add_product'])) {

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $category = mysqli_real_escape_string($conn, $_POST['category']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die('fallo en la consulta');

   if (mysqli_num_rows($select_product_name) > 0) {
      $message[] = 'el nombre del producto ya ha sido añadido';
   } else {
      $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, category, image) VALUES('$name', '$price', '$category', '$image')") or die('fallo en la consulta');

      if ($add_product_query) {
         if ($image_size > 2000000) {
            $message[] = 'el tamaño de la imagen es demasiado grande';
         } else {
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'producto añadido exitosamente!';
         }
      } else {
         $message[] = 'el producto no pudo ser añadido!';
      }
   }
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('fallo en la consulta');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/' . $fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('fallo en la consulta');
   header('location:admin_productos.php');
}

if (isset($_POST['update_product'])) {

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('fallo en la consulta');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/' . $update_image;
   $update_old_image = $_POST['update_old_image'];

   if (!empty($update_image)) {
      if ($update_image_size > 2000000) {
         $message[] = 'el tamaño del archivo de imagen es demasiado grande';
      } else {
         mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('fallo en la consulta');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/' . $update_old_image);
      }
   }

   header('location:admin_productos.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Productos</title>

   <link rel="icon" id="png" href="images/icon2.png">

   <!-- enlace a font awesome cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- enlace a archivo css personalizado de admin -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">

   <h1 class="title">Productos de la tienda</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Añadir producto</h3>
      <input type="text" name="name" class="caja" placeholder="Ingrese el nombre del producto" required>
      <input type="number" min="0" name="price" class="caja" placeholder="Ingrese el precio del producto" required>
      <input type="file" name="image"   accept="image/jpg, image/jpeg, image/png" class="caja" required>
      <select name="category" class="caja" required>
   <option value="">Selecciona una categoría</option>
   <option value="dulceria">Dulcería</option>
   <option value="uso personal">Uso Personal</option>
   <option value="escolar">Escolar</option>
</select>

      <input type="submit" value="Añadir producto" name="add_product" class="boton">
   </form>

</section>

<section class="show-products">

   <div class="caja-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('fallo en la consulta');
         if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
      ?>
      <div class="caja">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?> Mil</div>
         <a href="admin_productos.php?update=<?php echo $fetch_products['id']; ?>" class="boton-opcion">Actualizar</a>
         <a href="admin_productos.php?delete=<?php echo $fetch_products['id']; ?>" class="boton-eliminar" onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="vacio">¡No se han añadido productos aún!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if (isset($_GET['update'])) {
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('fallo en la consulta');
         if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="caja" required placeholder="Ingrese el nombre del producto">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="caja" required placeholder="Ingrese el precio del producto">

      <select name="category" class="caja" required>
      <option value="">Selecciona una categoría</option>
      <option value="dulceria">Dulcería</option>
      <option value="uso personal">Uso Personal</option>
      <option value="escolar">Escolar</option>
   </select>   

      <input type="file" class="caja" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Actualizar" name="update_product" class="boton">
      <input type="reset" value="Cancelar" id="close-update" class="boton-opcion">
   </form>
   <?php
         }
      }
      } else {
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<script src="js/admin_script.js"></script>

</body>
</html>
