<?php

    // Sāk jaunu sesiju vai atjauno esošo sesiju
    session_start();

    // Pārbauda, vai lietotājs ir pierakstījies sistēmā
    if(!(isset($_SESSION['logged-in']))){
        // Ja nav pierakstījies, pāradresē uz ieejas lapu
        header('Location: login.php');
        exit();
    }

    // Pārbauda, vai ir saņemti nepieciešamie GET parametri
    if(!(isset($_GET['sn']))){
        // Ja nav saņemti parametri, pāradresē uz galveno lapu
        header('Location: index.php');
        exit();
    }

    // Iekļauj datubāzes savienojumu
    require_once "connect.php";

    // Izveido jaunu datubāzes savienojumu
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    // Pārbauda, vai nav bijis savienojuma kļūdas
    if($connection->connect_errno!=0){
        echo "Kļūda: ".$connection->connect_errno . "<br>";
        echo "Apraksts: " . $connection->connect_error;
        exit();
    }

    // Iegūst nepieciešamos GET parametrus
    $shortName = $_GET['sn'];
    $taskNum = $_GET['tn'];
    $newStatus = $_GET['status'];

    // Izveido SQL vaicājumu, lai atjaunotu uzdevuma stāvokli
    $sql = "UPDATE tasks SET state = '$newStatus' WHERE project_short_name = '$shortName' AND project_task_num = '$taskNum'";

    // Izpilda SQL vaicājumu un pārbauda rezultātu
    if($result = $connection->query($sql)){
        // Ja izpilde veiksmīga, pāradresē uz projektu paneli
        header("Location: board.php?sn=$shortName");
    }
    else{
        // Ja ir kļūda izpildot SQL vaicājumu
        echo '<span class="error-msg">SQL kļūda</span>';
    } 

?>
