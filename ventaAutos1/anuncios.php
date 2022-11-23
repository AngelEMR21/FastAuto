<?php
    require 'includes/funciones.php';    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">

        <h2>Catálogo de autos</h2>

        <?php 
        $limite = 20;
        include 'includes/templates/anuncios.php'; 
        ?>

        
    </main>

<?php
    incluirTemplate('footer');
?>