<?php
 session_start();
include_once "../bd/conexion.php";

if(isset($_POST['continue'])){
    $user=$_POST['user'];
    $pass=$_POST['pass'];


    $sqllo = "SELECT * from users WHERE usuario='$user' and password='$pass'";
    $query5 = $conn->prepare($sqllo);
    $query5->execute();
    $numeroDeFilas5 = $query5->rowCount();

    if($numeroDeFilas5 > 0){
               
        if($user==1010){
            $_SESSION['user']='as';
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/lista.php");
        }
        if($user==1023){
            $_SESSION['user']='as';
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/hsbc/consultaHSBC.php");
        }
        if($user==1012){
            $_SESSION['user']='as';
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/movistar/consultamov.php");

        }
        if($user==1008){
            $_SESSION['user']='as';
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/admin/lista.php");

        }
        if($user==1009){
            $_SESSION['user']='as';
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/adm/lista.php");
        }
    
    }
    else{

        $_SESSION['error']="Datos erroneos";
        header("Location: http://192.168.100.200:50/asistencias_empleados/");
       
        // header("Location: http://localhost/asistencias_empleados/vistas/consulta_diaespecifico.php");
    }
  

}