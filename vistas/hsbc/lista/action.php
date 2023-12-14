<?php
//action.php
session_start();

include_once "../../../bd/conexion.php";
$date=$_SESSION['fechaChida'];

date_default_timezone_set('America/Mexico_City');
$mifecha = new DateTime(); 
$mifecha->modify('-1 hours'); 
$dateD=$mifecha->format('Y-m-d H:i:s');

// echo $_POST['search'];
if($_POST['action'] == 'edit')
{
 $data = array(
  ':entrada'  => $_POST['entrada'],
  ':salida'    => $_POST['salida'],
  ':id'    => $_POST['nomina'],
  ':status'    => $_POST['status'],
  ':fecha' => $date,
  ':fechaUpdate'=>$dateD

 );
 $query = "
 UPDATE pase
 SET entrada =:entrada, salida=:salida,status=:status, update_at= :fechaUpdate
 WHERE nomina = :id and fecha_reg= :fecha";

 $statement = $conn->prepare($query);
 $statement->execute($data);
 echo json_encode($_POST);
}
if($_POST['action'] == 'delete')
{
 $query = "
 DELETE FROM listacontrol
 WHERE nomina = '".$_POST["nomina"]."'
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 echo json_encode($_POST);
}
?>