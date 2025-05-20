<?php
// Este archivo contiene todas las funciones relacionadas con
// el acceso a la base de datos para el modulo de estudiantes.
//interactua con la base de datos usando SQL.



function getAllStudents($conn) {
    $sql = "SELECT * FROM students";
    return $conn->query($sql);
}
//Ejecuta una consulta SQL que selecciona
// todos los registros de la tabla students. 

//Usa ->query() directamente
// porque no hay entrada del usuario (no hay riesgo de inyección SQL). 

//Devuelve un objeto
// mysqli_result que se recorre en el controlador con fetch_assoc(). 




function getStudentById($conn, $id) {//Busca un estudiante por su id
    $sql = "SELECT * FROM students WHERE id = ?";
    //Esta es la consulta SQL con un placeholder (?) para evitar inyección SQL.

    $stmt = $conn->prepare($sql);
    // Prepara la consulta para que MySQL la compile y luego reciba los datos
    //De esta forma se mejora la seguridad y el rendimiento.

    $stmt->bind_param("i", $id);
    // enlaza el valor $id al ? de la consulta.
    // i indica que el parametro es entero.

    $stmt->execute();
    //ejecuta la consulta con el parametro ya insertado.
    return $stmt->get_result();
    // devuelve un objeto mysqli_result igual que con query()
    //este mismo se puede recorrer con fetch_assoc()
}
//$stmt Se usa cuando querés ejecutar una consulta segura, especialmente con datos del usuario.




function createStudent($conn, $fullname, $email, $age) {// Inserta un nuevo estudiante en la base de datos.
    $sql = "INSERT INTO students (fullname, email, age) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $fullname, $email, $age);
    //"ssi" indica los tipos de parametros (string,string, integer)


    return $stmt->execute();
    //devuelve true o false si la consulta tuvo exito. 
}

function updateStudent($conn, $id, $fullname, $email, $age) {// modifica los datos de un estudiante existente
    $sql = "UPDATE students SET fullname = ?, email = ?, age = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $fullname, $email, $age, $id);
    ////"ssii" indica los tipos de parametros (string,string, integer,integer)

    return $stmt->execute();
    // Siempre se utiliza prepare() y bind_param() para cualquier entrada externa
}

function deleteStudent($conn, $id) {// Elimina un estudiante por su id
    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>