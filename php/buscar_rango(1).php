<?php
include_once "../bd/conexion.php";



$salida = "";

if (!empty($_POST['consulta']) && !empty($_POST['consultados']) && !empty($_POST['seleccion'])) {

  $consulta = $_POST['consulta'];
  $consulta_dos = $_POST['consultados'];
  $seleccion = $_POST['seleccion'];

  $sql = "SELECT e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, t.id_turno, t.turno, t.entrada, t.salida,
  c.descripcion 
  FROM empleado e
  INNER JOIN registro R ON e.nomina = R.nomina 
  INNER JOIN turno t ON t.id_turno = e.id_turno_F 
  INNER JOIN company c ON c.id_company = e.id_company_F 
  WHERE STR_TO_DATE(R.fecha_hora, '%d/%m/%Y') >= STR_TO_DATE('".$consulta."', '%d/%m/%Y') AND STR_TO_DATE(R.fecha_hora, '%d/%m/%Y') <= STR_TO_DATE('".$consulta_dos."', '%d/%m/%Y') AND c.descripcion = '".$seleccion."';";
  


  $query = $conn->prepare($sql);
  $query->execute();


}



if ($resultado = $query->rowCount() > 0) {

  $salida .= '
       <table class="table table-bordered">

       <thead class="">
          <tr>
            <th>Nomina</th>
            <th>Nombre</th>
            <th>Apelido Paterno</th>
            <th>Apelido Materno</th>
            <th>Compañia</th>
            <th>Fecha</th>
          </tr>
       </thead>
       <tbody>
     ';


  while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {

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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      
      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA POR RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1300')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - ASISTENCIA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." PM - RETARDO</td>
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
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - FALTA</td>
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
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
        </tr>
        ";
      }
    }

    if($fila['id_turno'] == 3){
      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1300')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
        </tr>
        ";
      }
       

    }

    if($fila['id_turno'] == 4){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0835') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0705') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
        </tr>
        ";
      }
      

    }

    if($fila['id_turno'] == 7){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0900')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
        </tr>
        ";
      }
      

    }

    if($fila['id_turno'] == 9){

      if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1430')) {
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." PM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1435') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1630')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1700')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." PM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1335') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1530')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1700')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
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
          <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - ASISTENCIA</td>
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
          <td style='background-color: #FFB600; color:black; font-weight: bold;'>".$fila['fecha_hora']." AM - RETARDO</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." AM - FALTA</td>
        </tr>
        ";
      }

      else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval('1200')){
        $salida .= "
        <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td style='background-color: #086106 ; color:white; font-weight: bold;'>".$fila['fecha_hora']." PM - SALIDA</td>
        </tr>
        ";
      }
    
    }

    


  











 //-------------------------------------------------------------------------------------------
  

       
    
  }

  $salida .= '</tbody></table>';

}

echo $salida;