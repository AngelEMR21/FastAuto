<?php

    session_start();

    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";

    $auth = $_SESSION['login'];
    $rol = $_SESSION['rol'];

    if($rol != "2"){
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

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $puertas = '';
    $marca = '';
    $modelo = '';
    $vendedor = '';
    $creado = date('y/m/d');

    //Ejecuta el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        $titulo = mysqli_real_escape_string($db,  $_POST['titulo']);
        $precio = mysqli_real_escape_string($db,  $_POST['precio']);
        $descripcion = mysqli_real_escape_string($db,  $_POST['descripcion']);
        $puertas = mysqli_real_escape_string($db,  $_POST['puertas']);
        $marca = mysqli_real_escape_string($db,  $_POST['marca']);
        $modelo = mysqli_real_escape_string($db,  $_POST['modelo']);
        $vendedor = mysqli_real_escape_string($db,  $_POST['vendedor']);

        //Asignar files hacia una variable
        $imagen = $_FILES['imagen'];

        if(!$titulo){
            $errores[] = "Debes añadir un titulo";
        }

        if(!$precio){
            $errores[] = "Precio obligatorio";
        }

        if(strlen($descripcion) < 50){
            $errores[] = "La descripción es obligatoria y debe tener al menos 
            50 caracteres";
        }

        if(!$puertas){
            $errores[] = "El auto no tiene puertas?";
        }

        if(!$marca){
            $errores[] = "Debes añadir la marca";
        }

        if(!$modelo){
            $errores[] = "Indica el modelo";
        }

        if(!$vendedor){
            $errores[] = "Elige un vendedor";
        }

        if(!$imagen['name'] || $imagen['error']){
            $errores[] = "Imagen obligatoria";
        }

        //Validar por tamaño (1mb de máximo)
        $medida= 1000*1000;
        if($imagen['size']>$medida){
            $errores[] = 'La imagen es muy pesada';
        }


        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        //Revisar que el arreglo de erorres este vacio
        if(empty($errores)){

            // Subida de archivos
            //Crear una carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            //Generar un nombre único
            $nombreImagen = md5( uniqid(rand(), true) ) . ".jpg";

            //Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            


            //INSERTAR EN LA BD
            $query = "INSERT INTO autos (titulo, precio, imagen, descripcion, puertas, marca, 
            modelo, creado, vendedores_id) VALUES ( '$titulo', '$precio', '$nombreImagen ', '$descripcion', '$puertas',
            '$marca', '$modelo', '$creado', '$vendedor' )";

            // echo $query;

            $resultado = mysqli_query($db, $query);

            if($resultado){
                // echo "Insertado correctamente";
                // Redireccionar al usuario
                header('Location: /ventaAutos1/admin/empleado.php?resultado=1');
            }




            


        }
        
    }

    require '../../includes/funciones.php';    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="../empleado.php" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php  echo $error; ?>
            </div>
            
        <?php endforeach ?>

        <form class="formulario" method="POST", action="/ventaAutos1/admin/empleados/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Información general</legend>
                <label for="titulo">Titulo: </label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo de la publicación" value="<?php echo $titulo;?>">

                <label for="precio">Precio: </label>
                <input type="number" id="precio" name="precio" placeholder="Precio del auto" value="<?php echo $precio;?>">

                <label for="imagen">Imagen: </label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripción del auto: </label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion;?></textarea>

            </fieldset>

            <fieldset>
                <legend>Información del auto</legend>
                <label for="puertas">Puertas: </label>
                <input type="number" id="puertas" name="puertas" placeholder="Numero de puertas del auto" min="1" max="5" value="<?php echo $puertas;?>">

                <label for="marca">Marca: </label>
                <input type="text" id="marca" name="marca" placeholder="Marca correspondiente al auto" value="<?php echo $marca;?>">

                <label for="modelo">Modelo: </label>
                <input type="text" id="modelo" name="modelo" placeholder="Modelo del auto" value="<?php echo $modelo;?>">

            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor" >
                    <option value="">-- Selecione un vendedor--</option>
                    <!-- <option value="1">Angel Martínez</option>
                    <option value="2">Noe Díaz</option> -->
                    <!-- Se llama vendedor2, ya que inicialmente vendedor normal era vendedor_Id  -->
                    <?php while($vendedor2 = mysqli_fetch_assoc($resultado)): ?>
                        <option <?php echo $vendedor == $vendedor2['id'] ? 'selected' : '';  ?>  
                        value="<?php echo $vendedor2['id']; ?>"> <?php echo $vendedor2['nombre']. " " . 
                        $vendedor2['apellido']; ?> </option>

                    <?php endwhile; ?>

                    
                </select>
               

            </fieldset>
            <br>

            <input type="submit" value="Crear registro" class="boton boton-verde">

        </form>

    </main>

<?php
    incluirTemplate('footer');
?>