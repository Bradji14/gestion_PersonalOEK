<?php
    session_start();


include_once "../../bd/conexion.php";
if(isset($_GET['id'])){

    $id=$_GET['id'];

    $sql= "DELETE  from permisos where id_permiso='$id'";
    $query = $conn->prepare($sql);
    $query->execute();
    $numeroDeFilas = $query->rowCount();

    $_SESSION['delete']="Permiso eliminado";

    header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/hsbc/permisosreghsbc.php");
    //  sleep(1);

}