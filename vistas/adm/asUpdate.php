<?php 
// gaurdar los datos recibidos a la bd
session_start();
include_once "../../bd/conexion.php";

   
if(isset($_POST['id']) && isset($_POST['control']) && isset($_POST['desc'])){

$nomina=$_POST['id'];
$con=$_POST['control'];
$desc=$_POST['desc'];
$ptm=$_SESSION['fechaChida'];

foreach( $nomina as $key => $n ) {
        echo "The nomina is " . $n . " and estatus is " . $con[$key] . "<br>";
        //     $sql = "DELETE FROM listaControl WHERE fecha=?";
        //     $query = $conn->prepare($sql);
        //     $query->execute([$_SESSION['fechaChida']]);
        //     $numeroDeFilas = $query->rowCount();
        //     $sql = "INSERT INTO listaControl(nomina_emp,pase,company,fecha) VALUES (?,?,?,?)";
        //     $query = $conn->prepare($sql);
        //     $query->execute([$n,$con[$key],$desc[$key],$_SESSION['fechaChida']]);
        $sql = "
        DELETE FROM listaControl WHERE fecha='$ptm'; 
        INSERT INTO listaControl(nomina_emp,pase,company,fecha) VALUES ('$n','$con[$key]','$desc[$key]','$ptm'); 
        ";

$stmt = $conn->prepare($sql);
$stmt->execute();
       

            }
    
    } 
    else{
      echo "No hay registros de esa fecha";
    
    }    
