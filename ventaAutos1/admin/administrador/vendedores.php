<?php

session_start();

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

$auth = $_SESSION['login'];
$rol = $_SESSION['rol'];
$nombre = $_SESSION['nombre'];

// echo $rol;

if($rol != ("1" || "2" )){
    header('Location: /ventaAutos1/');
}

//Importar la conexión
require '../../includes/config/database.php';
$db = conectarDB();

//Escribir el query
// $query = "SELECT * FROM autos";

$query = "SELECT * FROM vendedores";

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

        //Eliminar registro de un vendedor
        $query = "DELETE FROM vendedores WHERE id=${id}";
        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('Location: /ventaAutos1/admin/administrador/vendedores.php?resultado=3');
        }

    }
} //ELIMINACION DE REGISTROS

//Incluye un template 
require '../../includes/funciones.php';    
incluirTemplate('header');
?>



    <main class="contenedor seccion">
        
        <h2>Lista de vendedores</h2>
        <h3>Sesión: <?php echo $nombre ?></h3>

        <?php if (intval($resultado) === 1) : ?>
            <p class="alerta exito">Vendedor creado correctamente</p>
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">Vendedor actualizado correctamente</p>
        <?php elseif(intval($resultado) === 3): ?>
            <p class="alerta exito">Vendedor eliminado correctamente</p>
        <?php endif;  ?>

        <a href="/ventaAutos1/admin/administrador/crearVendedor.php" class="boton boton-verde">Registrar nuevo vendedor</a>

        <?php if($rol === "1"): ?>
        <a href="/ventaAutos1/admin/administrador.php" class="boton boton-verde">Volver</a>
        <?php elseif($rol === "2"): ?>
        <a href="/ventaAutos1/admin/empleado.php" class="boton boton-verde">Volver</a>
        <?php endif; ?>

        <table class="autos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!-- Mostrar los resultados de la BD -->
                <?php while ($vendedor = mysqli_fetch_assoc($resultadoConsulta)) : ?>


                    <tr>
                        <td><?php echo $vendedor['id'];  ?></td>
                        <td><?php echo $vendedor['nombre'];  ?> </td>
                        <td><?php echo $vendedor['apellido'];  ?></td>
                        <td><?php echo $vendedor['telefono'];  ?></td>
                        <td>
                        <br>
                            <a style="border-radius: 1rem" href="/ventaAutos1/admin/administrador/actualizarVendedor.php?id=<?php echo $vendedor['id'];  ?>" class="boton-amarillo-block">Actualizar</a>
                            <!-- Eliminar - Obtener el id del registro -->
                            <form method="POST" class="w-100">
                            <br>
                            <input type="hidden" name="id" value="<?php echo $vendedor['id']; ?>">
                            <input type="submit" style="border-radius: 1rem" class="boton-rojo-block" value="Eliminar">
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