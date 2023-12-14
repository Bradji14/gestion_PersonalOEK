<?php
include_once "../bd/conexion.php";



$salida = "";
$salida1 = "";
$salida3 = "";


if (!empty($_POST['fechaInicial']) && !empty($_POST['fechaFinal']) && !empty($_POST['seleccion'])) {

  $consulta = $_POST['fechaInicial'];
  $consultados=$_POST['fechaFinal'];
  $seleccion = $_POST['seleccion'];

  
  //permisos
  $sql2= "SELECT  e.name,e.nomina, e.apellido_Paterno,e.apellido_Materno, p.fechaPermiso, p.motivo, p.tiempo_solicitado, c.descripcion from empleado e INNER JOIN permisos p ON e.nomina = p.id_nomina INNER JOIN company c ON e.id_company_F=c.id_company WHERE p.fechaPermiso >= '$consulta' AND p.fechaPermiso <= '$consultados' AND  c.descripcion='$seleccion' AND p.estatus=0";
  $query2 = $conn->prepare($sql2);
  $query2->execute();
  $numeroDeFilas = $query2->rowCount();
  

  if($numeroDeFilas > 0)
  {

    $salida1 .= '
    <div class="mb-3 col-md-12" id="div2">
    <form action="val.php" method="post">
    <table class="table table-info"> 
    <h5 class="text-center">Tabla de PERMISOS</h5>
    <thead class="" style="position: sticky;top: 0;">
       <tr class="text-center">
         <th>NOMINA</th>
         <th>NOMBRE</th>
         <th>FECHA DEL PERMISO</th>
         <th>COMPAÑIA</th>
         <th>TIEMPO SOLICITADO</th>
         <th>MOTIVO PERMISO</th>
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
            <td>" . $row['name'] .' '.$row['apellido_Paterno'].' '.$row['apellido_Materno']."</td>
            <td>" . $row['fechaPermiso']."</td>
            <td>" . $row['descripcion'] . "</td>
            <td>" . $row['tiempo_solicitado'] . "</td>
            <td>" . $row['motivo']."</td>     
            </tr>";
        
          }
          $salida.="</table></div>";
  }
  else{
    $salida1.= "
    <h3 class='text-center'>Sin registros</h3>";
  }

}
echo $salida1;



?>