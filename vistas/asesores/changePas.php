<?php
include_once "../../bd/conexion.php";

if(isset($_POST['save'])){

    $id=$_POST['id'];
    $oldPas=$_POST['pass'];
    $newPas=$_POST['newpass'];


    $sql = "SELECT * from ase_tel where nomina='$id' and password='$oldPas' ";
    $query = $conn->prepare($sql);
    $query->execute();
    $numeroDeFilas = $query->rowCount();


    if($numeroDeFilas > 0){
        $sqlu = "UPDATE ase_tel SET password=?  where nomina=?";
        $query1 = $conn->prepare($sqlu);
        $query1->execute([$newPas,$id]);
        session_start();
        $_SESSION['change']="Cambiado";
        header('Location:http://192.168.100.200:50/asistencias_empleados/');
    }
    else{
        session_start();
        $_SESSION['error']="error";
        header('Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/change.php');
    }
    
}



?>