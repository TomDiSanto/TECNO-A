<?php
//Este archivo configura y establece una conexión con la base de datos MySQL usando la extensión MySQLi (MySQL Improved).


$host = "localhost";
//$host servidor de base de datos. "localhost" indica que la base de datos está en el mismo servidor que el script PHP. 

$user = "students_user";
//$user: nombre de usuario de MySQL autorizado para acceder a la base de datos.

$password = "12345";
//$password: contraseña del usuario MySQL. 


$database = "students_db";
//$database: nombre de la base de datos que se va a usar. 




$conn = new mysqli($host, $user, $password, $database);
// Se crea un objeto MySQLi y se establece la conexion usando las credenciales anteriores.
//Este objeto ($conn) se usará luego en todos los models y controllers para ejecutar consultas. 
//Modelo = se conecta con la base de datos y representa las "cosas" (estudiantes, materias...).
// Controlador = maneja las peticiones, llama al modelo y devuelve la respuesta adecuada.





if ($conn->connect_error) {// verifica si hay un error en la conexion
    // si hay un error en la conexion
    http_response_code(500);//Responde con un código HTTP 500 Internal Server Error.  
    die(json_encode(["error" => "Database connection failed"]));//Envía un mensaje JSON con una clave error. 
    //usa die para detener la ejecucion de la script inmediatamente.
}
?>