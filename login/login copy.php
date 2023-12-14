<?php
 session_start();
include_once "../bd/conexion.php";

if(isset($_POST['continue'])){
    $user=$_POST['user'];
    $pass=$_POST['pass'];

    // $sqltres = "UPDATE `users` SET `password`= '".$pass."' WHERE usuario = '$user'";
    // $query = $conn->prepare($sqltres);
    // $query->execute();

    // header("Location: http://localhost/asistencias_empleados/index.php");

    $sql=$conn->prepare("SELECT * FROM users WHERE usuario ='$user' AND password='$pass'");
    // $query = $conn->prepare($sql);
    // $query->execute();
    # Ver cuántas filas devuelve


    $sql->bindParam("user",$user,PDO::PARAM_STR);
    $sql->bindParam("pass",$pass,PDO::PARAM_STR);
    $sql->execute();

    $res = $sql->fetch(PDO::FETCH_ASSOC);

    // print_r($res);
    
    $numeroDeFilas = $sql->rowCount();

    if($numeroDeFilas>=1){
               
        if($user==1010){
            $_SESSION['user']=$res;
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/lista.php");
        }
        if($user==1023){
            $_SESSION['user']=$res;
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/hsbc/consultaHSBC.php");
        }
        if($user==1012){
            $_SESSION['user']=$res;
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/movistar/consultamov.php");

        }
        if($user==1008){
            $_SESSION['user']=$res;
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/admin/lista.php");

        }
    
    }
    else{
        session_start();

        $_SESSION['error']="Datos erroneos";
        header("Location: http://192.168.100.200:50/asistencias_empleados/");
       
        // header("Location: http://localhost/asistencias_empleados/vistas/consulta_diaespecifico.php");
    }
  

}