<?php
include_once "../bd/conexion.php";



$salida = "";
$salida1 = "";
$salida3 = "";


if (!empty($_POST['fechaInicio']) && !empty($_POST['fechaFinal']) && !empty($_POST['seleccion'])) {

  $consulta = $_POST['fechaInicio'];
  $consultados = $_POST['fechaFinal'];
  $seleccion = $_POST['seleccion'];

//permutas
  $sql3="SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerE INNER JOIN turno t ON p.id_turno_cambio=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE p.fecha_permuta >= '$consulta' AND p.fecha_permuta <= '$consultados' AND p.company='$seleccion' UNION ALL SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerS INNER JOIN turno t ON p.id_turno_cambio2=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE p.fecha_permuta >= '$consulta' AND p.fecha_permuta <= '$consultados' AND p.company='$seleccion' ORDER BY id_permuta ";
  $query3 = $conn->prepare($sql3);
  $query3->execute();
  $numeroDeFilas3 = $query3->rowCount();


  
  if($numeroDeFilas3 > 0)
  {

    $salida3 .= '
    <div class="mb-3 col-md-12" id="div2">
    <table class="nth-table">
    <h5 class="text-center">Tabla de PERMUTAS</h5>
    <thead class="" style="position: sticky;top: 0;">
       <tr class="text-center">
         <th>NOMINA</th>
         <th>NOMBRE</th>
         <th>APELLIDO PATERNO</th>
         <th>APELLIDO MATERNO</th>
         <th>FECHA PERMUTA</th>
         <th>ENTRADA PERMUTADA</th>
         <th>SALIDA PERMUTADA</th>
         <th>MOTIVO</th>
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
            <td><div style='height:100px; overflow-y:scroll; text-align:left;'>" . $row['motivoPermuta'] . "</div></td>
            </tr>";
         
        }

        $salida3.="</table></div>";
  }

else{
  $salida3.= "
  <h3 class='text-center'>Sin registros</h3>";
}
   
}


echo $salida3;



?>