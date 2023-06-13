<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// connect database
$conn = new PDO("mysql:host=tiusr9pl.cuc-carrera-ti.ac.cr;dbname=tiusr9pl_CrudAgendaphp", "CrudPHP", "*Cj9a2y42");

// prepare insert statement
$sql = "INSERT INTO agenda(nombre,apellidos,direccion,telefono,edad,altura) VALUES (:nombre, :apellidos, :direccion,:telefono,:edad,:altura)";
$result = $conn->prepare($sql);

// execute the query
$result->execute([
	":nombre" => $_POST["nombre"],
	":apellidos" => $_POST["apellidos"],
	":direccion" => $_POST["direccion"],
	":telefono" => $_POST["telefono"],
	":edad" => $_POST["edad"],
	":altura" => $_POST["altura"],
]);

// get the latest record inserted
$sql = "SELECT * FROM Agenda WHERE nombre = :nombre";
$result = $conn->prepare($sql);
$result->execute(array(
    ":id" => $conn->lastInsertId()
));
$data = $result->fetch();

// send the newly inserted record back to AJAX
echo json_encode($data);