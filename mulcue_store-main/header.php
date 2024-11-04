<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
               <a href="#" class="fab fa-instagram"></a>
            
         </div>
         <p> nuevo <a href="login.php">iniciar sesión</a> | <a href="registro.php">registrarse</a> </p>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="inicio.php" class="logo">papeleria U.C.P.</a>

         <nav class="navbar">
         <a href="categorias.php" >Categorías</a>
            <a href="inicio.php">inicio</a>
            <a href="acerca.php">acerca de</a>
            <a href="tienda.php">tienda</a>
            <a href="contactos.php">contacto</a>
            <a href="pedidos.php">pedidos</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="buscar_pagina.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user "></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('consulta fallida');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="carrito.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
         </div>

         <div class="usuario-caja">
            <p>nombre de usuario : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>correo electrónico : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="cerrar_sesion.php" class="boton-eliminar">cerrar sesión</a>
         </div>
      </div>
   </div>

</header>
