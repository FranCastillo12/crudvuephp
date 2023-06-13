<?php

// connect database
$conn = new PDO("mysql:host=tiusr9pl.cuc-carrera-ti.ac.cr;dbname=tiusr9pl_CrudAgendaphp", "CrudPHP", "*Cj9a2y42");

// delete the user from database
$sql = "DELETE FROM Agenda WHERE nombre = :nombre";
$result = $conn->prepare($sql);
$result->execute(array(
    ":nombre" => $_POST["nombre"]
));

// send the response back to AJAX
echo "Done";