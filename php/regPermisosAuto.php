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
  $sql2= "SELECT  e.name, p.id_jefe, e.nomina,j.nombre,j.apellidos,j.id, e.apellido_Paterno,e.apellido_Materno,p.id_permiso, p.fechaPermiso, p.motivo, p.tiempo_solicitado, c.descripcion from empleado e  INNER JOIN permisos p ON e.nomina = p.id_nomina INNER JOIN company c ON e.id_company_F=c.id_company INNER JOIN jefes_empresa j ON p.id_jefe= j.id  WHERE p.fechaPermiso >= '$consulta' AND p.fechaPermiso <= '$consultados' AND  c.descripcion='$seleccion' AND p.estatus=1";
  $query2 = $conn->prepare($sql2);
  $query2->execute();
  $numeroDeFilas = $query2->rowCount();
  

  if($numeroDeFilas > 0)
  {

    $salida1 .= '
    <div class="mb-3 col-md-12" id="div2">
    <form action="val.php" method="post">
    <table class="table table-success table-striped"> 
    <h5 class="text-center">Tabla de PERMISOS</h5>
    <thead class="" style="position: sticky;top: 0;">
       <tr class="text-center">
         <th>NOMINA</th>
         <th>NOMBRE DEL EMPLEADO</th>
         <th>COMPAÑIA</th>
         <th>FECHA PERMISO</th>
         <th>MOTIVO</th>
         <th>JEFE INMEDIATO</th>
         <th>ESTATUS</th>

       </tr>
    </thead>
    <tbody>
  ';
  foreach($query2 as $row)
        {
            $salida1.= "
            <tr>   
            <td class='text-center'>" . $row['nomina'] . "</td>
            <td class='text-center'>" . $row['name'] .' '.$row['apellido_Paterno'].' '.$row['apellido_Materno']."</td>
            <td class='text-center'>" . $row['descripcion'] . "</td>   
            <td class='text-center'>" . $row['fechaPermiso'] . "</td>   
            <td><div style='width:400px; overflow-y:scroll; text-align:left;'>" . $row['motivo'] . "</div></td>
            <td class='text-center'>" . $row['nombre'] . ' '.$row['apellidos']. "</td>   
            <td class='text-center'> <i class='fa-solid fa-circle-check' style='color:#12e52e;font-size:20px;'></i> </td>
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