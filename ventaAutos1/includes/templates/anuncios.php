<?php
//Importar conexión
require __DIR__ . '/../config/database.php';
$db = conectarDB();

//Consultar
$query = "SELECT * FROM autos LIMIT ${limite}";

//Obtener resultados
$resultado = mysqli_query($db, $query);



?>

<div class="contenedor-anuncios">
    <?php while ($auto = mysqli_fetch_assoc($resultado)) : ?>
        <div class="anuncio">

            <img  style=" width:100%; height:27%;" loading="lazy" src="/ventaAutos1/imagenes/<?php echo $auto['imagen']; ?>" alt="anuncio">


            <!-- <div class="contenido-anuncio"> -->
            <div >
                <h3><?php echo $auto['titulo']; ?></h3>
                <p><?php echo $auto['descripcion']; ?></p>
                <p style="text-align: center" class="precio">$ <?php echo $auto['precio']; ?></p>

                <!-- <ul class="iconos-caracteristicas"> -->
                <ul >
                    <h4 style="text-align: center">Características</h4>
                    <li>
                        <!-- <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc"> -->
                        <p> Puertas: <?php echo $auto['puertas']; ?></p>
                    </li>
                    <li>
                        <!-- <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento"> -->
                        <p><?php echo $auto['marca']; ?></p>
                    </li>
                    <li>
                        <!-- <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones"> -->
                        <p><?php echo $auto['modelo']; ?></p>
                    </li>
                </ul>

                <a href="anuncio.php?id=<?php echo $auto['id']; ?>" class="boton-amarillo-block">
                    Ver Auto
                </a>
            </div>
            <!--.contenido-anuncio-->
        </div>
        <!--anuncio-->
    <?php endwhile; ?>

</div>
<!--.contenedor-anuncios-->


<?php
//Cerrar conexion

mysqli_close($db);

?>