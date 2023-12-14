<?php

include_once "../../../bd/conexion.php";
$stmt = $conn->prepare("SELECT p.nomina,p.entrada,p.salida,p.fecha_reg,p.fecha_entrada,p.fecha_salida,p.hr_break,p.hr_break_fin,
e.name,e.apellido_Paterno,e.apellido_Materno,c.descripcion
FROM pase p
INNER JOIN empleado e ON p.nomina = e.nomina
INNER JOIN company c ON e.id_company_F =c.id_company");
$stmt->execute(); 
// $user = $stmt->fetch();
$numero=$stmt->rowCount();  
$data=array();
if($numero>0){

    foreach ($stmt as $row) {
        $data[] = $row;
    }

}
echo json_encode($data);