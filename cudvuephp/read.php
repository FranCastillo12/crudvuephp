<?php

// connect database
$conn = new PDO("mysql:host=tiusr9pl.cuc-carrera-ti.ac.cr;dbname=tiusr9pl_CrudAgendaphp", "CrudPHP", "*Cj9a2y42");

// get all users from database sorted by latest first
$sql = "SELECT * FROM agenda";
$result = $conn->prepare($sql);
$result->execute([]);
$data = $result->fetchAll();

// send all records fetched back to AJAX
echo json_encode($data);
