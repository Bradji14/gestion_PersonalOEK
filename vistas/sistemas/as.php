<?php 
// gaurdar los datos recibidos a la bd
session_start();
include_once "../../bd/conexion.php";

   
if(isset($_POST['id']) && isset($_POST['control']) && isset($_POST['desc'])){


$nomina=$_POST['id'];
$con=$_POST['control'];
// $s=$_POST['fech'];
// $ptm=date("d-m-Y", strtotime($_POST['fech']));
$desc=$_POST['desc'];
// $fec=json_encode($JsonObject);

foreach( $nomina as $key => $n ) {
    // echo "The nomina is " . $n . " and estatus is " . $con[$key] . ", thank you y la fecha es".$_SESSION['fechaChida'].", y la desc es".$desc[$key]."<br>";
        $sql = "INSERT INTO listaControl(nomina_emp,pase,company,fecha) VALUES (?,?,?,?)";
        $query = $conn->prepare($sql);
        $query->execute([$n,$con[$key],$desc[$key],$_SESSION['fechaChida']]);
        $_SESSION['check']="Pase de lista realizado con exito";
        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/consulta_diaespecifico.php");


  }
}
else{
  echo "No hay registros de esa fecha";
}
//   SELECT COUNT(pase) AS 'total',l.pase,l.nomina_emp,e.name,l.company  FROM listacontrol l
//   INNER JOIN empleado e
//   ON l.nomina_emp=e.nomina
//   WHERE l.fecha>='01/12/2022' AND l.fecha <='03/12/2022' AND l.pase='A' AND l.company="Movistar" 
//   GROUP BY L.nomina_emp,l.pase HAVING COUNT(pase)>=1



// SELECT  l.nomina_emp,l.pase,l.company , GROUP_CONCAT(l.pase  ORDER BY fecha, pase separator '   ' ) AS roles
// FROM listacontrol l
// INNER JOIN empleado e 
// ON l.nomina_emp = e.nomina
// GROUP BY nomina_emp ORDER BY nomina_emp

// echo $_POST['ide'];
// $pt=$_POST['ide'];
// echo $_POST['idsa'];

// if(isset($_POST['id'])){

//     // $newDate = date("d/m/Y", strtotime($_POST['fecha_inicio']));
//     // $nomina=$_POST['id'];

   
//         foreach($_POST['id'] as $id){

//             echo "<p>Valor recibido: $id</p>";

//         }

      
        // $sql = "INSERT INTO prueba(nomina,control,fecha) VALUES (?,?,?)";
        // $query = $conn->prepare($sql);
        // $query->execute([$id,$con,null]);

        // header("Location:http://http://192.168.100.200:50//asistencias_empleados/vistas/hola.php");
    


// }

