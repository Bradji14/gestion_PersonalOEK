<?php

  // session_start();

// require "../../bd/conexion.php";

// $sql = "SELECT * FROM empleado";

// $resultado = $conn->query($sql);


if(isset($_POST['save'])){
 
  // $_SESSION['error']="campos vacios";
    $nom1=$_POST['nom1'];
    $nom2=$_POST['nom2'];
    // $name1=$_POST['nameo'];
    // $name2=$_POST['namet'];
    $turn1=$_POST['turnoreq1'];
    $turn2=$_POST['turnoreq2'];
    $motivo=$_POST['motivo'];
    $date=$_POST['date'];


    if(!empty($nom1) && !empty($nom2) && !empty($turn1) && !empty($turn2) && !empty($motivo) && !empty($date)){
       // sentencia sql
       
       //---------------------tabla de permutas-------------------
    //    id int
    //    id_usuario1 int
    //    id_usuario2 int
    //    id_turno_usuario1 int
    //    id_turno_usuario2 int
    //    id_turnoInterers1
    //    id_turnoInterers2
    //    motivo varchar 100
    //    fecha date
    
    }
    else{
      
      header("Location: http://192.168.100.200:50/asistencias_empleado/vistas/permutas.php");
      
      // echo 'datos vacios';
      //header
  
    }
          // $_SESSION['error']="campos vacios";

}


?>