<?php

session_start();

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

$auth = $_SESSION['login'];
$rol = $_SESSION['rol'];

// echo $rol;

if ($rol != ("1" || "2" )) {
    header('Location: /ventaAutos1/');
}

//Validar la URL por ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /ventaAutos1/admin/administrador/vendedores.php');
}

//BASE DE DATOS

require '../../includes/config/database.php';
$db = conectarDB();

//Obtener los datos de un auto
$consulta = "SELECT * FROM vendedores WHERE id = ${id} ";
$resultado = mysqli_query($db, $consulta);
$vendedor = mysqli_fetch_assoc($resultado);


//Arreglo con mensajes de errores
$errores = [];

$nombre = $vendedor['nombre'];
$apellido = $vendedor['apellido'];
$telefono = $vendedor['telefono'];


//Ejecuta el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $nombre = mysqli_real_escape_string($db,  $_POST['nombre']);
    $apellido = mysqli_real_escape_string($db,  $_POST['apellido']);
    $telefono = mysqli_real_escape_string($db,  $_POST['telefono']);
    


    if (!$nombre) {
        $errores[] = "Debes ingresar un nombre";
    }

    if (!$apellido) {
        $errores[] = "Debes ingresar los apellidos";
    }

    // //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {

        //INSERTAR EN LA BD
        $query = "UPDATE vendedores SET nombre = '${nombre}', apellido = '${apellido}',
            telefono= '${telefono}' WHERE id = ${id} ";


        echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // echo "Insertado correctamente";
            // Redireccionar al usuario
            header('Location: /ventaAutos1/admin/administrador/vendedores.php?resultado=2');
        }
    }
}

require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar empleado</h1>

    <a href="vendedores.php" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Información general</legend>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del vendedor" value="<?php echo $nombre; ?>">

            <label for="apellido">Apellidos: </label>
            <input type="text" id="apellido" name="apellido" placeholder="Apellidos del vendedor" value="<?php echo $apellido; ?>">

            <label for="telefono">Teléfono: </label>
            <input type="number" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">

        </fieldset>

        <br>

        <input type="submit" value="Actualizar registro" class="boton boton-verde">

    </form>

</main>

<?php
incluirTemplate('footer');
?>