<?php
/**
 * DEBUG MODE
 */
ini_set('display_errors', 1); //Le indica a PHP que muestre los errores directamente en pantalla
error_reporting(E_ALL);  //Muestra todos los tipos de errores
//Esto debe desactivarse en producción (sitios reales) para evitar mostrar detalles internos al usuario final. 


header("Access-Control-Allow-Origin: *");//Permite que cualquier frontend (desde cualquier origen *) pueda acceder al backend. 
//Es parte de CORS (Cross-Origin Resource Sharing), necesario cuando el frontend y backend no están en el mismo dominio o puerto. 

header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
//Le indica al navegador qué métodos HTTP acepta el backend. 


header("Access-Control-Allow-Headers: Content-Type");
// permite al navegador enviar encabezados personalizados

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

//require_once("./routes/studentsRoutes.php");
//Incluye el archivo que define las rutas o la lógica que responderá a la petición actual. 
// Usa require_once para incluirlo solo una vez
//Este archivo debería analizar la URL, método y decidir qué controlador invocar. 

// 🔽 Detectar el módulo (por URL: ?module=students, teachers, etc.)
$module = $_GET['module'] ?? 'students'; // Por defecto usa 'students'
//Lee el parámetro module de la URL.
//Si no está definido, usa "students" como valor por defecto.


// 🔽 Determinar qué archivo de rutas incluir
$routesFile = "./routes/{$module}Routes.php";

// 🔽 Incluir el archivo si existe
if (file_exists($routesFile)) {
    require_once($routesFile);
} else {
    http_response_code(404);//El servidor no encontró el recurso solicitado (archivo, ruta, página, módulo, etc.).
    echo json_encode(["error" => "Módulo '$module' no encontrado"]);
}



?>
