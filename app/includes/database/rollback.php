<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__."/db.php";

// recuperer la derniere migration appliquee
$last = $conn->query("select filename from migrations order by dateApplication desc limit 1")->fetch_assoc();   
$lastFile = $last['filename'];//001_add_role_to_admins.sql

$NomfichierRolleback =str_replace(".sql",".rollback.sql",$lastFile);


//chercher le fichier de rollback
$filepath = __DIR__."/rollbacks/".$NomfichierRolleback;

if(!file_exists($filepath))
    die("No rollback script for the $$lastFile \n");
else{

    echo "Rolling back : $lastFile";
    $sql=file_get_contents($filepath);

    if($conn->multi_query($sql))
    {
        while($conn->next_result()){}
        echo "\n delete from migrations where filename=' $lastFile' \n";
        $conn->query("delete from migrations where filename= '$lastFile' ");
        echo "Rollback Done!";
    }
    else
    {
        echo "erreur : ".$conn->error;
    }


}







//==> 001_add_role_to_admins.rollback.sql






?>