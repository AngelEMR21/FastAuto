<?php

session_start();

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

$auth = $_SESSION['login'];
$rol = $_SESSION['rol'];
$nombre = $_SESSION['nombre'];

// echo $rol;

if($rol != "1" ){
    header('Location: /ventaAutos1/');
}

//Importar la conexión
require '../../includes/config/database.php';
$db = conectarDB();

//Escribir el query
// $query = "SELECT * FROM autos";

$query = "SELECT * FROM usuarios";

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

        //Eliminar registro de un empleado
        $query = "DELETE FROM usuarios WHERE id=${id}";
        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('Location: /ventaAutos1/admin/administrador/empleados.php?resultado=3');
        }

    }
} //ELIMINACION DE REGISTROS

//Incluye un template 
require '../../includes/funciones.php';    
incluirTemplate('header');
?>



    <main class="contenedor seccion">
        
        <h2>Lista de empleados</h2>
        <h3>Sesión: <?php echo $nombre ?></h3>

        <?php if (intval($resultado) === 1) : ?>
            <p class="alerta exito">Empleado creado correctamente</p>
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">Empleado actualizado correctamente</p>
        <?php elseif(intval($resultado) === 3): ?>
            <p class="alerta exito">Empleado eliminado correctamente</p>
        <?php endif;  ?>

        <a href="/ventaAutos1/admin/administrador/crearEmpleado.php" class="boton boton-verde">Registrar nuevo empleado</a>
        <a href="/ventaAutos1/admin/administrador.php" class="boton boton-verde">Volver</a>
        <table class="autos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>E-mail</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!-- Mostrar los resultados de la BD -->
                <?php while ($empleado = mysqli_fetch_assoc($resultadoConsulta)) : ?>


                    <tr>
                        <td><?php echo $empleado['id'];  ?></td>
                        <td><?php echo $empleado['nombre'];  ?> </td>
                        <td><?php echo $empleado['apellidos'];  ?></td>
                        <td><?php echo $empleado['email'];  ?> </td> 
                        <td><?php echo $empleado['telefono'];  ?></td>

                        <?php if($empleado['rol'] === "1"): ?>
                        <td>Administrador</td>
                        <?php elseif($empleado['rol'] === "2"): ?>
                        <td>Empleado</td>
                        <?php endif; ?>

                        <td>
                        <br>
                            <a style="border-radius: 1rem" href="/ventaAutos1/admin/administrador/actualizarEmpleado.php?id=<?php echo $empleado['id'];  ?>" class="boton-amarillo-block">Actualizar</a>
                            <!-- Eliminar - Obtener el id del registro -->
                            <form method="POST" class="w-100">
                            <br>
                            <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">
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