<?php

require_once __DIR__ . "/../includes/db_connect.php";

function getAllFilms()
{
    // Validation des données : à venir
    global $conn;
    $req = "SELECT * From films ORDER BY titre ASC";
    $result = $conn->query($req);

    if (!$result) {
        die("Erreur de récupération des films:" . $conn->error);
    }

    return $result;
}


function getById($id)
{
    // Validation des données : à venir
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM films WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows === 0) {
        return null;
    }

    return $result->fetch_assoc();
}
?>