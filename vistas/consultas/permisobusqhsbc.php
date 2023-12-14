<?php

  session_start();


// $sql = "SELECT * FROM empleado";

// $resultado = $conn->query($sql);


if(isset($_POST['save'])){
 
require "../../bd/conexion.php";
  // $_SESSION['error']="campos vacios";
    $empleado=$_POST['empleado'];
    $arae=$_POST['area'];
    // $name1=$_POST['nameo'];
    // $name2=$_POST['namet'];
    $jefe=$_POST['jefe'];
    $motivo=$_POST['motivo'];
    $numbers=$_POST['numbers'];
    $compa=$_POST['compa'];
    // $date=$_POST['dateP'];
    $newDate = $_POST["dateP"];
    // $newDate = date("d/m/Y", strtotime($_POST["dateP"]));
    $options=$_POST['options'];

    // $options=$_POST['options'];
    $fechaActual = date('Y-m-d');

    if(!empty($empleado) && !empty($arae) && !empty($jefe) && !empty($motivo) && !empty($newDate)
    && !empty($numbers) && !empty($options))
    {

        
      $sql="SELECT nomina FROM empleado WHERE nomina ='$empleado' ;";
      $query = $conn->prepare($sql);
      $query->execute();
      # Ver cuántas filas devuelve
      $numeroDeFilas = $query->rowCount();
      

      if($numeroDeFilas<=0){
        
        $_SESSION['nomina']="Nomina ingresada no valida";
        header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/hsbc/permisoshsbc.php");


      }else{
            $sql = "INSERT INTO permisos(id_nomina,id_area,id_jefe,motivo,tiempo_solicitado,fechaPermiso,company,estatus,created_at) VALUES (?,?,?,?,?,?,?,?,?)";
            $query = $conn->prepare($sql);
            $query->execute([$empleado,$arae,$jefe,$motivo,($numbers.' '.$options),$newDate,$compa,0,$fechaActual]);

            $_SESSION['listo']="Permiso agregado";
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/hsbc/permisoshsbc.php");

            $query3 = $conn->query("SELECT * FROM empleado INNER JOIN permisos ON empleado.nomina=permisos.id_nomina WHERE empleado.nomina='$empleado'");

            while ($row = $query3->fetch()) {
              $_SESSION['name']=$row['name'].' '.$row['apellido_Paterno'].' '.$row['apellido_Materno'];
          }

      }       
          
    }
    else{
      $_SESSION['vacio']="Campos vacios";
      header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/hsbc/permisoshsbc.php");
  
    }

}


?>