<?php
include_once "../bd/conexion.php";



$salida = "";
$salida2 = "";
$salidam = "";
$salidah="";



// nueva tabla PARA HSBC Y MOV
if (!empty($_POST['consulta']) && !empty($_POST['consultados']) && !empty($_POST['seleccion'])) 
{

  $consulta = $_POST['consulta'];
  $consulta_dos = $_POST['consultados'];
  $seleccion = $_POST['seleccion'];

 
  $sql="SELECT nomina,name, des,
  GROUP_CONCAT(count ORDER BY entrada ASC SEPARATOR ' - ' ) AS 'asd'
  
    FROM (SELECT l.nomina,entrada,c.descripcion as des, CONCAT(e.name,' ', e.apellido_Paterno,' ',e.apellido_Materno) AS name,CONCAT(entrada,count(l.nomina),',',salida,COUNT(l.nomina)) AS count     
      FROM pase l
      INNER JOIN empleado e ON l.nomina=e.nomina   
       INNER JOIN company c ON e.id_company_F= c.id_company 
       WHERE c.descripcion= '$seleccion' and  l.fecha_reg BETWEEN '$consulta' AND '$consulta_dos'
       GROUP BY entrada, l.nomina ) 
    A GROUP BY nomina ORDER BY nomina";
  $query = $conn->prepare($sql);
  $query->execute();

  

if ($resultado = $query->rowCount() > 0) {
   
  $salidam .= '
  <div class="row">
  <h6 class="text-center">SIMBOLOGIA</h6>

  <div class="col-md-12 d-flex justify-content-between mt-5 text-dark" style="font-size:20px">

      <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#0D5982"
              class="bi bi-circle-fill" viewBox="0 0 16 16">
              <circle cx="8" cy="8" r="8" />
          </svg> A- asistencias
      </p>
      <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#113B0D"
              class="bi bi-circle-fill" viewBox="0 0 16 16">
              <circle cx="8" cy="8" r="8" />
          </svg> S- salidas
      </p>
      <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#F06516"
              class="bi bi-circle-fill" viewBox="0 0 16 16">
              <circle cx="8" cy="8" r="8" />
          </svg> R- retardos
      </p>
      <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#E0F113"
              class="bi bi-circle-fill" viewBox="0 0 16 16">
              <circle cx="8" cy="8" r="8" />
          </svg> F- faltas por retardo
      </p>
      <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#E41A29"
              class="bi bi-circle-fill" viewBox="0 0 16 16">
              <circle cx="8" cy="8" r="8" />
          </svg> SA- salida anticipada
      </p>
  </div>


</div>

  
  <div id="div2" class="mb-3" style="height:200px; overflow-y:scroll;">
  
       <table class="table tableAs" id="example">
       <h5 class="text-dark text-center">ASISTENCIAS</h5>
       <thead class="" style=" position: sticky;
       top: 0;">
          <tr class="text-center">
            <th>NOMINA</th>
            <th>NOMBRE</th>
            <th>ESQUEMA</th>
            <th>ESTATUS</th>
          </tr>
       </thead>
       <tbody>
     ';    
    
     while ($fila = $query->fetch(PDO::FETCH_ASSOC)) 
    {
        $salidam .= "
        <tr>   
            <td class='text-center'>" . $fila['nomina'] . "</td>
            <td class='text-center'>" . $fila['name'] ."</td>
            <td class='text-center'>" . $fila['des'] . "</td>
            <td class='text-center'>". $fila['asd']."        "."</td>
        </tr>";
      }    
    $salidam.="</tbody></table></div></div>";
       
      }
    }
   




// if (!empty($_POST['consulta']) && !empty($_POST['consultados']) && !empty($_POST['seleccion'])) 
// {

//   $consulta = $_POST['consulta'];
//   $consulta_dos = $_POST['consultados'];
//   $seleccion = $_POST['seleccion'];


//   if($seleccion=='HSBC'){
    

//   $sql="SELECT nomina_emp,name,company, GROUP_CONCAT(count ORDER BY pase ASC SEPARATOR ' - ' ) AS 'asd' 
//   FROM (SELECT nomina_emp, pase, CONCAT(e.name,' ', e.apellido_Paterno,' ', e.apellido_Materno) AS name, company,CONCAT(pase,count(nomina_emp))AS count     
//   FROM listacontrol l
//   INNER JOIN empleado e ON l.nomina_emp=e.nomina           
//   WHERE company='$seleccion' AND fecha BETWEEN '$consulta' AND '$consulta_dos' AND pase !='0' GROUP BY pase, nomina_emp) 
//   A GROUP BY nomina_emp ORDER BY nomina_emp";
//   $query = $conn->prepare($sql);
//   $query->execute();

  

// if ($resultado = $query->rowCount() > 0) {
   
//   $salidah .= '
//   <div class="row">
//   <h6 class="text-center">SIMBOLOGIA</h6>

//   <div class="col-md-12 d-flex justify-content-between mt-5 text-dark" style="font-size:20px">

//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#0D5982"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> A- asistencias
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#113B0D"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> S- salidas
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#F06516"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> R- retardos
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#E0F113"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> F- faltas por retardo
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#E41A29"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> SA- salida anticipada
//       </p>
//   </div>


// </div>

  
//   <div id="div2" class="mb-3" style="height:200px; overflow-y:scroll;">
  
//        <table class="table tableAs">
//        <h5 class="text-dark text-center">ASISTENCIAS</h5>
//        <thead class="" style=" position: sticky;
//        top: 0;">
//           <tr class="text-center">
//             <th>NOMINA</th>
//             <th>NOMBRE</th>
//             <th>ESQUEMA</th>
//             <th>ENTRADAS</th>
//             <th>SALIDAS</th>
//           </tr>
//        </thead>
//        <tbody>
//      ';    
    
//      while ($fila = $query->fetch(PDO::FETCH_ASSOC)) 
//     {
//         $salidah .= "
//         <tr>   
//             <td class='text-center'>" . $fila['nomina'] . "</td>
//             <td class='text-center'>" . $fila['name'] . "</td>
//             <td class='text-center'>" . $fila['descripcion'] . "</td>
//             <td class='text-center'>". $fila['Entradas']."        "."</td>
//             <td class='text-center'>". $fila['Salidas']."        "."</td>

//         </tr>";
//       }    
//     $salidah.="</tbody></table></div></div>";
       
//       }
//     }
   
// }











// if (!empty($_POST['consulta']) && !empty($_POST['consultados']) && !empty($_POST['seleccion'])) 
// {

//   $consulta = $_POST['consulta'];
//   $consulta_dos = $_POST['consultados'];
//   $seleccion = $_POST['seleccion'];
  
//   $sql="SELECT nomina_emp,name,company, GROUP_CONCAT(count ORDER BY pase ASC SEPARATOR ' - ' ) AS 'asd' 
//   FROM (SELECT nomina_emp, pase, CONCAT(e.name,' ', e.apellido_Paterno,' ', e.apellido_Materno) AS name, company,CONCAT(pase,count(nomina_emp))AS count     
//   FROM listacontrol l
//   INNER JOIN empleado e ON l.nomina_emp=e.nomina           
//   WHERE company='$seleccion' AND fecha BETWEEN '$consulta' AND '$consulta_dos' AND pase !='0' GROUP BY pase, nomina_emp) 
//   A GROUP BY nomina_emp ORDER BY nomina_emp";

//   $query = $conn->prepare($sql);
//   $query->execute();

  

// if ($resultado = $query->rowCount() > 0) {
   
//   $salida .= '
//   <div class="row">
//   <h6 class="text-center">SIMBOLOGIA</h6>

//   <div class="col-md-12 d-flex justify-content-between mt-5 text-dark" style="font-size:20px">

//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#0D5982"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> A- asistencias
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#113B0D"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> S- salidas
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#F06516"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> R- retardos
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#E0F113"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> F- faltas por retardo
//       </p>
//       <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="#E41A29"
//               class="bi bi-circle-fill" viewBox="0 0 16 16">
//               <circle cx="8" cy="8" r="8" />
//           </svg> SA- salida anticipada
//       </p>
//   </div>


// </div>
  
//   <div id="div2" class="mb-3" style="height:200px; overflow-y:scroll;">
  
//        <table class="table tableAs">
//        <h5 class="text-dark text-center">ASISTENCIAS</h5>
//        <thead class="" style=" position: sticky;
//        top: 0;">
//           <tr class="text-center">
//             <th>NOMINA</th>
//             <th>NOMBRE</th>
//             <th>ESQUEMA</th>
//             <th>ESTATUS</th>
            
//           </tr>
//        </thead>
//        <tbody>
//      ';    
    
//      while ($fila = $query->fetch(PDO::FETCH_ASSOC)) 
//     {
//         $salida .= "
//         <tr>   
//             <td class='text-center'>" . $fila['nomina_emp'] . "</td>
//             <td class='text-center'>" . $fila['name'] . "</td>
//             <td class='text-center'>" . $fila['company'] . "</td>
//             <td class='text-center'>". $fila['asd']."        "."</td>
//         </tr>";
//       }    
//     $salida.="</tbody></table></div></div>";
       
//       }
   
//       }





    if (!empty($_POST['consulta']) && !empty($_POST['consultados']) && !empty($_POST['seleccion'])) 
{

  $consulta = $_POST['consulta'];
  $consulta_dos = $_POST['consultados'];
  $seleccion = $_POST['seleccion'];
  // $control = $_POST['controls'];
  $sql3= "SELECT  e.name, p.id_jefe, e.nomina,j.nombre,j.apellidos,j.id, e.apellido_Paterno,
  e.apellido_Materno,p.company,p.id_permiso, p.fechaPermiso, p.motivo, p.tiempo_solicitado,
  c.descripcion from empleado e  
  INNER JOIN permisos p ON e.nomina = p.id_nomina 
  INNER JOIN company c ON e.id_company_F=c.id_company 
  INNER JOIN jefes_empresa j ON p.id_jefe= j.id 
  WHERE p.estatus=1 AND p.company = '$seleccion'  
  AND fechaPermiso BETWEEN '$consulta' AND '$consulta_dos' ORDER BY nomina ";
  $query3 = $conn->prepare($sql3);
  $query3->execute();
 

  

if ($resultado = $query3->rowCount() > 0) {
   
  $salida2 .= '

  
  <div id="div2" class="mb-3 mt-5" style="height:200px; overflow-y:scroll;">

       <table class="table tableAs">
       <h5 class="text-center text-dark">PERMISOS AURTORIZADOS</h5>
       <thead class="" style=" position: sticky;
       top: 0;">
          <tr class="text-center">
          <th class="text-center">NOMINA <br>EMPLEADO</th>
          <th class="text-center">NOMBRE <br> EMPLEADO</th>
          <th class="text-center">ESQUEMA</th>
          <th class="text-center">JEFE INMEDIATO</th>
          <th class="text-center">TIEMPO SOLICITADO</th>
          <th class="text-center">MOTIVO</th>
          <th class="text-center">FECHA PERMISO</th>
          </tr>
       </thead>
       <tbody>
     ';    
    
     while ($fila = $query3->fetch(PDO::FETCH_ASSOC)) 
    {
        $salida2 .= "
        <tr>   
            <td class='text-center'>" . $fila['nomina'] . "</td>
            <td class='text-center'>".$fila['name'] .' '.$fila['apellido_Paterno'].' '.$fila['apellido_Materno']."</td>
            <td class='text-center'>" . $fila['company'] . "</td>
            <td class='text-center'>".$fila['nombre'].' '.$fila['apellidos']."</td>
            <td class='text-center'>".$fila['tiempo_solicitado']."</td>
            <td class='text-center'>
                <div style='height:100px; overflow-y:scroll; text-align:left;'>".
                    $fila['motivo']."</div>
            </td>
            <td class='text-center'>".$fila['fechaPermiso']."</td>
        </tr>";
      }    
    $salida2.="</tbody></table></div></div>";
       
      }
   
      }

    
// echo $salida;
echo $salidam;
// echo $salidah;
echo $salida2;



?>