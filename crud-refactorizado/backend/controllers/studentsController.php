<?php
// controller = maneja las peticiones, llama al modelo y devuelve la respuesta adecuada
//Este archivo contiene funciones específicas para manejar las
// 9 solicitudes HTTP según el tipo de operación que se quiera hacer sobre los estudiantes: 
//obtener, crear, actualizar o eliminar. 


require_once("./models/students.php");
// importa las funciones del modelo students.php, en el estan definidas:
//getAllStudents()  getStudentById()  createStudent()  updateStudent()  deleteStudent() 

// El controlador tiene como objetivo manejar las peticiones, pero el que se encarga
// de acceder a la base de datos es el modulo.




function handleGet($conn) {
    //esta funcion unicamente se ejecuta cuando el metodo HTTP es get 
    if (isset($_GET['id'])) {//si se pasa un id por la URL (ejemplo: ?id=3)
        $result = getStudentById($conn, $_GET['id']);
        echo json_encode($result->fetch_assoc());
        //unicamente se devuelve ese estudiante
    } else {//Si no, devuelve la lista completa
        $result = getAllStudents($conn);
        $data = [];
        while ($row = $result->fetch_assoc()) {//fetch-assoc convierte cada fila en un array asociativo
            $data[] = $row;
        }
        echo json_encode($data);// transforma los datos a JSON para que el frontend pueda interpretarlos.
    }
}

function handlePost($conn) {
    //Esta funcion se encarga de crear un nuevo estudiante con datos enviados
    //con formato JSON
    $input = json_decode(file_get_contents("php://input"), true);
    if (createStudent($conn, $input['fullname'], $input['email'], $input['age'])) {
        // si se logra crear el estudiante responde con un mensaje.
        echo json_encode(["message" => "Estudiante agregado correctamente"]);
    } else {
        http_response_code(500);
        //si falla responde con error 500;
        echo json_encode(["error" => "No se pudo agregar"]);
    }
}
//file_get_contents("php://input"): obtiene el cuerpo crudo de la solicitud. 
//json_decode(..., true): convierte el JSON en un array PHP. 






function handlePut($conn) {
    //Se utiliza cuando el cliente quiere editar un estudiante
    $input = json_decode(file_get_contents("php://input"), true);
    if (updateStudent($conn, $input['id'], $input['fullname'], $input['email'], $input['age'])) {
        // Si se logra modificar devuelve un mensaje
        echo json_encode(["message" => "Actualizado correctamente"]);
    } else {
        http_response_code(500);
        // si no se logra modificar devuelve un error 500(error intrno del servidor)
        echo json_encode(["error" => "No se pudo actualizar"]);
    }
}
//se necesita el id del estudiate para poder modificarlo
//llama a updateStudent() internamente


function handleDelete($conn) {
    // Se utiliza cuando se quiere eliminar un estudiante
    $input = json_decode(file_get_contents("php://input"), true);
    if (deleteStudent($conn, $input['id'])) {
        echo json_encode(["message" => "Eliminado correctamente"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo eliminar"]);
    }
}
// elimina al estudiante cuyo id se recibe por JSON
// el que se encarga de ejecutar el delete en la base de datoses el modelo 
?>