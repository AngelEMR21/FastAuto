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

//BASE DE DATOS

require '../../includes/config/database.php';
$db = conectarDB();

//Consultar para tener a los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$nombre = '';
$apellido = '';
$telefono = '';


//Ejecuta el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nombre = mysqli_real_escape_string($db,  $_POST['nombre']);
    $apellido = mysqli_real_escape_string($db,  $_POST['apellido']);
    $telefono = mysqli_real_escape_string($db,  $_POST['telefono']);

    if (!$nombre) {
        $errores[] = "Debes ingresar un nombre";
    }

    if (!$apellido) {
        $errores[] = "Debes ingresar los apellidos";
    }

    if (!$telefono) {
        $errores[] = "Ingrese un teléfono";
    }


    //Revisar que el arreglo de erorres este vacio
    if (empty($errores)) {

        //INSERTAR EN LA BD
        $query = "INSERT INTO vendedores (nombre, apellido, telefono) VALUES ( '$nombre', '$apellido', '$telefono')";

        // echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // echo "Insertado correctamente";
            // Redireccionar al usuario
            header('Location: /ventaAutos1/admin/administrador/vendedores.php?resultado=1');
        }
    }
}

require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Registro de vendedores</h1>

    <a href="vendedores.php" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach ?>

    <form class="formulario" method="POST" , action="/ventaAutos1/admin/administrador/crearVendedor.php" enctype="multipart/form-data">
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

        <input type="submit" value="Crear registro" class="boton boton-verde">

    </form>

</main>

<?php
incluirTemplate('footer');
?>