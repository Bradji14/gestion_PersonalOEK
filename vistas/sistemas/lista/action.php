<?php
//action.php
include_once "../../../bd/conexion.php";
// echo $_POST['search'];
if($_POST['action'] == 'edit')
{
 $data = array(
  ':entrada'  => $_POST['entrada'],
  ':salida'    => $_POST['salida'],
  ':id'    => $_POST['nomina']

 );
 $query = "
 UPDATE pase
 SET entrada =:entrada, salida=:salida
 WHERE nomina = :id";

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