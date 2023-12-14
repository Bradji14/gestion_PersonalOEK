<?php

require '../vendor/autoload.php';
require "../bd/conexion.php";


use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};



$_POST['fecha_inicio'];
$_POST['seleccion'];


$consulta = $_POST['fecha_inicio'];
$seleccion = $_POST['seleccion'];

$date = new DateTime($consulta);
$bien = $date->format('d/m/Y');


$sql = "SELECT e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F INNER JOIN company c ON c.id_company = e.id_company_F WHERE R.fecha_hora LIKE '%" . $bien . "%' AND c.descripcion = '".$seleccion."'; ";

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

$fila = 2;

while($rows = $resultado->fetch(PDO::FETCH_ASSOC)){

    //validar desde aqui

    if($rows['id_turno'] == 1){

      if (intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))) {

          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
          $fila++;
       
         
       
        }
  
        else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval(str_replace(":", '',$rows['entrada'])) && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0905')){

          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
          $fila++;
          
    
        }
  
        
        else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
          $fila++;
                
        }
  
        else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1300')){

          $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
          $hojaActiva->setCellValue('B'.$fila, $rows['name']);
          $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
          $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
          $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
          $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
          $fila++;
        }
   
  }

  if($rows['id_turno'] == 2){

    //dia normal que son lunes, miercoles, jueves,  viernes y sabado si es que entra a las 12
    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval(str_replace(":", '',$rows['entrada'])) && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('1505')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('1505') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('1600')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('1600')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
  }

  if($rows['id_turno'] == 3){
    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;

    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval(str_replace(":", '',$rows['entrada'])) && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0905')){

     $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1300')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
     

  }

  if($rows['id_turno'] == 4){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval(str_replace(":", '',$rows['entrada'])) && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0835')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0835') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
     

  }

  if($rows['id_turno'] == 5){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))){

   
      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval(str_replace(":", '',$rows['entrada'])) && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0905')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
    

  }

  if($rows['id_turno'] == 6){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval(str_replace(":", '',$rows['entrada']))){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval(str_replace(":", '',$rows['entrada'])) && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0705')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0705') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
    

  }

  if($rows['id_turno'] == 7){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0900')) {

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0905')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
    

  }

  if($rows['id_turno'] == 8){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0900')) {

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0905')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
    

  }

  if($rows['id_turno'] == 9){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('1430')) {

      
      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('1430') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('1435')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('1435') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1630')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1700')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
  
  }

  if($rows['id_turno'] == 10){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0900')) {

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0905')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
    

  }

  if($rows['id_turno'] == 11){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('1330')) {

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('1330') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('1335')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('1335') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1530')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1700')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
  
  }

  if($rows['id_turno'] == 12){

    if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0900')) {

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - ASISTENCIA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) <= intval('0905')){

      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - RETARDO');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) < intval('1200')){

     
      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - FALTA');
      $fila++;
    }

    else if(intval(str_replace (":", '',substr($rows['fecha_hora'], -6))) >= intval('1200')){
      $hojaActiva->setCellValue('A'.$fila, $rows['nomina']);
      $hojaActiva->setCellValue('B'.$fila, $rows['name']);
      $hojaActiva->setCellValue('C'.$fila, $rows['apellido_Paterno']);
      $hojaActiva->setCellValue('D'.$fila, $rows['apellido_Materno']);
      $hojaActiva->setCellValue('E'.$fila, $rows['descripcion']);
      $hojaActiva->setCellValue('F'.$fila, $rows['fecha_hora'].' - SALIDA');
      $fila++;
    }
  
  }
  

}

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="asistencias - '.$bien.'.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($excel, 'Xlsx');
    $writer->save('php://output');
    exit;

?>