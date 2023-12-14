<?php

include_once "../../../bd/conexion.php";
$stmt = $conn->prepare("SELECT nomina,name, des,
GROUP_CONCAT(count ORDER BY entrada ASC SEPARATOR ' - ' ) AS 'asd'

  FROM (SELECT l.nomina,entrada,c.descripcion as des, CONCAT(e.name,' ', e.apellido_Paterno,' ',e.apellido_Materno) AS name,CONCAT(entrada,count(l.nomina),',',salida,COUNT(l.nomina)) AS count     
 	 FROM pase l
 	 INNER JOIN empleado e ON l.nomina=e.nomina   
     INNER JOIN company c ON e.id_company_F= c.id_company 
  	 GROUP BY entrada, l.nomina ) 
  
  A GROUP BY nomina ORDER BY nomina
  ");
$stmt->execute(); 
// $user = $stmt->fetch();
$numero=$stmt->rowCount();  
$data=array();
if($numero>1){

    foreach ($stmt as $row) {
        $data[] = $row;
    }

}
echo json_encode($data);