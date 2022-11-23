<?php

session_start();

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

$auth = $_SESSION['login'];
$rol = $_SESSION['rol'];

// echo $rol;

if ($rol != "1") {
    header('Location: /ventaAutos1/');
}

//BASE DE DATOS

require '../../includes/config/database.php';
$db = conectarDB();

//Consultar para tener a los vendedores
$consulta = "SELECT * FROM usuarios";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$nombre = '';
$apellidos = '';
$email = '';
$telefono = '';
$password = '';
$rolE = '';


//Ejecuta el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nombre = mysqli_real_escape_string($db,  $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($db,  $_POST['apellidos']);
    $email  = mysqli_real_escape_string($db,  $_POST['email']);
    $telefono = mysqli_real_escape_string($db,  $_POST['telefono']);
    $password = mysqli_real_escape_string($db,  $_POST['password']);
    $rolE = mysqli_real_escape_string($db,  $_POST['rolE']);

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);


    if (!$nombre) {
        $errores[] = "Debes ingresar un nombre";
    }

    if (!$apellidos) {
        $errores[] = "Debes ingresar los apellidos";
    }

    if (!$email) {
        $errores[] = "Ingrese un E-mail";
    }

    if (!$telefono) {
        $errores[] = "Ingrese un teléfono";
    }

    if (!$password) {
        $errores[] = "Capture una contraseña para el empleado";
    }
    if (!$rolE) {
        $errores[] = "Asigne un rol para el empleado";
    }


    //Revisar que el arreglo de erorres este vacio
    if (empty($errores)) {

        //INSERTAR EN LA BD
        $query = "INSERT INTO usuarios (nombre, apellidos, email, telefono, password, rol) VALUES ( '$nombre', '$apellidos', '$email', '$telefono', '$passwordHash', '$rolE')";

        // echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // echo "Insertado correctamente";
            // Redireccionar al usuario
            header('Location: /ventaAutos1/admin/administrador/empleados.php?resultado=1');
        }
    }
}

require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Registro de empleados</h1>

    <a href="empleados.php" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach ?>

    <form class="formulario" method="POST" , action="/ventaAutos1/admin/administrador/crearEmpleado.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información general</legend>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del empleado" value="<?php echo $nombre; ?>">

            <label for="apellidos">Apellidos: </label>
            <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos del empleado" value="<?php echo $apellidos; ?>">

            <label for="email">E-mail: </label>
            <input type="email" id="email" name="email" placeholder="Correo" value="<?php echo $email; ?>">

            <label for="telefono">Teléfono: </label>
            <input type="number" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo $telefono; ?>">

            <label for="password">Contraseña: </label>
            <input type="password" id="password" name="password" placeholder="Contraseña" value="<?php echo $password; ?>">

            <!-- <label for="rolE">Rol: </label>
            <input type="number" id="rolE" name="rolE" placeholder="Rol" value="<?php echo $rolE; ?>"> -->

        </fieldset>

        <!-- Asignacion de rol -->
        <fieldset>
            <legend>Rol</legend>
            <select name="rolE">
                <option value="">-- Seleccione un rol--</option>
                <option value="1">Administrador</option>
                <option value="2">Empleado</option>
            </select>
        </fieldset>

        <br>

        <input type="submit" value="Crear registro" class="boton boton-verde">

    </form>

</main>

<?php
incluirTemplate('footer');
?>