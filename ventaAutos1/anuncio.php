<?php

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /ventaAutos1/');
    }

    //Importar conexión
    require 'includes/config/database.php';
    $db = conectarDB();

    //Consultar
    $query = "SELECT * FROM autos WHERE id = ${id}";

    //Obtener resultados
    $resultado = mysqli_query($db, $query);

    if(!$resultado->num_rows){
        header('Location: /ventaAutos1/');
    }

    $auto = mysqli_fetch_assoc($resultado);




    require 'includes/funciones.php';    
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $auto['titulo']; ?></h1>

        <img style=" width:100%; height:27%;" loading="lazy" src="/ventaAutos1/imagenes/<?php echo $auto['imagen']; ?>" alt="anuncio">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $auto['precio']; ?></p>
            <p><?php echo $auto['descripcion']; ?></p>
            <ul>
                <h4>Características</h4>
                <li>
                    <!-- <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">-->
                    <p>Puertas: <?php echo $auto['puertas']; ?></p> 
                </li>
                <li>
                    <!-- <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento"> -->
                    <p>Marca: <?php echo $auto['marca']; ?></p>
                </li>
                <li>
                    <!-- <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones"> -->
                    <p>Modelo: <?php echo $auto['modelo']; ?></p>
                </li>
            </ul>

            

        </div>
    </main>

<?php
    mysqli_close($db);
    incluirTemplate('footer');
?>