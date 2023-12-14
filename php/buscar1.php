<?php
include_once "../bd/conexion.php";



$salida = "";

if (!empty($_POST['consulta']) && !empty($_POST['seleccion'])) {

  $consulta = $_POST['consulta'];
  $seleccion = $_POST['seleccion'];

  $sql = "SELECT e.id_empleado, e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, R.nomina, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F INNER JOIN company c ON c.id_company = e.id_company_F WHERE R.fecha_hora LIKE '%" . $consulta . "%' AND c.descripcion = '" . $seleccion . "' ORDER BY name DESC, fecha_hora ASC";


  $query = $conn->prepare($sql);
  $query->execute();

  // SELECT e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, t.id_turno, t.turno, t.entrada, t.salida FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F WHERE R.fecha_hora BETWEEN '06/06/2022' AND '08/06/2022';

  //rango de fecha_dos
  // SELECT e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, t.id_turno, t.turno, t.entrada, t.salida FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F WHERE R.fecha_hora BETWEEN "06/06/2022" AND "09/06/2022";

  $sql2 = "SELECT  e.name, e.apellido_Paterno, p.fechaPermiso from empleado e INNER JOIN permisos p ON e.nomina = p.id_nomina WHERE p.fechaPermiso LIKE '%$consulta%'";

  $query2 = $conn->prepare($sql2);
  $query2->execute();
  $numeroDeFilas = $query2->rowCount();


  if($numeroDeFilas<=0)
  {
    echo 'sin permisos';
  }
  else{
    foreach($query2 as $row){
      echo 'hola'.$row['name'].' '.$row['fechaPermiso'];
 
  }
    
  }
}



if ($resultado = $query->rowCount() > 0) {

  $salida .= '
       <table class="table table-bordered">

       <thead class="">
          <tr class="text-center">
            <th>NOMINA</th>
            <th>NOasdMBRE</th>
            <th>APELLIDO PATERNO</th>
            <th>APELLIDO MATERNO</th>
            <th>COMPAÑIA</th>
            <th>REGISTRO DE ASISTENCIA</th>
            <th class="text-center">ENTRADA - SALIDA<br/>CON BASE AL HORARIO</th>
            <th>Permisos</th>

          </tr>
       </thead>
       <tbody>
     ';

     

  while ($fila = $query->fetch(PDO::FETCH_LAZY)) {

    
    //9:00 = 900
    //id con turno 1
 

    if($fila['id_turno'] == 1){
      //lo que hacemos en este if y en todos en general es primero solo tomar los ultimos 6 caracteres que contiene la hora, despues quitarle el caracter especial ":", posteriormente lo que queda lo convertimos a entero.
      if (intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
          
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval(str_replace(":", '',$fila['entrada'])) && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0905')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']."  RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      
      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
       
    }

    //turno con id = 2

    if($fila['id_turno'] == 2){

      //dia normal
      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval(str_replace(":", '',$fila['entrada'])) && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1505')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1505') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1700')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1530')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
    }

    //turno 3------------------------------------------------------------

    if($fila['id_turno'] == 3){
      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval(str_replace(":", '',$fila['entrada'])) && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0905')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
       

    }

    //turno- 4-------------------------------------

    if($fila['id_turno'] == 4){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval(str_replace(":", '',$fila['entrada'])) && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0835')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0835') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0840')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0840')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
       

    }
// _____________________________________________________________________________________________________________________
    
    if($fila['id_turno'] == 5){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval(str_replace(":", '',$fila['entrada'])) && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0905')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
       

    }


 //-------------------------------------------------------------------------------------------
    if($fila['id_turno'] == 6){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval(str_replace(":", '',$fila['entrada'])) && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0705')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0705') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0710')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0710')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
      

    }

    //----------------------turno 7
    if($fila['id_turno'] == 7){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0900')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0905')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
      

    }

    if($fila['id_turno'] == 8){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0900')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0905')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
      

    }

    if($fila['id_turno'] == 9){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1200') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1430')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1430') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1435')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1435') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1440')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1440')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
    
    }

    if($fila['id_turno'] == 10){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0900')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0905')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
      

    }

    if($fila['id_turno'] == 11){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1330')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1330') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1335')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1335') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1340')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1340')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
    
    }

    if($fila['id_turno'] == 12){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0900')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0900') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0905')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0910')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
    
    }
    //
    if($fila['id_turno'] == 13){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1400')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." ASISTENCIA</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1330') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1335')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1335') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1340')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA POR RETARDO</td>
          <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1340')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." SALIDA</td>
          <td class='text-center' style='background-color: #086106; color:white; font-weight: bold;'>".$fila['salida']." PM</td>
        </tr>
        ";
      }
    
    }
    //

  }

  $salida .= '</tbody></table>';
}

echo $salida;
