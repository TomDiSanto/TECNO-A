<?php
require_once("./config/databaseConfig.php");
// Incluye el archivo de configuracion de la base de datos.
// Utiliza require_once para evitar la duplicacion del mismo.
// Este archivo crea la variable $conn con el objetivo de interactuar con MySQLi



require_once("./controllers/studentsController.php");
//Este archivo contiene las funciones handleGet(), handlePost(), etc.
//Estas funciones se utilizan para implementar la logica del CRUD.




switch ($_SERVER['REQUEST_METHOD']) {  //lee el metodo HTTP con el que se hizo la solicitud POR ejemplo(GET, POST,etc)
    case 'GET':
        handleGet($conn);
        break;
        //Detecta una petición GET y llama a la función handleGet(), pasándole la 
        //conexión a la base de datos para que recupere los datos 
        //y los muestre al cliente
    case 'POST':
        handlePost($conn);
        break;
    case 'PUT':
        handlePut($conn);
        break;
    case 'DELETE':
        handleDelete($conn);
        break;
        default://si el metodo no es ninguno de los anteriores
        http_response_code(405);//responde con un 405 (Method Not Allowed) 
        echo json_encode(["error" => "Método no permitido"]);//Y un mensaje
        //JSON significa JavaScript Object Notation.
        //Es un formato de texto liviano que se usa para intercambiar
        // datos entre el servidor y el navegador, o entre aplicaciones.
        break;
}
?>