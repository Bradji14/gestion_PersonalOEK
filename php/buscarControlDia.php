<?php
include_once "../bd/conexion.php";



$salida = "";

//  && 
if (!empty($_POST['nomina']) && !empty($_POST['fechaini']) && !empty($_POST['fechaFin'])) 
{

//   $consulta = $_POST['consulta'];
  $nomina = $_POST['nomina'];
  $fecha1 = $_POST['fechaini'];
  $fecha2 = $_POST['fechaFin'];
  // $sql = "SELECT nomina_emp,company, GROUP_CONCAT(count ORDER BY pase ASC ) AS 'asd' FROM (SELECT nomina_emp, pase,company, CONCAT(pase, count(nomina_emp)) AS count FROM listacontrol l WHERE company='Administrativo' AND nomina_emp='$nomina' AND fecha >= '$fecha1' AND fecha <= '$fecha2' GROUP BY pase, nomina_emp) A GROUP BY nomina_emp  ORDER BY nomina_emp";

  $sql = "SELECT COUNT(pase) AS 'total',l.pase,l.nomina_emp,e.name,e.name,e.apellido_Paterno,e.apellido_Materno,l.company,l.fecha 
  FROM listacontrol l INNER JOIN empleado e ON l.nomina_emp=e.nomina 
  WHERE fecha BETWEEN '$fecha1' AND '$fecha2' AND l.nomina_emp='$nomina' 
  AND pase !='0' GROUP BY L.nomina_emp,l.pase,l.fecha  
  HAVING COUNT(pase)>=1 ORDER BY e.name, fecha";

  $query = $conn->prepare($sql);
  $query->execute();


if ($resultado = $query->rowCount() > 0) {

  $salida .= '
  <div id="div2" class="mb-3">

       <table class="table tableAs">
       <h5 class="text-center">ASISTENCIAS</h5>
       <thead class="">
          <tr class="text-center" style="background:#1094d7;">
          
            <th>NOMINA</th>
            <th>ESQUEMA</th>
            <th>PASE</th>
            <th>FECHA</th>            
       
          </tr>
       </thead>
       <tbody>
     ';    
     while ($fila = $query->fetch(PDO::FETCH_ASSOC)) 
    {
        $salida .= "
        <tr>   
            <td class='text-center'>" . $fila['nomina_emp'] . "</td>
            <td class='text-center'>" . $fila['company'] . "</td>
            <td class='text-center'>" . $fila['pase'] . "</td>
            <td class='text-center'>" . $fila['fecha'] . "</td>


        </tr>";
      }    
    $salida.="</tbody></table></div></div>";
       
      }
   
  }
     
       
      
    
echo $salida;
// SELECT  l.nomina_emp,CONCAT(e.name,' ',e.apellido_Paterno,' ',e.apellido_Materno) AS NAME, 
// GROUP_CONCAT(l.pase ORDER BY fecha, pase SEPARATOR ',' ) AS roles FROM listacontrol l 
// INNER JOIN empleado e ON l.nomina_emp = e.nomina 
// WHERE nomina=1026 AND 
// GROUP BY nomina_emp ORDER BY nomina_emp
// SELECT COUNT(pase) AS 'total',l.pase,l.nomina_emp,e.name,l.company,l.fecha FROM listacontrol l INNER JOIN empleado e ON l.nomina_emp=e.nomina WHERE fecha BETWEEN '2022-11-30' AND '2022-12-01' AND l.nomina_emp=1026  GROUP BY L.nomina_emp,l.pase,l.fecha  HAVING COUNT(pase)>=1 ORDER BY e.name, fecha