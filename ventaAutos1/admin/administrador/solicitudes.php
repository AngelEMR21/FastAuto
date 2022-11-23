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

// $query = "SELECT autos.id, titulo, precio, imagen, vendedores.nombre, vendedores.apellido FROM
//     autos LEFT JOIN vendedores on autos.vendedores_id = vendedores.id";

$query = "SELECT autos.id, autos.marca, autos.modelo, solicitudes.id as clave, nombre, email, telefono, 
mensaje, status, autos_id FROM solicitudes LEFT JOIN autos on solicitudes.autos_id = autos.id";



//Consultar la BD
$resultadoConsulta = mysqli_query($db, $query);

//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;


//ELIMINACION DE REGISTROS Y ACTUALIZACION DE STATUS
//Crea las variables solo cuando existe POST
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    $status = $_POST['status'];

    echo "status" . $status;
    echo "id" . $id;
    
    if(isset($id) && !isset($status) ){

        //Eliminar solicitud
        $query = "DELETE FROM solicitudes WHERE id=${id}";
        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('Location: /ventaAutos1/admin/administrador/solicitudes.php?resultado=3');
        }

    }

    if(isset($id) && isset($status)){

        //Actualizar status
        $query = "UPDATE solicitudes SET status = '${status}' WHERE id = ${id} ";
        $resultado = mysqli_query($db, $query);

        if($resultado){
            header('Location: /ventaAutos1/admin/administrador/solicitudes.php?resultado=4');
        }

    }
} //ELIMINACION DE REGISTROS Y ACTUALIZACION DE STATUS

//Incluye un template 
require '../../includes/funciones.php';    
incluirTemplate('header');
?>



    <main class="contenedor seccion">
        
        <h2>Solicitudes de contacto</h2>
        <h3>Sesión: <?php echo $nombre ?></h3>

        <?php if (intval($resultado) === 1) : ?>
            <p class="alerta exito">Solicitud creado correctamente</p>
        <?php elseif(intval($resultado) === 2): ?>
            <p class="alerta exito">Solicitud actualizado correctamente</p>
        <?php elseif(intval($resultado) === 3): ?>
            <p class="alerta exito">Solicitud eliminada correctamente</p>
        <?php elseif(intval($resultado) === 4): ?>
            <p class="alerta exito">Atendiendo solicitud</p>
        <?php endif;  ?>

        <!-- <a href="/ventaAutos1/admin/administrador/crearVendedor.php" class="boton boton-verde">Registrar nuevo vendedor</a> -->

        <?php if($rol === "1"): ?>
        <a href="/ventaAutos1/admin/administrador.php" class="boton boton-verde">Volver</a>
        <?php elseif($rol === "2"): ?>
        <a href="/ventaAutos1/admin/empleado.php" class="boton boton-verde">Volver</a>
        <?php endif; ?>

        <table class="autos" border="2" bordercolor="#4b4b4b"">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>E-Mail</th>
                    <th>Teléfono</th>
                    <th>Mensaje</th>
                    <th>Auto de interes</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                <!-- Mostrar los resultados de la BD -->
                <?php while ($solicitud = mysqli_fetch_assoc($resultadoConsulta)) : ?>


                    <tr>
                        <td><?php echo $solicitud['clave'];  ?></td>
                        <td><?php echo $solicitud['nombre'];  ?> </td>
                        <td><?php echo $solicitud['email'];  ?></td>
                        <td><?php echo $solicitud['telefono'];  ?></td>
                        <td><?php echo $solicitud['mensaje'];  ?></td>
                        <td><?php echo $solicitud['autos_id'] . "-->" . $solicitud['marca'] . " " . $solicitud['modelo'];  ?></td>
                        
                        <!-- Verifica si una solicitud esta siendo atendida o no -->
                        <td>   
                        <?php if($solicitud['status'] === null):  ?>
                            No atendido
                        <?php else: ?>
                            Atendiendo:
                            <?php echo $solicitud['status']; ?>
                        <?php endif; ?>
                        </td>

                        <td>
                            <form method="POST" class="w-100">
                            <?php if ($solicitud['status'] === null): ?>
                            
                            <input type="hidden" name="status" value="<?php echo $nombre; ?>"> 
                            <input type="hidden" name="id" value="<?php echo $solicitud['clave']; ?>">
                            <br>
                            <input type="submit" style="border-radius: 1rem" class="boton-amarillo" value="Atender">
                            <?php endif; ?>
                            </form>

                            <!-- Eliminar - Obtener el id del registro -->
                            <form method="POST" class="w-100">
                            <br>
                            <input type="hidden" name="id" value="<?php echo $solicitud['clave']; ?>">
                            <input type="submit" style="border-radius: 1rem" class="boton-rojo-block" value="Eliminar">
                            <br>
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