<?php 
// gaurdar los datos recibidos a la bd
session_start();
include_once "../../bd/conexion.php";

   
if(isset($_POST['id']) && isset($_POST['control']) && isset($_POST['desc'])){


$nomina=$_POST['id'];
$con=$_POST['control'];
// $s=$_POST['fech'];
// $ptm=date("d-m-Y", strtotime($_POST['fech']));
$desc=$_POST['desc'];
// $fec=json_encode($JsonObject);

foreach( $nomina as $key => $n ) {
    // echo "The nomina is " . $n . " and estatus is " . $con[$key] . ", thank you y la fecha es".$_SESSION['fechaChida'].", y la desc es".$desc[$key]."<br>";
        $sql = "INSERT INTO listaControl(nomina_emp,pase,company,fecha) VALUES (?,?,?,?)";
        $query = $conn->prepare($sql);
        $query->execute([$n,$con[$key],$desc[$key],$_SESSION['fechaChida']]);
        $_SESSION['check']="Pase de lista realizado con exito";
        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/movistar/consultamov.php");


  }
}
else{
  echo "No hay registros de esa fecha";
}
