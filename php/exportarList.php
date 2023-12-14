<?php
require '../vendor/autoload.php';
require "../bd/conexion.php";


use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};






$consulta = $_POST['fecha_inicio'];
$consultados = $_POST['fecha_final'];
$seleccion=$_POST['seleccion'];

$sql = "SELECT  l.nomina_emp,CONCAT(e.name,' ',e.apellido_Paterno,' ',e.apellido_Materno) AS NAME, GROUP_CONCAT(l.pase  ORDER BY fecha, pase SEPARATOR ',' ) AS roles FROM listacontrol l INNER JOIN empleado e ON l.nomina_emp = e.nomina WHERE company = '".$seleccion."' AND fecha BETWEEN '".$consulta."' AND '".$consultados."' GROUP BY nomina_emp ORDER BY nomina_emp";

$resultado = $conn->query($sql);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
//titulo que se le agrega a la hoja de excel
$hojaActiva->setTitle("asistencias");

$fila = 0;


while($rows = $resultado->fetch(PDO::FETCH_ASSOC)){

    //validar desde aqui

    
    
               
          $hojaActiva->setCellValue('A'.$fila, $rows['NAME']);
          $hojaActiva->setCellValue('B'.$fila, $rows['nomina_emp']);
          $hojaActiva->setCellValue('C'.$fila, $rows['roles']);
 
          $fila++;
      

}

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="asistencias.xls"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($excel, 'Xlsx');
    $writer->save('php://output');
    exit;

?>