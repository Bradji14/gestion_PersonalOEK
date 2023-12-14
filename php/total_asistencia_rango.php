<?php
include_once "../bd/conexion.php";



$salida = "";
$contador = 0;

if (!empty($_POST['consulta']) && !empty($_POST['consultados']) && !empty($_POST['seleccion'])) {

  $consulta = $_POST['consulta'];
  $consulta_dos = $_POST['consultados'];
  $seleccion = $_POST['seleccion'];

  $sql = "SELECT e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, t.id_turno, t.turno, t.entrada, t.salida,c.descripcion FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F INNER JOIN company c ON c.id_company = e.id_company_F WHERE STR_TO_DATE(R.fecha_hora, '%d/%m/%Y') >= STR_TO_DATE('".$consulta."', '%d/%m/%Y') AND STR_TO_DATE(R.fecha_hora, '%d/%m/%Y') <= STR_TO_DATE('".$consulta_dos."', '%d/%m/%Y') AND c.descripcion = '".$seleccion."' ORDER BY name DESC, fecha_hora ASC ;";
  


  $query = $conn->prepare($sql);
  $query->execute();


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
            $contador ++;
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
            $contador ++;
          }
    
          
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1505') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1700')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0835') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0840')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0705') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0710')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1435') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1440')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('1335') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('1340')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." PM</td>
            </tr>
            ";
            $contador ++;
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
            $contador ++;
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
            $contador ++;
          }
    
          else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) > intval('0905') && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval('0910')){
            $salida .= "
            <tr>   
              <td>" . $fila['nomina'] . "</td>
              <td>" . $fila['name'] . "</td>
              <td>" . $fila['apellido_Paterno'] . "</td>
              <td>" . $fila['apellido_Materno'] . "</td>
              <td>" . $fila['descripcion'] . "</td>
              <td style='background-color: #FF2300; color:white; font-weight: bold;'>".$fila['fecha_hora']." FALTA</td>
              <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." AM</td>
            </tr>
            ";
            $contador ++;
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
    
    
      }
    
    $salida .= '</tbody></table>';
  }
  
  // echo '<h5> Total de asistencias: '.$contador.' </h5>';
  