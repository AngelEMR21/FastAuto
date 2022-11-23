<?php

session_start();

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

$auth = $_SESSION['login'];
$rol = $_SESSION['rol'];
$nombre =  $_SESSION['nombre'];

if($rol != "2"){
    header('Location: /ventaAutos1/');
}

//Importar la conexión
require '../includes/config/database.php';
$db = conectarDB();

//Escribir el query
// $query = "SELECT * FROM autos";

$query = "SELECT autos.id, titulo, precio, imagen, vendedores.nombre, vendedores.apellido FROM
    autos LEFT JOIN vendedores on autos.vendedores_id = vendedores.id";

//Consultar la BD
$resultadoConsulta = mysqli_query($db, $query);

//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;


//ELIMINACION DE REGISTROS
//Crea las variables solo cuando existe POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    
    if($id){

        //Eliminar el archivo
        $query = "SELECT imagen FROM autos WHERE id = ${id}";
        $resultado = mysqli_query($db, $query);
        $auto = mysqli_fetch_assoc($resultado);

        unlink('../imagenes/' . $auto['imagen']);

        //Eliminar registro de un auto
        $query = "DELETE FROM autos WHERE id=${id}";
        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('Location: /ventaAutos1/admin/administrador.php?resultado=3');
        }

    }
} //ELIMINACION DE REGISTROS

//Incluye un template 
require '../includes/funciones.php';    
incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Empleado</h1>
        <h2>Bienvenido: <?php echo $nombre ?></h2>

        <?php if (intval($resultado) === 1) : ?>
            <p class="alerta exito">Publicación creada correctamente</p>
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">Publicación actualizada correctamente</p>
        <?php elseif(intval($resultado) === 3): ?>
            <p class="alerta exito">Registro eliminado correctamente</p>
        <?php endif;  ?>

        <a href="/ventaAutos1/admin/empleados/crear.php" class="boton boton-verde">Registrar nuevo auto</a>
        <a href="/ventaAutos1/admin/administrador/vendedores.php" class="boton boton-verde">Vendedores</a>
        <a href="/ventaAutos1/admin/administrador/solicitudes.php" class="boton boton-verde">Solicitudes</a>

        <table class="autos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Vendedor</th>
                    <!-- <th>Acciones</th> -->
                </tr>
            </thead>

            <tbody>
                <!-- Mostrar los resultados de la BD -->
                <?php while ($auto = mysqli_fetch_assoc($resultadoConsulta)) : ?>


                    <tr>
                        <td><?php echo $auto['id'];  ?></td>
                        <td><?php echo $auto['titulo'];  ?></td>
                        <td><img src="/ventaAutos1/imagenes/<?php echo $auto['imagen'];  ?>" class="imagen-tabla"></td>
                        <td>$ <?php echo $auto['precio'];  ?></td>
                        <td><?php echo $auto['nombre'] . " " . $auto['apellido'];  ?></td>
                        <td>
                            <br>
                            <!-- <a style="border-radius: 1rem" href="/ventaAutos1/admin/propiedades/actualizar.php?id=<?php echo $auto['id'];  ?>" class="boton-amarillo-block">Actualizar</a> -->
                            <!-- Eliminar - Obtener el id del registro -->
                            <form method="POST" class="w-100">
                            <br>
                            <input type="hidden" name="id" value="<?php echo $auto['id']; ?>">
                            <!-- <input type="submit" style="border-radius: 1rem" class="boton-rojo-block" value="Eliminar"> -->
                            </form> <!-- Eliminar -->

                        </td>
                    </tr>

                <?php endwhile; ?>

            </tbody>
        </table>


    </main>


    <?php
    incluirTemplate('footer');
    ?>

<?php

//Cerrar la conexión de la BD
mysqli_close($db);

// incluirTemplate('footer');
?>