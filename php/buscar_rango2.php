<?php
include_once "../bd/conexion.php";



$salida = "";
$salida1="";
$salida3="";

if (!empty($_POST['consulta']) && !empty($_POST['consultados']) && !empty($_POST['seleccion'])) {

  $consulta = $_POST['consulta'];
  $consulta_dos = $_POST['consultados'];
  $seleccion = $_POST['seleccion'];

  $sql = "SELECT e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, t.id_turno, t.turno, t.entrada, t.salida,c.descripcion FROM empleado e INNER JOIN registro R ON e.nomina = R.nomina INNER JOIN turno t ON t.id_turno = e.id_turno_F INNER JOIN company c ON c.id_company = e.id_company_F WHERE STR_TO_DATE(R.fecha_hora, '%d/%m/%Y') >= STR_TO_DATE('".$consulta."', '%d/%m/%Y') AND STR_TO_DATE(R.fecha_hora, '%d/%m/%Y') <= STR_TO_DATE('".$consulta_dos."', '%d/%m/%Y') AND c.descripcion = '".$seleccion."' AND estatus=1 ORDER BY name DESC, fecha_hora ASC ;";
  $query = $conn->prepare($sql);
  $query->execute();


//permisos
  $sql2= "SELECT  e.name,e.nomina, e.apellido_Paterno,e.apellido_Materno, p.fechaPermiso, p.motivo, p.tiempo_solicitado, c.descripcion from empleado e INNER JOIN permisos p ON e.nomina = p.id_nomina INNER JOIN company c ON e.id_company_F=c.id_company WHERE p.fechaPermiso >= '$consulta' AND  p.fechaPermiso <= '$consulta_dos' AND  c.descripcion='$seleccion'";
  $query2 = $conn->prepare($sql2);
  $query2->execute();
  $numeroDeFilas = $query2->rowCount();
  

  if($numeroDeFilas > 0)
  {

    $salida1 .= '
    <div id="div1" class="mt-5">

    <div class="row">
    <h5 class="text-center">Tabla de PERMISOS</h5>              
                    
    </div>
    <table class="table table-success table-striped">

    <thead class="">
       <tr class="text-center">
         <th>NOMINA</th>
         <th>NOMBRE</th>
         <th>APELLIDO PATERNO</th>
         <th>APELLIDO MATERNO</th>
         <th>COMPAÑIA</th>
         <th>TIEMPO SOLICITADO</th>
         <th>MOTIVO PERMISO</th>
         <th>FECHA PERMISO</th>
       </tr>
    </thead>
    <tbody>
  ';
  foreach($query2 as $row)
        {
          // echo substr($row['tiempo_solicitado'],0,1);

            $salida1.= "
            <tr>   
            <td>" . $row['nomina'] . "</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['apellido_Paterno'] . "</td>
            <td>" . $row['apellido_Materno'] . "</td>
            <td>" . $row['descripcion'] . "</td>
            <td>" . $row['tiempo_solicitado'] . "</td>
            <td><div style='height:80px; overflow-y:scroll;'>" . $row['motivo'] . "</div></td>
            <td>" . $row['fechaPermiso']."</td>     
            </tr>";
        
          }
          $salida1.="</tbody></table></div></div>";
  }


  //permutas
      // SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerE INNER JOIN turno t ON p.id_turno_cambio=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE p.fecha_permuta LIKE '%$consulta%' AND p.company='$seleccion' UNION ALL SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerS INNER JOIN turno t ON p.id_turno_cambio2=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE p.fecha_permuta LIKE '%$consulta%' AND p.company='$seleccion' ORDER BY id_permuta 
  $sql3="SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerE INNER JOIN turno t ON p.id_turno_cambio=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE p.fecha_permuta >= '$consulta' AND  p.fecha_permuta <= '$consulta_dos' AND p.company='$seleccion' UNION ALL SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerS INNER JOIN turno t ON p.id_turno_cambio2=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE p.fecha_permuta >= '$consulta' AND  p.fecha_permuta <= '$consulta_dos' AND p.company='$seleccion' ORDER BY id_permuta ";
  $query3 = $conn->prepare($sql3);
  $query3->execute();
  $numeroDeFilas3 = $query3->rowCount();


  
  if($numeroDeFilas3 > 0)
  {

    $salida3 .= '
    <div id="div1" class="mt-5">

    <div class="row">
    <h5 class="text-center">PERMUTAS</h5>

                    <h6 class="text-center">SIMBOLOGIA de PERMUTAS</h6>
                    <div class="col-md-12 mb-2 d-flex justify-content-around">

                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#245470"
                        class="bi bi-circle-fill" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8" />
                    </svg> PERMUTANTE 1
                </p>
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#3e9dd5"
                        class="bi bi-circle-fill" viewBox="0 0 16 16">
                        <circle cx="8" cy="8" r="8" />
                    </svg> PERMUTANTE 2
                </p>
    </div>
    </div>
    <table class="nth-table ">
    <thead class="">
       <tr class="text-center">
         <th>NOMINA</th>
         <th>NOMBRE</th>
         <th>APELLIDO PATERNO</th>
         <th>APELLIDO MATERNO</th>
         <th>FECHA PERMUTA</th>
         <th>ENTRADA PERMUTADA</th>
         <th>SALIDA PERMUTADA</th>
         <th>MOTIVO</th></div>
         <th>COMPAÑIA</th>
       </tr>
    </thead>
    <tbody>
  ';
      foreach($query3 as $row)
        {
       
          $salida3.= "
            <tr>   
            <td>" . $row['nomina'] . "</td>
            <td>" . $row['name'] . "</td>         
            <td>" . $row['apellido_Paterno'] . "</td>
            <td>" . $row['apellido_Materno'] . "</td>
            <td>" . $row['fecha_permuta'] . "</td>
            <td>" . $row['entrada'] . "</td>
            <td>" . $row['salida'] . "</td>
            <td><div style='height:100px; overflow-y:scroll;'>" . $row['motivoPermuta'] . "</div></td>
            <td>" . $row['descripcion']."</td>
            </tr>";
         
        }
        $salida3.="</tbody></table></div></div>";
  }


  

if ($resultado = $query->rowCount() > 0) {

  $salida .= '
  <div id="div2" class="mb-3">

       <table class="table tableAs">
       <h5 class="text-center">ASISTENCIAS</h5>
       <thead class="">
          <tr class="text-center">
            <th>NOMINA</th>
            <th>NOMBRE</th>
            <th>APELLIDO PATERNO</th>
            <th>APELLIDO MATERNO</th>
            <th>COMPAÑIA</th>
            <th>REGISTRO DE  <br> ENTRADAS- SALIDAS</th>
            <th class="text-center">ENTRADAS Y SALIDAS CORRECTAS</th>
            <th>Fechas </th>
          </tr>
       </thead>
       <tbody>
     ';

     

    foreach($query as $fila) {

        //entrada
      if (intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))) 
      {        
        $salida .= "
        <tr>   
        <td>" . $fila['nomina'] . "</td>
        <td>" . $fila['name'] . "</td>
        <td>" . $fila['apellido_Paterno'] . "</td>
        <td>" . $fila['apellido_Materno'] . "</td>
        <td>" . $fila['descripcion'] . "</td>
        <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'>".substr($fila['fecha_hora'], -6)."</td>
        <td style='background-color: #0D5982; color:white; font-weight: bold;'>".$fila['entrada']." ENTRADA</td>
        <td>" .substr($fila['fecha_hora'],0,10). "</td>
        </tr>";
      }   

      //salida
         else if(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval(str_replace(":", '',$fila['salida']))){
        $salida .= "
        <tr>   
        <td>" . $fila['nomina'] . "</td>
        <td>" . $fila['name'] . "</td>
        <td>" . $fila['apellido_Paterno'] . "</td>
        <td>" . $fila['apellido_Materno'] . "</td>
        <td>" . $fila['descripcion'] . "</td>
        <td class='text-center' style='background-color: #36941B ; color:white; font-weight: bold;'>".substr($fila['fecha_hora'], -6)."</td> 
        <td style='background-color: #36941B ; color:white; font-weight: bold;'>".$fila['salida']." SALIDA</td> 
        <td>" .substr($fila['fecha_hora'],0,10). "</td>
        </tr>";
      } 
    // Retardo
        elseif(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))+5){
          $salida .= "
          <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td class='text-center' style='background-color: #CD6D00; color:white; font-weight: bold;'>".substr($fila['fecha_hora'], -6)."</td> 
          <td style='background-color: #CD6D00; color:white; font-weight: bold;'>".$fila['entrada']." RETARDO</td> 
          <td>" .substr($fila['fecha_hora'],0,10). "</td>
          </tr>";
          
        }
       //falta por retardo
        elseif(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval(str_replace(":", '',$fila['entrada']))+6 && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) <= intval(str_replace(":", '',$fila['entrada']))+100){
          $salida .= "
          <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td class='text-center' style='background-color: #E0F113; color:black; font-weight: bold;'>".substr($fila['fecha_hora'], -6)."</td> 
          <td style='background-color: #E0F113; color:black; font-weight: bold;'>".$fila['entrada']." FALTA POR RETARDO</td> 
          <td>" .substr($fila['fecha_hora'],0,10). "</td>
          </tr>"; 
        }

          //salida anticipada
        elseif(intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) >= intval(str_replace(":", '',$fila['entrada']))+7 && intval(str_replace (":", '',substr($fila['fecha_hora'], -6))) < intval(str_replace(":", '',$fila['salida']))){
          $salida .= "
          <tr>   
          <td>" . $fila['nomina'] . "</td>
          <td>" . $fila['name'] . "</td>
          <td>" . $fila['apellido_Paterno'] . "</td>
          <td>" . $fila['apellido_Materno'] . "</td>
          <td>" . $fila['descripcion'] . "</td>
          <td class='text-center' style='background-color: #F30E0E; color:white; font-weight: bold;'>".substr($fila['fecha_hora'], -6)."</td>
          <td style='background-color: #F30E0E; color:white; font-weight: bold; font-size:14px'> HORARIO DISTINTO <span class='text-center'>O</span> <br>SALIDA ANTICIPADA</td>
          <td>" .substr($fila['fecha_hora'],0,10). "</td>
          <td>Entrada: <span>".$fila['entrada']." </span></td>      
          <td>Salida:<span>".$fila['salida']."</span></td>    
          </tr>"; 
        }
       
   
      else{
        $salida .= "
        <tr>   
        <td>" . $fila['nomina'] . "</td>
        <td>" . $fila['name'] . "</td>
        <td>" . $fila['apellido_Paterno'] . "</td>
        <td>" . $fila['apellido_Materno'] . "</td>
        <td>" . $fila['descripcion'] . "</td>
        <td class='text-center'>".substr($fila['fecha_hora'], -6)."</td>
        <td>Entrada: <span>".$fila['entrada']." </span></td>      
        <td>Salida:<span>".$fila['salida']."</span></td>    
        <td>".$fila['fecha_hora']."</td>
        </tr>";
      }
    }
    $salida.="</tbody></table></div></div>";
       
      }
   
      }
    
echo $salida;
echo $salida1;
echo $salida3;
      