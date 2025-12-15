<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__."/db.php";


//l'execution des scripts SQL de migration
//récupérer toutes les migrations SQL:

$direcory= __DIR__."/migrations/*.sql";

$files = glob(__DIR__."/migrations/*.sql");

sort($files);

foreach($files as $file)
{

    $name=basename($file);

    //vérifier si le fichier exécuté:
    $stmt= $conn->prepare("Select 1 from migrations where filename= ?");
    $stmt->bind_param("s",$file);
    $stmt->execute();

    if( $stmt->get_result()->num_rows==0)
    {

        echo "Exécution du fichier $name ";

        $requetteSQl= file_get_contents($file);

        if($conn->multi_query($requetteSQl))
        {
            while($conn->next_result()){}

                //enregistrer la migration
                $stmt= $conn->prepare("Insert into migrations (filename) values(?)");
                $stmt->bind_param("s",$name);
                $stmt->execute();

                echo "Done!\n";

        }
        else{
            echo "Erreur !: ".$conn->error;
            exit;

        }


    }



}
 
?>