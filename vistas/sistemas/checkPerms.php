<?php 
// gaurdar los datos recibidos a la bd
session_start();
include_once "../../bd/conexion.php";

   
if(isset($_POST['id']) && isset($_POST['control'])){


$nomina=$_POST['id'];
$con=$_POST['control'];
foreach( $nomina as $key => $n ) {
    // echo 'las nominas son:'.$n .'y el check es:'.$con[$key].'<br>';

    if($con[$key]==1){
        // echo 'las nominas ACEPTADAS SON:'.$n.'<br>';        
    $sql = "UPDATE permisos SET estatus=1 WHERE id_permiso='$n'";
    $stmt= $conn->prepare($sql);
    $stmt->execute();
    // $_SESSION['true']="Permiso autorizado";
    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/admin/permisosreg.php");
    }

    if($con[$key]==2){
        // echo 'las nominas ACEPTADAS SON:'.$n.'<br>';        
    $sql = "UPDATE permisos SET estatus=2 WHERE id_permiso='$n'";
    $stmt= $conn->prepare($sql);
    $stmt->execute();
    // $_SESSION['true']="Permiso autorizado";
    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/admin/permisosreg.php");
    }
}


}


