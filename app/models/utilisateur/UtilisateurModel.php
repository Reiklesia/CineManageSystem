<?php

function Authentification($nomUtilisateur, $motDePasse)
{

    global $conn;

    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ? and mot_de_passe = ?");
    $stmt->bind_param("ss", $nomUtilisateur, $motDePasse);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return false;
    }

    return $result->fetch_assoc();
}


?>