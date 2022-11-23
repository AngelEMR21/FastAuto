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

//Validar la URL por ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /ventaAutos1/admin/administrador/empleados.php');
}

//BASE DE DATOS

require '../../includes/config/database.php';
$db = conectarDB();

//Obtener los datos de un auto
$consulta = "SELECT * FROM usuarios WHERE id = ${id} ";
$resultado = mysqli_query($db, $consulta);
$empleado = mysqli_fetch_assoc($resultado);


//Arreglo con mensajes de errores
$errores = [];

$nombre = $empleado['nombre'];
$apellidos = $empleado['apellidos'];
$email = $empleado['email'];
$telefono = $empleado['telefono'];
$password = $empleado['password'];
$rolE = $empleado['rol'];

//Ejecuta el código después de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

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



    // //Revisar que el arreglo de errores este vacio
    if (empty($errores)) {

        //INSERTAR EN LA BD
        $query = "UPDATE usuarios SET nombre = '${nombre}', apellidos = '${apellidos}', email = '${email}',
            telefono= '${telefono}', password = '${passwordHash}', rol = '${rolE}'  WHERE id = ${id} ";


        echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // echo "Insertado correctamente";
            // Redireccionar al usuario
            header('Location: /ventaAutos1/admin/administrador/empleados.php?resultado=2');
        }
    }
}

require '../../includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar empleado</h1>

    <a href="empleados.php" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>

    <?php endforeach ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
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
        </fieldset>

        <!-- Asignacion de rol actualizar -->
        <fieldset>
            <legend>Rol</legend>
            <select name="rolE">
                <option value="">-- Seleccione un rol--</option>
                <?php if($empleado['rol']==="1"): ?>
                <option value="1" selected>Administrador</option>
                <option value="2">Empleado</option>
                <?php elseif($empleado['rol']==="2"): ?>
                <option value="1">Administrador</option>
                <option value="2" selected>Empleado</option>
                <?php endif; ?>

            </select>
        </fieldset>

        <br>

        <input type="submit" value="Actualizar registro" class="boton boton-verde">

    </form>

</main>

<?php
incluirTemplate('footer');
?>