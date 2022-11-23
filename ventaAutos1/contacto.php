<?php
    //BASE DE DATOS

    require 'includes/config/database.php';
    $db = conectarDB();

    //Consultar para tener a los vendedores
    $consulta = "SELECT * FROM autos";
    $resultado = mysqli_query($db, $consulta);

    //Muestra mensaje condicional
    $estado = $_GET['estado'] ?? null;

    //Arreglo con mensajes de errores
    $errores = [];
    $nombre = '';
    $email = '';
    $telefono = '';
    $mensaje = '';
    $auto = '';

    //Ejecuta el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $nombre = mysqli_real_escape_string($db,  $_POST['nombre']);
        $email = mysqli_real_escape_string($db,  $_POST['email']);
        $telefono = mysqli_real_escape_string($db,  $_POST['telefono']);
        $mensaje = mysqli_real_escape_string($db,  $_POST['mensaje']);
        $auto = mysqli_real_escape_string($db,  $_POST['auto']);

        if(!$nombre){
            $errores[] = "Debes añadir un nombre";
        }

        if(!$email){
            $errores[] = "email obligatorio";
        }

        if(!$telefono){
            $errores[] = "telefono obligatorio";
        }
        if(!$mensaje){
            $errores[] = "mensaje obligatorio";
        }
        if(!$auto){
            $errores[] = "auto obligatorio";
        }

        //Revisar que el arreglo de erorres este vacio
        if(empty($errores)){

            //INSERTAR EN LA BD
            $query = "INSERT INTO solicitudes (nombre, email, telefono, mensaje, autos_id) 
            VALUES ( '$nombre', '$email', '$telefono', '$mensaje', '$auto')";

            // echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado){
                // echo "Insertado correctamente";
                // Redireccionar al usuario
                header('Location: /ventaAutos1/contacto.php?estado=1');
            }
        }
        
    }

    require 'includes/funciones.php';    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Contacto</h1>
        <picture>
            <img loading="lazy" src="build/img/contacto.jpg" alt="Imagen Contacto">
        </picture>
        <?php if (intval($estado) === 1) : ?>
        <p class="alerta exito">Se ha enviado tu solicitud, te contactaremos a la brevedad</p>
        <?php endif; ?>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php  echo $error; ?>
            </div>
            
        <?php endforeach ?>

        <form class="formulario" method="POST", action="/ventaAutos1/contacto.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Información personal</legend>
                <label for="nombre">Nombre: </label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre de interesado" value="<?php echo $nombre;?>">

                <label for="email">E-Mail: </label>
                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $email;?>">

                <label for="telefono">Teléfono: </label>
                <input type="number" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo $telefono;?>">

                
                <label for="mensaje">Mensaje: </label>
                <textarea id="mensaje" name="mensaje"><?php echo $mensaje;?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información del auto</legend>
                <label for="auto">Seleccione el auto de interes</label>
                <select name="auto" >
                    <option value="">-- Autos disponibles --</option>
                    <!-- <option value="1">Angel Martínez</option>
                    <option value="2">Noe Díaz</option> -->
                    <!-- Se llama vendedor2, ya que inicialmente vendedor normal era vendedor_Id  -->
                    <?php while($auto2 = mysqli_fetch_assoc($resultado)): ?>
                        <option <?php echo $auto == $auto2['id'] ? 'selected' : '';  ?>  
                        value="<?php echo $auto2['id']; ?>"> <?php echo $auto2['marca']. " " . 
                        $auto2['modelo']; ?> </option>

                    <?php endwhile; ?>

                    
                </select>
               

            </fieldset>
            <br>

            <input type="submit" value="Enviar" class="boton boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>