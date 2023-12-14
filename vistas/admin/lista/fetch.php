<?php
//fetch.php
include_once "../../../bd/conexion.php";
session_start();

// SELECT nomina_emp,name,company, GROUP_CONCAT(count ORDER BY pase ASC SEPARATOR ' - ' ) AS 'asd' 
//   FROM (SELECT nomina_emp, pase, CONCAT(e.name,' ', e.apellido_Paterno,' ', e.apellido_Materno) AS name, company,CONCAT(pase,count(nomina_emp))AS count     
//   FROM listacontrol l
//   INNER JOIN empleado e ON l.nomina_emp=e.nomina           
//   WHERE company='$seleccion' AND fecha BETWEEN '$consulta' AND '$consulta_dos' AND pase !='0' GROUP BY pase, nomina_emp) 
//   A GROUP BY nomina_emp ORDER BY nomina_emp
$date=$_SESSION['fechaChida'];
$column = array( "nomina","entrada", "fecha_entrada");
// $query = "SELECT * FROM pase ";

$query ="SELECT  e.id_empleado, e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno,p.nomina,p.entrada,p.salida,p.fecha_reg,p.fecha_salida,p.fecha_entrada, c.descripcion FROM empleado e 
INNER JOIN pase p ON e.nomina = p.nomina
INNER JOIN company c ON c.id_company = e.id_company_F ";
// $query="SELECT  e.id_empleado, e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, R.nomina, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F INNER JOIN company c ON c.id_company = e.id_company_F";

//  WHERE R.fecha_hora LIKE '%" . $newDate . "%' AND c.descripcion = '" . $seleccion . "' AND estatus=1 ORDER BY e.nomina ASC, fecha_hora ASC

if(isset($_POST["search"]["value"]))
{
   
 $query .= '
 WHERE e.nomina LIKE "%'.$_POST["search"]["value"].'%" 
';
}
if(isset($_POST["order"]))
{
 $query .= 'and fecha_reg LIKE "%2023-02-28%" ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}

//aca pasar la fecha por post que se desea buscar
else
{
 $query .= 'and fecha_reg LIKE "%'.$date.'%"  AND c.descripcion = "Administrativo" AND e.nomina !="1026" AND e.nomina !="1019" ORDER BY e.nomina ';
}
$query1 = '';


if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $conn->prepare($query);

$statement->execute();
$number_filter_row = $statement->rowCount();
$statement = $conn->prepare($query . $query1);
$statement->execute();
$result = $statement->fetchAll();
$data = array();

foreach($result as $row)
{
 $sub_array = array();
 $sub_array[] = $row['nomina'];
 $sub_array[] = $row['name'].' '.$row['apellido_Paterno'].' '.$row['apellido_Materno'];
 $sub_array[] = $row['descripcion'];
 $sub_array[] = substr($row['fecha_entrada'],10);
 $sub_array[] = substr($row['fecha_salida'],10);
 $sub_array[] = $row['entrada'];
 $sub_array[] = $row['salida'];
 $sub_array[] = $row['fecha_reg'];
 $data[] = $sub_array;
}
function count_all_data($connect)
{
// $query = "SELECT * FROM listacontrol ";
$query ="SELECT  e.id_empleado, e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno,p.nomina,p.entrada,p.salida, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e 
INNER JOIN pase p ON e.nomina = p.nomina
INNER JOIN turno t ON t.id_turno = e.id_turno_F 
INNER JOIN company c ON c.id_company = e.id_company_F ";
$statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}
$output = array(
 'draw'   => intval($_POST['draw']),
 'recordsTotal' => count_all_data($conn),
 'recordsFiltered' => $number_filter_row,
 'data'   => $data
);
echo json_encode($output);
?>