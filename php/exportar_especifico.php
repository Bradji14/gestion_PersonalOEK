<?php
ob_start();
require '../vendor/autoload.php';
require "../bd/conexion.php";


use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};



$_POST['fecha_inicio'];
$_POST['seleccion'];


$consulta = $_POST['fecha_inicio'];
$seleccion = $_POST['seleccion'];
$date = new DateTime($consulta);
$bien = $date->format('d/m/Y');


$sql = "SELECT e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F INNER JOIN company c ON c.id_company = e.id_company_F WHERE R.fecha_hora LIKE '%" . $bien . "%' AND c.descripcion = '".$seleccion."' AND estatus=1 ORDER BY e.nomina ASC, fecha_hora ASC ";

$resultado = $conn->query($sql);

$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
//titulo que se le agrega a la hoja de excel
$hojaActiva->setTitle("asistencias");

$hojaActiva->setCellValue('A1', 'NOMINA');
$hojaActiva->setCellValue('B1', 'NOMBRE');
$hojaActiva->setCellValue('C1', 'APELLIDO PATERNO');
$hojaActiva->setCellValue('D1', 'APELLIDO MATERNO');
$hojaActiva->setCellValue('E1', 'COMPAÑIA');
$hojaActiva->setCellValue('F1', 'FECHA - HORA');
$hojaActiva->setCellValue('G1', 'ENTRADA - SALIDA(A BASE DE SU HORARIO)');




$fila = 2;


while($rows = $resultado->fetch(PDO::FETCH_ASSOC)){

    //validar desde aqui

    
    
        if (intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))) 
      {        
          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila,substr($rows['fecha_hora'],-6).' - ASISTENCIA');
          $hojaActiva->setCellValue('G'.$fila, $rows['entrada'].' '.$rows['salida']);
  

          $fila++;
      }   
      elseif(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))+230){

          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila,substr($rows['fecha_hora'],-6).' - entrada dist');
          $hojaActiva->setCellValue('G'.$fila, $rows['entrada'].' '.$rows['salida']);

          $fila++;
      }


      //salida
         else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval(str_replace(":", '',$rows['salida']))){
          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila,substr($rows['fecha_hora'],-6).' - SALIDA');
          $hojaActiva->setCellValue('G'.$fila, $rows['entrada'].' '.$rows['salida']);

          $fila++;
      } 
    // Retardo
        elseif(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))+5){
          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila,substr($rows['fecha_hora'],-6).' - RETARDO');
          $hojaActiva->setCellValue('G'.$fila, $rows['entrada'].' '.$rows['salida']);

          $fila++;
          
        }
       //falta por retardo
        elseif(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval(str_replace(":", '',$rows['entrada']))+6 && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))+100){
          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila,substr($rows['fecha_hora'],-6).' - FALTA POR RETARDO');
          $hojaActiva->setCellValue('G'.$fila, $rows['entrada'].' '.$rows['salida']);

          $fila++;; 
        }
        //salida anticipada
        elseif(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval(str_replace(":", '',$rows['entrada']))+7 && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval(str_replace(":", '',$rows['salida']))){
          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila,substr($rows['fecha_hora'],-6).' - SALIDA ANTICIPADA');
          $hojaActiva->setCellValue('G'.$fila, $rows['entrada'].' '.$rows['salida']);
          $fila++;
        }
        // elseif(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['salida']))-10){
        //   $salida .= "
        //   <tr>   
        //   <td>" . $fila['nomina'] . "</td>
        //   <td>" . $fila['name'] . "</td>
        //   <td>" . $fila['apellido_Paterno'] . "</td>
        //   <td>" . $fila['apellido_Materno'] . "</td>
        //   <td>" . $fila['descripcion'] . "</td>
        //   <td class='text-center' style='background-color: #F30E0E; color:white; font-weight: bold;'>".substr($fila['fecha_hora'], -6)."</td>
        //   <td style='background-color: purple; color:black; font-weight: bold;'>".$fila['salida']." SALIDA ENTICIPADA</td> 
        //   <td>" .substr($fila['fecha_hora'],0,10). "</td>
          
        //   </tr>"; 
        // }
       
      else{
        $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
        $hojaActiva->setCellValue('B'.$fila, $rows['name']);
        $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
        $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
        $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
        $hojaActiva->setCellValue('G'.$fila, $rows['fecha_hora']);
        $fila++;
      }

}

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="asistencias.xls"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($excel, 'Xlsx');
    $writer->save('php://output');
    exit;

?>