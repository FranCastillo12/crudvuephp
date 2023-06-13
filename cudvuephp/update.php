<?php

// connect database
$conn = new PDO("mysql:host=tiusr9pl.cuc-carrera-ti.ac.cr;dbname=tiusr9pl_CrudAgendaphp", "CrudPHP", "*Cj9a2y42");

// update user name and email using his unique ID
$sql = "UPDATE Agenda SET nombre = :nombre, apellidos = :apellidos,direccion = :direccion,telefono = :telefono,edad = :edad,altura = :altura  WHERE nombre = :nombre";
$result = $conn->prepare($sql);

$result->execute([
	":nombre" => $_POST["nombre"],
	":apellidos" => $_POST["apellidos"],
	":direccion" => $_POST["direccion"],
	":telefono" => $_POST["telefono"],
	":edad" => $_POST["edad"],
	":altura" => $_POST["altura"]
]);

// get the updated record
$sql = "SELECT * FROM Agenda WHERE nombre = :nombre ";
$result = $conn->prepare($sql);
$result->execute(array(
    ":nombre" => $_POST["nombre"]
));
$data = $result->fetch();

// send the updated record back to AJAX
echo json_encode($data);