<?php
session_start();
require_once "connect.php";

// Izveido jaunu datu bāzes savienojumu, izmantojot dati no connect.php
$connection = new mysqli($host, $db_user, $db_password, $db_name);

// Iegūst saīsināto projektu nosaukumu no GET parametra
$shortName = $_GET['sn'];

// Pārbauda, vai nav bijis savienojuma kļūdas
if($connection->connect_errno!=0){
    echo "Kļūda: ".$connection->connect_errno . "<br>";
    echo "Apraksts: " . $connection->connect_error;
    exit();
}
else{
    // Iegūst uzdevuma nosaukumu un aprakstu no POST datiem
    $taskTitle = $_POST['taskTitle'];
    $taskDescription = $_POST['taskDescription'];

    // Izveido SQL vaicājumu, lai iegūtu uzdevumu skaitu projektā
    $sqlCount = "SELECT * FROM `tasks` WHERE `project_short_name` = '$shortName'";

    // Izpilda SQL vaicājumu, lai iegūtu uzdevumu skaitu
    if($result = $connection->query($sqlCount)){
        $taskCount = $result->num_rows+1;

        // Izveido SQL vaicājumu, lai pievienotu jaunu uzdevumu datu bāzē
        $sql = "INSERT INTO `tasks`(`id`, `project_short_name`, `project_task_num`, `task_name`, `task_desc`, `state`) VALUES (NULL,'$shortName','$taskCount','$taskTitle','$taskDescription',1)";

        // Izpilda SQL vaicājumu, lai pievienotu jaunu uzdevumu
        if($connection->query($sql)){
            // Pāradresē uz projektu paneli, kur ir redzams jaunais uzdevums
            header('Location: board.php?sn='.$shortName);
        }
        else{
            echo '2. SQL kļūda';
        }
    }
    else{
        echo '1. SQL kļūda';
    }
    // Aizver datu bāzes savienojumu
    $connection->close();
}
?>
