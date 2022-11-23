<?php

    require 'includes/config/database.php';
    $db = conectarDB();


    //Autenticar el usuario

    $errores = [];


    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ;
        $password = mysqli_real_escape_string($db , $_POST['password']);

        if(!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }
        
        if(!$password){
            $errores[] = "El password es obligatorio";
        }

        if(empty($errores)){

            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($db, $query);

            if($resultado -> num_rows){
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                //Verificar si el password es correcto o no
                $auth = password_verify($password, $usuario['password']);

                if($auth){
                    //El usuario esta autenticado
                    session_start();

                    //Llenar el arreglo de la sesión
                    $_SESSION['usuario'] = $usuario['email'];
                    
                    //Identifica el tipo de usuario
                    $_SESSION['rol'] = $usuario['rol'];

                    //Verifica si el usuario esta autentificado
                    $_SESSION['login'] = true;

                    //Obtener nombre de usuario
                    $_SESSION['nombre'] = $usuario['nombre'];

                    // echo "<pre>";
                    // var_dump($_SESSION);
                    // echo "</pre>";

                    //Redirigir al usuario según rol
                    if($_SESSION['rol'] === "1" ){
                        header('Location: /ventaAutos1/admin/administrador.php');
                    } else if ($_SESSION['rol'] === "2" ){
                        header('Location: /ventaAutos1/admin/empleado.php');
                    }

                }else{
                    $errores[] = "El password es incorrecto";
                }

            } else {
                $errores[] =  "El usuario no existe";

            }


        }


    }

    //Incluye el header
    require 'includes/funciones.php';    
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php  foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php  endforeach;   ?>

        <form method="POST" class="formulario" novalidate>
        <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email" >

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password" >
               
            </fieldset>
            <br>

            <center>
            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
            </center>

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>