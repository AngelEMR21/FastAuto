<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost', 'root', 'mysql02', 'autos_crud');

    if(!$db){
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
}